// DOCTOR_NAME is available as a global variable from PHP SESSIONS

class ReportTemplate {
    
    constructor(name){
        this.reportName = name;
    }

    addField(fieldName,value){
        this[fieldName] = value;
    }

    addFromArray(array){
        array.forEach( (identifier, index) => {
            let field = { sequence: index, value: null };
            this.addField(identifier,field);

            Object.defineProperty(this, identifier ,{
                get: function() { return identifier },
                set: function(value){ identifier = value },
            });
        });
    }
}

class CovidTemplate extends ReportTemplate { 

    constructor(name){
        super(name);

        const covidTemplateFields = [
            "reportID","reportTitle","patientName", 
            "dateOfBirth", "gender", "patientEmail", "bloodGroup",
            "reasonsForTesting", "dateOfTest", "typeOfTest",
            "symptoms", "testResults", "remarks", "doctorName", "doctorEmail",
            "generatedDate", "patientID", "doctorID", 
        ];
        
        super.addFromArray(covidTemplateFields);

        this.remarks = "None";

        // Blank ???
    }

    HTML(){
    
        return `
        <div class="container">
            <span class="report-id-field">
                <span class="justify-end">Report ID: <b>${this.reportID}</b></span>
            </span>
            <h1 class="title">${this.reportTitle}</h1>
            <form>
                <img src="images/coronavirus-blue.png" class="background-image" alt="">

                <div class="inner-container">
                    <span class="inner-title">Personal Information</span>
                    <span class="field-container span-two">
                        <span class="field-title">Name of Patient</span>
                        <span class="input-field">${this.patientName}</span>
                    </span>

                    <span class="field-container">
                        <span class="field-title">Date of Birth</span>
                        <span class="input-field">${this.dateOfBirth}</span>
                    </span>

                    <span class="field-container">
                        <span class="field-title">Gender</span>
                        <span class="input-field">${this.gender}</span>
                    </span>

                    <span class="field-container span-three">
                        <span class="field-title">Email</span>
                        <span class="input-field">${this.patientEmail}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Blood Group</span>
                        <span class="input-field">${this.bloodGroup}</span>
                    </span>

                </div>

                <div class="inner-container">
                    <span class="inner-title">Test Information</span>
                    <span class="field-container span-two">
                        <span class="field-title">Reason for Testing</span>
                        <span class="input-field">${this.reasonsForTesting}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Date of Test</span>
                        <span class="input-field">${this.dateOfTest}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Type of Test</span>
                        <span class="input-field">${this.typeOfTest}</span>
                    </span>

                    <span class="field-container span-four">
                        <span class="field-title">Symptoms</span>
                        <span class="input-field">${this.symptoms}</span>
                    </span>
                </div>

                <div class="inner-container">
                    <span class="inner-title">Result Information</span>
                    <span class="field-container span-four">
                        <span class="field-title">Results</span>
                        <div class="input-field">${this.testResults}</div>
                    </span>

                    <span class="field-container span-four">
                        <span class="field-title">Doctor Remarks and Comments</span>
                        <div class="input-field">${this.remarks}</div>
                    </span>

                    <span class="field-container span-two">
                        <span class="field-title">Doctor Name</span>
                        <span class="input-field">${this.doctorName}</span>
                    </span>

                    <span class="field-container span-two">
                        <span class="field-title">Doctor Email</span>
                        <span class="input-field">${this.doctorEmail}</span>
                    </span>
                </div>

                <span class="report-id-field" id="generated-date">
                    <span class="justify-start">Generated Date: <b>${this.generatedDate}</b></span>
                </span>
            </form>
        </div>
`
    }
}

class HBPReportTemplate extends ReportTemplate { 

    constructor(name){
        super(name);

        const HBPTemplateFields = [
            "reportID","reportTitle","patientName", 
            "dateOfBirth", "gender", "patientEmail",
            "bloodGroup", "BPMeasurementA", "BPMeasurementB",
            "BPMeasurementC", "medication", "remarks", "doctorName", 
            "doctorEmail", "generatedDate", "patientID", "doctorID",
        ];
        
        super.addFromArray(HBPTemplateFields);

        this.remarks = "None";
    }

    HTML(){
    
        return `
        <div class="container" id="container">
        <span class="report-id-field">
            <span class="justify-end">Report ID: <b>${this.reportID}</b></span>
        </span>
        <h1 class="title">${this.reportTitle}</h1>
        <form action="">
            <img src="images/blood-pressure-blue.png" class="background-image" alt="">

            <div class="inner-container">
                <span class="inner-title">Personal Information</span>
                <span class="field-container span-two">
                    <span class="field-title">Name of Patient</span>
                    <span class="input-field">${this.patientName}</span>
                </span>

                <span class="field-container">
                    <span class="field-title">Date of Birth</span>
                    <span class="input-field">${this.dateOfBirth}</span>
                </span>

                <span class="field-container">
                    <span class="field-title">Gender</span>
                    <span class="input-field">${this.gender}</span>
                </span>

                <span class="field-container span-three">
                    <span class="field-title">Email</span>
                    <span class="input-field">${this.patientEmail}</span>
                </span>

                <span class="field-container span-one">
                    <span class="field-title">Blood Group</span>
                    <span class="input-field">${this.bloodGroup}</span>
                </span>
            </div>

            <div class="inner-container">
                <span class="inner-title">Result Information</span>

                <div class="inner-container span-two alone">
                   <span class="field-container">
                        <span class="field-title inner-title">Blood Pressure Measurement A</span>
                        <span class="input-field">${this.BPMeasurementA}</span>
                    </span> 
                </div>

                <div class="inner-container span-two alone">
                    <span class="field-container">
                         <span class="field-title inner-title">Blood Pressure Measurement B</span>
                         <span class="input-field">${this.BPMeasurementB}</span>
                     </span> 
                 </div>

                <div class="inner-container span-two alone">
                    <span class="field-container alone">
                         <span class="field-title inner-title">Blood Pressure Measurement C</span>
                         <span class="input-field">${this.BPMeasurementC}</span>
                     </span> 
                </div>

                <span class="field-container span-four">
                    <span class="field-title">Medication</span>
                    <div class="input-field">${this.medication}</div>
                </span>

                <span class="field-container span-four">
                    <span class="field-title">Doctor Remarks and Comments</span>
                    <div class="input-field">${this.remarks}</div>
                </span>

                <span class="field-container span-two">
                    <span class="field-title">Doctor Name</span>
                    <span class="input-field">${this.doctorName}</span>
                </span>

                <span class="field-container span-two">
                    <span class="field-title">Doctor Email</span>
                    <span class="input-field">${this.doctorEmail}</span>
                </span>
            </div>

            <span class="report-id-field" id="generated-date">
                <span>Generated Date: <b>${this.generatedDate}</b></span>
            </span>
        </form>
    </div>
`
    }
}

let targetInputElement;
let listOfUsersContainer;
let targetForm;
let patient;
let selectedReportID;

handleHealthReportsUI();  // Set the UI

let canvasElementClass = ".pdf-viewer";
const initialReportState = {
	pdfDoc: null,
	currentPage: 1,
	pageCount: 0,
	zoom: 3,
};

let covidTemplate = new CovidTemplate("Covid");
let hbpReportTemplate = new HBPReportTemplate("High Blood Pressure");

function forwardReportToPatient(e){
    let reportItemButtons = e.parentElement;
    let reportItem = e.parentElement.parentElement;
    let spinner = reportItem.querySelector(".sk-bounce");
    let finalView = reportItem.querySelector(".disabled-view");

    function forwardAnimation(buttonMessage,dataErrorAttribute){
        hide(spinner);
        finalView.setAttribute("data-error",dataErrorAttribute);
        finalView.textContent = buttonMessage;
        show(finalView);

        setTimeout(() => {
            // Delete reportItem element node
        }, 5000);
    }

    let forwardDocument = new Promise((resolve,reject) => {
        let result = Math.round(Math.random()); // TODO: forward document

        setTimeout(() => {
            if (result) resolve("yes");
            else reject("no"); // TODO: get the errors working
        },5000);

    }); 

    hide(reportItemButtons);
    show(spinner);

    forwardDocument.then( result => {
        forwardAnimation("Forwarded Successfully","false");
    }).catch( () => {
        forwardAnimation("Error Forwarding","true");
        setTimeout(() => {
            hide(finalView);
            gridShow(reportItemButtons);
        }, 5000);
    })
}

async function deleteReport(){
    let filepath = await fetchReportDetails(selectedReportID);

    let deletePromise = new Promise((resolve,reject) => {
        let params = `report_id=${reportID}&&file_path_name=${filepath}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report.delete.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let deleteDetails = JSON.parse(this.responseText);

                console.log(deleteDetails);

                if(deleteDetails == "file and record deleted") resolve();
                else { reject(deleteDetails) };
            }
            else{
                reject("Error Deleting Report");
            }
        }

        xhr.send(params);
    });

    deletePromise.then(() => {
        // animation && closing of popup
        // reloading the UI with handleHealthReportsUI()
    });
}

function deleteAnimation(e) {
    e.setAttribute("data-animation","true");
}

async function reviewReport(e){

    let reviewReportOverlay = find(".report-review-overlay");
    selectedReportID = e.parentElement.parentElement.getAttribute("data-report-id");

    show(reviewReportOverlay);

    reviewReportOverlay.style.alignItems = "center";
    hide(find(".report-review-popup"));
    hide(find(".delete-pdf-button"));
    gridShow(find(".pdf-viewer-loader"));

    let url = await fetchReportDetails(selectedReportID);
    
    pdfjsLib
        .getDocument({ url, password: "" })
        .promise.then((data) => {
            initialReportState.pdfDoc = data;
            console.log('pdfDocument', initialReportState.pdfDoc);

            renderReport( canvasElementClass );
        })
        .catch((err) => {
            alert(err.message);
        });

}

function handleHealthReportsUI() {

    let loader = `
        <div class="initial-loader">
            <div class="sk-bounce">
                <div class="sk-bounce-dot"></div>
                <div class="sk-bounce-dot"></div>
            </div>
        </div>
    `;

    find(".local-report-list").innerHTML = loader;


    let preHTMLContent = `
    <div class="local-report-list-header">
        <h1 class=" report-title small-font green-font">Health Reports For Patients</h1>
        <span class="add-patient-report" onclick="addNewReport()">
            <span>Create New Report</span>
            <img src="images/plus.png" alt="">
        </span>
    </div>`;

    let fetchReportsPromise = fetchReports("doctor_id",DOCTOR_ID,"doctor");

    fetchReportsPromise.then((reports) => {

        // reports is a list of data
        // call a render function
        let reportsHTML = "";
        
        for( i = 0; i < reports.length; i++){
            reportsHTML += renderReportRecord(i+1,reports[i]);
        }

        let innerHTML = preHTMLContent + reportsHTML;
        
        find(".local-report-list").innerHTML = innerHTML;


    }).catch( error => console.log(error))


    function renderReportRecord(itemNumber,details){

        let reportRecordHTMLTemplate = `
            <div class="report-item" data-report-id=${details.report_id}>
                <div class="report-item-itemization green-font">${itemNumber}.</div>
                <div class="report-item-name green-font">${details.report_type} -- ${details.patient_name}</div>
                <div class="report-item-buttons forward-loader">
                    <div class="report-button review light-green-bg" onclick="reviewReport(this)">Review</div>
                    <div class="report-button review green-bg" onclick="forwardReportToPatient(this)">Forward To Patient</div>
                </div>
                <div class="sk-bounce hidden-at-launch">
                    <div class="sk-bounce-dot"></div>
                    <div class="sk-bounce-dot"></div>
                </div>
                <span href="#" class="disabled-view hidden-at-launch select-none" disabled>Forwarded Successfully</span>
            </div>`;
        
        return reportRecordHTMLTemplate;

    }

}

async function fetchReportDetails(reportID){

    let path = "./reports/";

    return new Promise((resolve,reject) => {
        let params = `report_id=${reportID}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report-details.fetch.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let reportDetails = JSON.parse(this.responseText);

                let filename = reportDetails[0].filename;

                if(filename == "") reject("Report Does Not Exist");
                else { resolve(path+filename) }
            }
            else{
                reject("Error Fetching User Details");
            }
        }

        xhr.send(params);

    });

}

async function fetchReports(field_name,field_value,status) { 

    return new Promise((resolve,reject) => {
        
        if(field_name && field_value && status){
            let params = `field_name=${field_name}&&field_value=${field_value}&&status=${status}`;
            let xhr = new XMLHttpRequest();

            xhr.open("POST", "include/reports.fetch.php", true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function(){
                let reports;
                if( this.status == 200 ){
                    reports = JSON.parse(this.responseText);
                    if(reports) resolve(reports);
                }
                else reject("Error Fetching Users");
            } 
            xhr.send(params);
        }
    });

}

function sendMetadataToDatabase( template, filename ){

    return new Promise((resolve, reject) => {

        let reportTitle = template.reportTitle.split(" ").join("-");
     
        let params = `report_id=${template.reportID}&&`+
        `patient_id=${template.patientID}&&`+
        `doctor_id=${template.doctorID}&&`+
        `filename=${filename}&&`+
        `patient_name=${template.patientName}&&`+
        `report_type=${reportTitle}&&`+
        `doctor_email=${template.doctorEmail}&&`+
        `status=doctor&&`+
        `created_date=${unformattedDate()}`;

        let xhr = new XMLHttpRequest();
        
        xhr.open("POST", "include/add-report.post.php", true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let message = this.responseText;

                if(message == "success") resolve();
                else reject();
            }
            else{
                reject();
            }
        }

        xhr.send(params);
    });
}

async function setHBPData() {
    
    hbpReportTemplate.reportTitle = "High blood Pressure Report"; // never changes
    hbpReportTemplate.reportID = uniqueID(); // generated
    hbpReportTemplate.generatedDate = formattedDate(); // generated
    
    hbpReportTemplate.doctorName = DOCTOR_NAME; // available as global variable
    hbpReportTemplate.doctorEmail = DOCTOR_EMAIL; // available as global variable
    hbpReportTemplate.doctorID = DOCTOR_ID; // available as global variable
    
    // fetched from patient
    hbpReportTemplate.patientID = patient.ID; 
    hbpReportTemplate.patientName = patient.Name;
    hbpReportTemplate.dateOfBirth = patient.DOB.split("-").reverse().join(" / ");
    hbpReportTemplate.gender = patient.Sex;
    hbpReportTemplate.patientEmail = patient.Email;
    hbpReportTemplate.bloodGroup = patient.BGroup;
    
    hbpReportTemplate.BPMeasurementA = "120/20"; // Entered Data
    hbpReportTemplate.BPMeasurementB = "150/30";
    hbpReportTemplate.BPMeasurementC = "180/40";
    
    hbpReportTemplate.medication = "Lisiprinol";
    hbpReportTemplate.remarks = "Patient should drink more orange juice";

    // TODO: Finish Off
}

async function setCovidData() {
    covidTemplate.reportTitle = "Covid 19 Report"; // never changes
    covidTemplate.reportID = uniqueID(); // generated
    covidTemplate.generatedDate = formattedDate(); // generated
    
    covidTemplate.doctorName = DOCTOR_NAME; // available as global variable
    covidTemplate.doctorEmail = DOCTOR_EMAIL; // available as global variable
    covidTemplate.doctorID = DOCTOR_ID;
    
    covidTemplate.patientID = patient.ID;
    covidTemplate.patientName = patient.Name; // fetched from patient
    covidTemplate.dateOfBirth = patient.DOB.split("-").reverse().join(" / ");
    covidTemplate.gender = patient.Sex;
    covidTemplate.bloodGroup = patient.BGroup;
    covidTemplate.patientEmail = patient.Email;
    
    // Entered Data
    covidTemplate.reasonsForTesting = targetForm.querySelector('.patient-reason-for-testing').value;
    covidTemplate.dateOfTest = targetForm.querySelector('.patient-date-of-test').value.split("-").reverse().join(" / ");
    covidTemplate.typeOfTest = targetForm.querySelector('.patient-type-of-test').value;
    covidTemplate.symptoms = targetForm.querySelector('.patient-symptoms').value;
    covidTemplate.testResults = targetForm.querySelector('.patient-result').value;
    covidTemplate.remarks = targetForm.querySelector('.doctor-remarks').value;
}

async function generateReportByTemplate(template){

    let { fileBlob, filename } = await generatePDF(template);
    await uploadPDF( fileBlob, filename );
    await sendMetadataToDatabase(template,filename);

}
    
async function createReport(type,e){

    if( isRequiredFieldsEmpty(e.parentElement) ) return;

    let createReportButton = e;
    let createReportLoader = e.parentElement.querySelector(".create-report-loader");
    let template;
    
    switch (type) {
        case 'covid':
            await setCovidData();
            template = covidTemplate;
        break;
        case 'hbp':
            await setHBPData();
            template = hbpReportTemplate;
        break;
        default:
            console.log("Template Does Not Exist");
        break;
    }

    hide(createReportButton);
    show(createReportLoader);

    let generateResponse = generateReportByTemplate(template);
        
    generateResponse.then(() => {
            setTimeout(() => {
                hide(createReportLoader);
                createReportButton.setAttribute("data-error","false");
                createReportButton.textContent = "Report Created Successfully";
                createReportButton.disabled = "true"; 
                show(createReportButton);

                setTimeout(() => {
                closeAllTemplates();
                createReportButton.removeAttribute('disabled');
                resetPDFReportForm(e.parentElement);
                handleHealthReportsUI();
                },3000);
            },3000);
    }).catch(( error ) => {

        console.log(error);

        setTimeout(() => {
            hide(createReportLoader);
            show(createReportButton);
            createReportButton.setAttribute("data-error","true");
            createReportButton.removeAttribute('disabled');
            createReportButton.textContent = "Retry Creating Report";
            createReportButton.setAttribute('data-error',"");
        },2000);
    });
}

function setName(e){

    let person = {
        id: e.getAttribute('data-id'),
        name: e.getAttribute('data-name'),
    }

    targetInputElement.value = person.name;
    listOfUsersContainer.style.display = "none";
    targetInputElement.setAttribute('disabled',true);

    // fetch user details
    fetchUser(person.id)
        .then( data => {
            targetForm.querySelector('.patient-dob').setAttribute("type","date");
            targetForm.querySelector('.patient-dob').value = data.DOB;

            targetForm.querySelector('.patient-gender').value = data.Sex;
            targetForm.querySelector('.patient-blood-group').value = data.BGroup;
            targetForm.querySelector('.patient-email').value = data.Email;

            targetForm.querySelector('.doctor-name').value = DOCTOR_NAME;
            patient = data;
        })
        .catch( error => {
            // TODO: display an error box???
            console.log(error);
    });
}

function fetchUsers(inputElement) {

    targetInputElement = inputElement;
    listOfUsersContainer = targetInputElement.parentElement.querySelector(".search-list-of-users");
    targetForm = targetInputElement.parentElement.parentElement;

    let result = new Promise((resolve,reject) => {
        
        if(inputElement.value != ""){
            let params = `Name=${inputElement.value}`;
            let xhr = new XMLHttpRequest();

            xhr.open("POST", "include/patient-name.fetch.php", true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function(){
                let users;
                if( this.status == 200 ){
                    console.log(this.responseText);
                    users = JSON.parse(this.responseText);

                    if(users.length != 0) resolve(users);
                    else {
                        listOfUsersContainer.style.display = 'none';
                    }
                }
                else reject("Error Fetching Users");
            } 
            xhr.send(params);
        }
        else{ listOfUsersContainer.style.display = 'none'; }
    });

    result.then( data => listAvailableUsers(data) );

}

function fetchUser(id) {

    return new Promise((resolve,reject) => {

        let params = `id=${id}`;
        let xhr = new XMLHttpRequest();
        
        xhr.open("POST", "include/patient-details.fetch.php", true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let userDetails = JSON.parse(this.responseText);

                if(userDetails.length == 0) 
                    throw new Error('userDetails Came Empty');
                else 
                    resolve(userDetails[0]);
            }
            else{
                reject("Error Fetching User Details");
            }
        }

        xhr.send(params);
    });

}

function listAvailableUsers(array){
    let usersHTML = ``;
    array.forEach( object => usersHTML += `<div class="searched-user-item" onclick="setName(this)" data-name="${object['Name']}" data-id=${object['ID']}>${object['Name']}</div>` );
    listOfUsersContainer.innerHTML = usersHTML;
    listOfUsersContainer.style.display = 'block';
}

async function generatePDF( template ) {

    let templateName = ((template.reportName).trim()).split(" ").join("-");
    let filename = `${templateName}-Report@${template.reportID}.pdf`;
    let HTMLTemplate = template.HTML();

    let fileBlob = await html2pdf().set({ html2canvas: { scale: 5 } }).from(HTMLTemplate).output('blob'); // promise

    return { fileBlob, filename };

}

function uploadPDF(PDFFile,filename){

    let formData = new FormData();
        formData.append('pdf', PDFFile, filename);

    return new Promise((resolve,reject) => {
        $.ajax('include/upload-report.script.php', {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){ 
                console.log("success uploading");
                console.log(data);
                resolve("Report Created Successfully") },
            error: function(data){ 
                console.log("error uploading");
                console.log(data);
                reject("Error Creating Report") }
        });
    });
}

function uniqueID(){
    const date = Date.now();
    const dateReversed = parseInt(String(date).split("").reverse().join(""));

    const base36 = number => (number).toString(36);

    return base36(dateReversed) + base36(date);
}

function formattedDate(){
    const date = new Date();
    const day = String(date.getDate());
    const month = String(date.getMonth() + 1);
    const year = date.getFullYear();
    return `${day.padStart(2,"0")} / ${month.padStart(2,"0")} / ${year}`;
}

function unformattedDate(){
    const date = new Date();
    const day = String(date.getDate());
    const month = String(date.getMonth() + 1);
    const year = date.getFullYear();
    return `${year}-${month.padStart(2,"0")}-${day.padStart(2,"0")}`;
}

const renderReport = (canvasElementClass) => {
	// Load the first page.
	console.log(initialReportState.pdfDoc, 'pdfDoc');
	initialReportState.pdfDoc
		.getPage(initialReportState.currentPage)
		.then((page) => {
			// console.log('page', page);

			const canvas = document.querySelector(canvasElementClass);
			const ctx = canvas.getContext('2d');
			const viewport = page.getViewport({
				scale: initialReportState.zoom,
			});

			canvas.height = viewport.height;
			canvas.width = viewport.width;

			// Render the PDF page into the canvas context.
			const renderCtx = {
				canvasContext: ctx,
				viewport: viewport,
			};
            
            // wait for 2s then show pdf
            
            console.log(page.render(renderCtx));

			setTimeout(() => {
                hide(find(".pdf-viewer-loader")); // Hide Loader 
                find(".report-review-overlay").style.alignItems = "start";
                show(find(".report-review-popup"));
                show(find(".delete-pdf-button"));
            }, 7000);

		});

	// return new Promise();
};

function randomTimeInterval(min, max) { return Math.floor(Math.random() * (max - min + 1) + min) }
function hide(element){ element.style.display = "none"; }
function show(element){ element.style.display = "block"; }
function gridShow(element){ element.style.display = "grid"; }
function find(element){ return document.querySelector(element) };
function findAll(elements){ return document.querySelectorAll(elements) };