import { CovidTemplate, HBPReportTemplate } from "ReportTemplates";
import { uniqueID, formattedDate, exposeEventListeners,
         hide, show, gridShow, find } from "UtilFunctions";
import { fetchReportDetails, fetchReports, sendMetadataToDatabase, fetchUser } from "PostFunctions";
import { loadReport, generateReportByTemplate } from "ReportFunctions";

let targetInputElement;
let listOfUsersContainer;
let targetForm;
let patient;
let selectedReportID;
let covidTemplate = new CovidTemplate("Covid");
let hbpReportTemplate = new HBPReportTemplate("High Blood Pressure");

handleHealthReportsUI();  // Set the UI

async function deleteReport(eventButton){ // postfunction

    eventButton.setAttribute("data-animation","true");

    let details = await fetchReportDetails(selectedReportID);
    let filepath = "../reports/" + details.filename; // going up a directory

    let deletePromise = new Promise((resolve,reject) => {
        let params = `report_id=${selectedReportID}&&file_name_path=${filepath}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report.delete.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){

                let deleteDetails = this.responseText;
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
        
        setTimeout(() => {
            eventButton.setAttribute("data-animation","false");
            closeReview();
            handleHealthReportsUI()
        },5000);

    });
}

function fetchUsers(inputElement) { // postfunction

    targetInputElement = inputElement;
    listOfUsersContainer = targetInputElement.parentElement.querySelector(".search-list-of-users");
    targetForm = targetInputElement.parentElement.parentElement;

    let result = new Promise((resolve,reject) => {
        // TODO: XSS vulnerability 
        // inputElement.value is not wrapped or regex tested.
        if(inputElement.value != ""){
            let params = `Name=${inputElement.value}`;
            let xhr = new XMLHttpRequest();

            xhr.open("POST", "include/patient-name.fetch.php", true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function(){
                let users;
                if( this.status == 200 ){
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
        .catch( error => { });
}

async function forwardReportToPatient(e){

    let reportItemButtons = e.parentElement;
    let reportItem = e.parentElement.parentElement;
    let spinner = reportItem.querySelector(".sk-bounce");
    let finalView = reportItem.querySelector(".disabled-view");
    let reportID = reportItem.getAttribute("data-report-id");

    hide(reportItemButtons);
    show(spinner);

    let forwardReportPromise = new Promise((resolve,reject) => {
        let params = `report_id=${reportID}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/forward-report.post.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let forwardResponse = this.responseText;
                if(forwardResponse == "success") resolve();
                else reject();

            }
            else{
                reject("Error Deleting Report");
            }
        }
        xhr.send(params);
    });

    forwardReportPromise.then(() => {
        setTimeout(() => {
            hide(spinner);
            finalView.setAttribute("data-error","false");
            finalView.textContent = "Forwarded Successfully";
            show(finalView);

            setTimeout(() => handleHealthReportsUI(), 10000);
            
        },4000);
    }).catch(() => {
        setTimeout(() => {
            hide(spinner);
            finalView.setAttribute("data-error","true");
            finalView.textContent = "Error Forwarding";
            show(finalView);
        },2000);

        setTimeout(() => {
            hide(finalView);
            gridShow(reportItemButtons);
        },4000);
    });
    
    
    let detailsPromise = await fetchReportDetails(reportID);
    let patientID = detailsPromise.patient_id;
    detailsPromise = await fetchUser(patientID);
    let emailAddress = detailsPromise.Email;
    sendEmail(emailAddress);
}

async function sendEmail(to){
    emailjs.send("service_l07v6iq","template_xuxue1h",{
        from_name: DOCTOR_NAME,
        to_email: to,
        }, "Ke0A91AQjt94cU4V3");

    console.log("...Email sent");
}

async function reviewReport(e){

    let canvasElementClass = ".pdf-viewer";
    let reviewReportOverlay = find(".report-review-overlay");
    selectedReportID = e.parentElement.parentElement.getAttribute("data-report-id");

    show(reviewReportOverlay);

    reviewReportOverlay.style.alignItems = "center";
    hide(find(".report-review-popup"));
    hide(find(".delete-pdf-button"));
    gridShow(find(".pdf-viewer-loader"));

    let details = await fetchReportDetails(selectedReportID);
    let url = "./reports/" + details.filename;
    
    pdfjsLib
        .getDocument({ url, password: "" })
        .promise.then((data) => {
            initialReportState.pdfDoc = data;
            renderReport( canvasElementClass );
            setTimeout(() =>{
                show(find(".delete-pdf-button"));
            },7000)
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

        let reportsHTML = "";

        for( let i = 0; i < reports.length; i++){
            reportsHTML += renderReportRecord(i+1,reports[i]);
        }

        let innerHTML = preHTMLContent + reportsHTML;
        
        find(".local-report-list").innerHTML = innerHTML;


    }).catch( error => { })


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
        break;
    }

    hide(createReportButton);
    show(createReportLoader);

    let generateResponse = generateReportByTemplate(template,"doctor");
        
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
                },1500);
            },1500);
    }).catch(( error ) => {
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

async function setHBPData() {
    
    hbpReportTemplate.reportTitle = "High Blood Pressure Report"; // never changes
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
    
    let BPSystolicA = targetForm.querySelector(".bp-systolic-a").value;
    let BPDiastolicA = targetForm.querySelector(".bp-diastolic-a").value;
    let BPSystolicB = targetForm.querySelector(".bp-systolic-b").value;
    let BPDiastolicB = targetForm.querySelector(".bp-diastolic-b").value;
    let BPSystolicC = targetForm.querySelector(".bp-systolic-c").value;
    let BPDiastolicC = targetForm.querySelector(".bp-diastolic-c").value;

    hbpReportTemplate.BPMeasurementA = `${BPSystolicA} / ${BPDiastolicA}`; // Entered Data
    hbpReportTemplate.BPMeasurementB = `${BPSystolicB} / ${BPDiastolicB}`;
    hbpReportTemplate.BPMeasurementC = `${BPSystolicC} / ${BPDiastolicC}`;
    
    hbpReportTemplate.medication = targetForm.querySelector(".hbp-medication").value;
    hbpReportTemplate.remarks = targetForm.querySelector(".doctor-remarks").value;

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

function listAvailableUsers(array){
    let usersHTML = ``;
    array.forEach( object => usersHTML += `<div class="searched-user-item" onclick="setName(this)" data-name="${object['Name']}" data-id=${object['ID']}>${object['Name']}</div>` );
    listOfUsersContainer.innerHTML = usersHTML;
    listOfUsersContainer.style.display = 'block';
}

exposeEventListeners(
    forwardReportToPatient,
    deleteReport,
    reviewReport,
    createReport,
    setName,
    fetchUsers,
    loadReport
);