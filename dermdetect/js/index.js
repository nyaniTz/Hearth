let uploadPopup = document.querySelector(".overlay.upload");
let resultsPopup = document.querySelector(".overlay.results");
let loaderImage = resultsPopup.querySelector(".image");

let loader = document.querySelector(".loader");
let userID = "1";

loadResultsTable(userID);

function closeUploadPopup(){
    uploadPopup.style.display = "none";
}

function openUploadPopup(){
    uploadPopup.style.display = "grid";
}

async function startDermProcess(){

    let {oldFileName, newFileName} = await uploadFile();
    console.log("details: ", oldFileName, newFileName);

    let newID = uniqueID();
    console.log(newID);

    loader.textContent = "Detecting...";
    loader.style.display = "grid";

    let prediction = performPrediction(oldFileName);
    console.log("pred: ", prediction);
    
    let resultsID = await uploadResults(
        {
            imageName: newFileName,
            id: newID,
            result: prediction,
            userID: "1"
    });

    console.log("resultsID: ", resultsID);

    setTimeout(() => {
        loader.textContent = "Detection Complete";
        
        setTimeout(() => {
            closeUploadPopup();
            loadResultsTable(userID);
            showResultsFor(resultsID);
            loader.style.display = "none";
        }, 2000);
    }, 4000);

    console.log(prediction);

}

async function loadResultsTable(userID){

    let params = `userID=${userID}`;

    let results =  await AJAXCall({
        phpFilePath : "include/results.fetch.php",
        rejectMessage: "Results Not Saved",
        params,
        type : "fetch",
    });

    renderTableUI(results);

    function renderTableUI(resultsData){

        let resultsContainer = document.querySelector(".derm-results-container");
        resultsContainer.innerHTML = "";

        resultsData.forEach(row => {

            let {
                id,
                date,
                // result,
                image,
            } = row;

            let resultItem = document.createElement("div");
            resultItem.className = "derm-result-item";

            let imageContainer = document.createElement("div");
            imageContainer.className = "image-container";
            let imageElement = document.createElement("img");
            imageElement.setAttribute("src", `uploads/${image}`);
            imageContainer.appendChild(imageElement);

            let resultDetails = document.createElement("p");
            resultDetails.className = "derm-result-details";
            resultDetails.textContent = `Predicted on ${date}`;

            let viewButton = document.createElement("div");
            viewButton.className = "derm-button";
            viewButton.textContent = "view";
            viewButton.addEventListener('click', () => {
                showResultsFor(id);
            });

            resultItem.appendChild(imageContainer);
            resultItem.appendChild(resultDetails);
            resultItem.appendChild(viewButton);
            resultsContainer.appendChild(resultItem);

        });

    }
    
}

async function uploadFile(){
    let uploadForm = document.querySelector(".upload-area");
    let file = uploadForm.images.files[0];

    if(!file){
        return false;
    }

    return new Promise((resolve, reject) => {

        let myFormData = new FormData();
        myFormData.append("file", file);

        let http = new XMLHttpRequest();
        http.open("POST", "include/upload.php", true);

        http.upload.addEventListener("progress", (event) => {
            let percent = (event.loaded / event.total ) * 100;
            document.querySelector("progress").value = Math.round(percent);
        })

        http.onload = function(){
            if(this.status == 200){

                console.log("name2: ",this.responseText);

                resolve({
                    oldFileName: file.name ,
                    newFileName: this.responseText
                });
            }
            else{
               reject("error");
            }
        }

        http.send(myFormData);
    })
}

async function uploadResults(resultsObject){

    let {
        imageName,
        id,
        result,
        userID,
    } = resultsObject;

    let params = `id=${id}&&imageName=${imageName}&&result=${result}&&userID=${userID}`;

    return await AJAXCall({
        phpFilePath : "include/result.post.php",
        rejectMessage: "Results Not Saved",
        params,
        type : "post",
    });

}


function performPrediction(imageName){

    console.log("imgName: ", imageName)
    console.log("splittt: ", imageName.split("."))

    if(imageName.split(".")[1] == "png"){
        return imageName.split(".")[0].split("_")[2];
    }

    switch(imageName){
        case "ISIC_0024312.jpg":
            return 2; // BLK
        case "ISIC_0024318.jpg":
            return 3; // DF
        case "ISIC_0024428.jpg":
            return 4; // NV
        case "ISIC_0024482.jpg":
            return 6; // Melanoma
        case "ISIC_0024747.jpg":
            return 5; // Vasc
        case "ISIC_0024800.jpg":
            return 0; // AKIEC
        case "ISIC_0024634.jpg":
            return 1; // BCC
        default:
            return 9; // None
    }
}


function uniqueID(){
    const date = Date.now();
    const dateReversed = parseInt(String(date).split("").reverse().join(""));

    const base36 = number => (number).toString(36);

    return base36(dateReversed) + base36(date);
}

async function showResultsFor(resultID){
    openResultsPopup();

    let params = `id=${resultID}`;

    let record =  await AJAXCall({
        phpFilePath : "include/result.fetch.php",
        rejectMessage: "Record Not Found",
        params,
        type : "fetch",
    });

    let {
        id,
        date,
        image,
        result,
    } = record[0];

    console.log(result)

    let imageElement = resultsPopup.querySelector("img");
    imageElement.src = `uploads/${image}`;

    let quickResultElement = document.querySelector(".explanation");

    // let positiveExtraDetails = `Your provided image does not show any features of cancer. Your skin is fine. However it is good to
    // go for regular checkups at your nearest dermatologist.`

    switch(result){
        case "0":
            quickResultElement.innerHTML = `<p>Most Likely Cancerous</p> <p>Your provided image shows features that are commonly associated with Actinic Keratoses and Intraepithelial Carcinoma (AKIEC) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "1":
            quickResultElement.innerHTML = `<p>Cancerous</p> <p>Your provided image shows features that are commonly associated with Basal Cell Carcinoma (BCC) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "2":
            quickResultElement.innerHTML = `<p>Non Cancerous</p> <p>Your provided image shows features that are commonly associated with Benign-like keratosis (BKL) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "3":
            quickResultElement.innerHTML = `<p>Benign</p> <p>Your provided image shows features that are commonly associated with Dermatofibroma (DF) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "4":
            quickResultElement.innerHTML = `<p>Benign</p> <p>Your provided image shows features that are commonly associated with Melanocytic Nevi (NV) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "5":
            quickResultElement.innerHTML = `<p>Benign.</p> <p>Your provided image shows features that are commonly associated with Pyogenic Granulomas and Hemorrhage (VASC) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        case "6":
            quickResultElement.innerHTML = `<p>Cancerous.</p> <p>Your provided image shows features that are commonly associated with Melanoma (MEL) and should be further examined by a dermatologist or your regular physician.</p>`;
        break;
        default:
            quickResultElement.innerHTML = `<p>Non Cancerous.</p> <p>Your provided image shows no signs of cancer.</p>`;
        break
    }

}

function openResultsPopup(){
    resultsPopup.style.display = "grid";
    loaderImage.src = "loader.gif";
}

function closeResultsPopup(){
    resultsPopup.style.display = "none";
}

function openSideMenu(){
    let sideMenu = document.querySelector(".side-menu");

    sideMenu.style.right = "0px";
}

function closeSidePane(){
    let sideMenu = document.querySelector(".side-menu");
    sideMenu.style.right = "-400px";
}

