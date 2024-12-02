import { fetchReports, fetchReportDetails, deleteReportMetaData, fetchUser } from "PostFunctions";
import { formattedDate, formattedTime, PascalCase, getBrowserName, 
         exposeEventListeners, isEmail,
         hide, show, gridShow, find, uniqueID } from "UtilFunctions";
import { loadReport, generateReportByTemplate } from "ReportFunctions";
import { SelfReportTemplate } from "ReportTemplates";

let DOCTOR_EMAIL;

let metamaskContainer = find(".metamask-container.select-none");
let bgImage = find(".bg-image.place-absolute");
let metamaskButton = find(".metamask-button.connect-wallet");
let metamaskAttribute = find(".metamask-attribute.detected-browser");
let totalHeading = find(".total-heading");
let reportsContainer = find(".outer-reports-container");

let overlay = find(".overlay.add-to-blockchain-overlay");
let confirmOverlay = find(".confirm-add-overlay");

let permissionList = find(".permission-items-list");
let initialUsersToAddToPermissionList = [];
let newUsersToAddToPermissionList = [];
let blockchainUploadObject = {
    _reportID: "",
    _reportName: "",
    _reportPermissions: [], 
    _reportLink: "",
    _reportOwnerName: "",
    _doctorsEmail: ""
};

initialLayout(); // set everything to default look.

function initialLayout() {
    metamaskContainer.className = "metamask-container select-none";
    bgImage.className = "bg-image place-absolute";
    
    metamaskButton.className = "metamask-button connect-wallet select-none";
    metamaskButton.textContent = "Connect to MetaMask";

    metamaskAttribute.className = "metamask-attribute detected-broswer";
    
    if (window.ethereum){
        metamaskAttribute.innerHTML = `<b>Metamask</b> Detected on <b>${getBrowserName()}</b>.`;
    }
    else{
        metamaskAttribute.innerHTML = `<b>Metamask</b> Not Detected on <b>${getBrowserName()}</b>.`;
    }

    hide(totalHeading);
    hide(reportsContainer);
    handleReportListUI();
}

function initialPermissionLayout(initialDetails){

    let permissionInnerHTML = `
    <div class="permission-item-add">
    <input class="add-permission-item-input" placeholder="Add New Person To Notify" type="text" onkeydown="checkForEnter(event,addPersonToPermissions)">
    <span class="add-person-button" onclick="addPersonToPermissions()">
        <img src="images/plus.png" alt="">
    </span>
    </div>
    ${initialDetails.map((email) => `
        <div class="permission-item">
            <span class="permission-item-name">${email}</span>
        </div>`).join("")
    }
    `;

    permissionList.innerHTML = permissionInnerHTML;
}

function checkForEnter(e,callback){
    if (e.code === "Enter") {  
        //checks whether the pressed key is "Enter"
        callback();
    }
}

function connectedLayout(){
    metamaskContainer.className = "metamask-container metamask-logged-in select-none";
    bgImage.className = "bg-image place-relative";
    
    metamaskButton.className = "metamask-button wallet-address";

    metamaskAttribute.className = "metamask-attribute binded-address";
    metamaskAttribute.innerHTML = `Ethereum Address For <b>${PascalCase(PATIENT_NAME)}</b>`;

    show(totalHeading);
    gridShow(reportsContainer);
}

metamaskButton.addEventListener("click", async () => { 
    let connectPromise = await handleConnectWallet();
    if( connectPromise !=  "error") connectedLayout();  
        
})

async function openAddToBlockChainPopUp(e) {

    if ( !confirmWalletisConnected() ) {
        showAlert("Connect To Wallet First");
        return; 
    }

    let parent = e.parentElement.parentElement;
    let selectedReportID = parent.getAttribute("data-report-id");
    let actionsContainer = parent.querySelector(".actions-container");
    let reportItemButtons = parent.querySelector(".report-item-buttons");

    const details = await fetchReportDetails(selectedReportID);
    let filename = details.filename;
    DOCTOR_EMAIL = details.doctor_email;

    let reportDetails = find(".rp-dt-fill");

    reportDetails.innerHTML = `
    <div class="report-name"><b>Report ID:</b> ${selectedReportID}</div>
    <div class="report-owner"><b>Owner Email:</b> ${PATIENT_EMAIL}</div>
    <div class="report-doctor"><b>Doctor Email:</b> ${DOCTOR_EMAIL}</div>
    <div class="report-filetype"><b>FileType:</b> typex/PDF</div>`;

    blockchainUploadObject._reportID = selectedReportID;
    blockchainUploadObject._reportName = filename;
    blockchainUploadObject._reportLink = "./reports/"+filename;
    blockchainUploadObject._reportOwnerName = PATIENT_NAME;
    blockchainUploadObject._doctorsEmail = DOCTOR_EMAIL;
    blockchainUploadObject._ownersEmail = PATIENT_EMAIL;
    blockchainUploadObject._reportUploadDate = formattedDate();
    
    initialUsersToAddToPermissionList = [];

    if(isEmail(DOCTOR_EMAIL)) initialUsersToAddToPermissionList.push(DOCTOR_EMAIL);
    if(isEmail(PATIENT_EMAIL)) initialUsersToAddToPermissionList.push(PATIENT_EMAIL);
    
    console.log("IPLayoutList:", initialUsersToAddToPermissionList)

    initialPermissionLayout(initialUsersToAddToPermissionList);

    newUsersToAddToPermissionList = [];
    
    gridShow(overlay);
}

function closeAddToBlockChainPopUp(){ 
    hide(overlay); 
}

function addPersonToPermissions(){

    let addPermissionItemInput = find(".add-permission-item-input");
    let permissionEmail = addPermissionItemInput.value;

    if ( !isEmail(permissionEmail) ) {
        showAlert("Enter A Valid Email");
        return;
    }
   
    let permissionItem = document.createElement("div");
    permissionItem.className = "permission-item";

    if( !initialUsersToAddToPermissionList.includes(permissionEmail) && !(permissionEmail == "")){

        initialUsersToAddToPermissionList.push(permissionEmail);

        permissionItem.innerHTML = `
            <span class="permission-item-name">${permissionEmail}</span>
            <span onclick="removeFromPermissionList(this,'${permissionEmail}')" class="toggle-remove"><img class="permission-icon" src="images/close.png" alt=""></span>
                              `;

        permissionList.appendChild(permissionItem);

    }

    addPermissionItemInput.value = null;
}

function removeFromPermissionList(e, permissionEmail){

    initialUsersToAddToPermissionList = initialUsersToAddToPermissionList.filter(
        (element) => element != permissionEmail );

    let elementParent = e.parentElement;
    elementParent.remove();
}

async function confirmAddToBlockchain(){
    let permissions = [...initialUsersToAddToPermissionList,...newUsersToAddToPermissionList];
    blockchainUploadObject._reportPermissions = permissions;

    let addReportPromise = await addReport(blockchainUploadObject);

    if( addReportPromise.status == "success"){
        showAlert("Report Successfully Added To Blockchain");
        
        closeConfirmPopUp();
        closeAddToBlockChainPopUp();
        
        await sendEmails();
        await changeReportStatusToBlockchain(blockchainUploadObject._reportID);
        handleReportListUI();
        syncronizeReportUI(10);
    }
    else{
        showAlert("Transaction Cancelled");
        closeConfirmPopUp();
        closeAddToBlockChainPopUp();
    }
}

async function sendEmails(){

    initialUsersToAddToPermissionList.forEach( async (email) => {
        var templateParams = {
            from_name: PATIENT_NAME,
            message: `https://health.aiiot.center/blockchainreport/view/?id=${blockchainUploadObject._reportID}`,
            to_email: email,
        };
        
        await emailjs.send("service_l07v6iq", "template_mk8r9ys", templateParams, "Ke0A91AQjt94cU4V3");

        console.log("...Email sent");
    });

}

function changeReportStatusToBlockchain(reportID){

    let changeStatusPromise = new Promise((resolve,reject) => {
        let params = `report_id=${reportID}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report-metadata.post.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){

                let recordResponse = this.responseText;
                if(recordResponse == "record on blockchain") resolve();
                else { reject(recordResponse) };
            }
            else{
                reject("Error Changing Status");
            }
        }

        xhr.send(params);
    });

    return changeStatusPromise;
}

function openConfirmDialog() {
    gridShow(confirmOverlay);
    let popupMessageElement = find(".popup-message");
    
    let concatEmails = initialUsersToAddToPermissionList.map((email) => `<span>${email}</span>`).join("");
    
    let confirmMessage = `
    <span>Are you sure you want to add report to blockchain?</span>
    <span>Emails will be sent to: </span>
    <ul class="confirmed-emails">
        ${concatEmails}
    </ul>
    <span>A <orange>report link</orange> will also be available for you in the dashboard to share after you confirm payment.</span>
    <span><orange>Click confirm payment to continue.</orange></span>
    `; 

    popupMessageElement.innerHTML = confirmMessage;

}

function closeConfirmPopUp(){
    hide(confirmOverlay);
}

async function handleReportListUI(){
    
    let localReportListContainer = find(".local-report-list");
    let NoReportsLayout = `
        <div class="local-report-list-header no-new-report">
            <h3 class="small-font report-title ">No New Reports From Doctor</h3>
            <span class="add-patient-report" onclick="handleCreateSelfReport(this)">
                <span>Generate SelfReport</span>
                <img src="images/heart-vitals-shaded.png" alt="">
                <div class="sk-wave self-report-loader">
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                </div>
            </span>
        </div>`;
    let titleHeader = `
        <div class="local-report-list-header">
            <h3 class="small-font report-title">New Health Reports</h3>
            <span class="add-patient-report" onclick="handleCreateSelfReport(this)">
                <span>Generate SelfReport</span>
                <img src="images/heart-vitals-shaded.png" alt="">
                <div class="sk-wave self-report-loader">
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                    <div class="sk-wave-rect"></div>
                </div>
            </span>
        </div>`;

    let loader = `
        <div class="initial-loader">
            <div class="sk-bounce">
                <div class="sk-bounce-dot"></div>
                <div class="sk-bounce-dot"></div>
            </div>
        </div>
    `;

    localReportListContainer.innerHTML = loader;

    let regularReports = await fetchReports("patient_id",PATIENT_ID,"patient");
    let OnBlockChainReports = await fetchReports("patient_id",PATIENT_ID,"blockchain");

    let reports = [...regularReports,...OnBlockChainReports];

    if( reports.length > 0 ){
        let reportsHTML = "";
    
        for( let i = 0; i < reports.length; i++ ){
            reportsHTML += renderReportRecord(i+1,reports[i]);
        }

        let innerHTML = titleHeader + reportsHTML;
        
        localReportListContainer.innerHTML = innerHTML;
    }
    else localReportListContainer.innerHTML = NoReportsLayout;

    function renderReportRecord(itemNumber,details){

        let correctButtonUI = "";

        switch( details.status ){
            case "blockchain":
                correctButtonUI = `
                    <div class="actions-container">
                        <div class="flashing-text">
                            adding to blockchain
                        </div>
                        <div class="sk-circle-fade">
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                            <div class="sk-circle-fade-dot"></div>
                        </div>
                    </div>`;
                break;
            case "patient":
                correctButtonUI = `
                    <div class="report-item-buttons">
                        <a href="#" class="report-button review" onclick="reviewReport(this)">Review</a>
                        <div class="report-button add-to-blockchain" onclick="openAddToBlockChainPopUp(this)">Add to Blockchain</div>
                    </div>`;
                break;
            default:
                break;
        }

        let patientReportListTemplate = `
            <div class="report-item" data-report-id=${details.report_id}>
                <div class="report-item-itemization">${itemNumber}.</div>
                <div class="report-item-name">${details.report_type} -- ${details.report_id}</div>
                ${correctButtonUI}    
            </div>`;
    
        return patientReportListTemplate;
    }

}

async function reviewReport(e){

    let selectedReportID = e.parentElement.parentElement.getAttribute("data-report-id");  
    let details = await fetchReportDetails(selectedReportID);
    let url = "./reports/" + details.filename;
    loadReport(url);
}

// DONE: configure the template
// DONE: event listener for auto-report
// DONE 1: fetch all the details of the user
// DONE 2: parse the data into the template ( nullifying all unneeded logic )
// DONE 3: create the report
// 4: open the report view
// DONE: 5: refresh the UI

async function handleCreateSelfReport(e){
    e.style.gridGap = "0px";
    const buttonText = e.querySelector("span");
    const buttonImage = e.querySelector("img");
    const buttonLoader = e.querySelector(".self-report-loader");
    hide(buttonText);
    hide(buttonImage);
    buttonLoader.style.display = "flex";

    const patient = await fetchUser(PATIENT_ID);
    console.log(patient);
    const selfReportTemplate = new SelfReportTemplate("Self Report");
    await setSelfReportTemplate();
    const reportGenerationResponse = generateReportByTemplate(selfReportTemplate,"patient");

    setTimeout(() => {
        reportGenerationResponse.then( async() => {
            showAlert("SelfReport Generated Successfully");

            let details = await fetchReportDetails(selfReportTemplate.reportID);
            let filepath = "./reports/" + details.filename;
            loadReport(filepath);
            resetForSelfReport();

        }).catch(() => {
            showAlert("Error Generating SelfReport");
            resetForSelfReport();
        });
    },3000);

    function resetForSelfReport(){
        handleReportListUI();
        e.style.gridGap = "5px";
        show(buttonText);
        show(buttonImage);
        buttonLoader.style.display = "none";
    }

    async function setSelfReportTemplate() {

        selfReportTemplate.reportTitle = "Self Health Report"; // never changes
        selfReportTemplate.reportID = uniqueID(); // generated
        selfReportTemplate.generatedTime = formattedTime();
        selfReportTemplate.generatedDate = formattedDate(); // generated
        
        selfReportTemplate.patientID = patient.ID;
        selfReportTemplate.patientName = patient.Name; // fetched from patient
        selfReportTemplate.dateOfBirth = patient.DOB.split("-").reverse().join(" / ");
        selfReportTemplate.gender = patient.Sex;
        selfReportTemplate.bloodGroup = patient.BGroup;
        selfReportTemplate.patientEmail = patient.Email;
        selfReportTemplate.patientContact = patient.Contacts;
        selfReportTemplate.temperature = patient.Temp;
        selfReportTemplate.SBP = patient.SBP;
        selfReportTemplate.DBP = patient.DBP;

        selfReportTemplate.doctorEmail = "SELFREPORT";
        selfReportTemplate.doctorID = "0";
    }

}

exposeEventListeners( 
    openAddToBlockChainPopUp,
    addPersonToPermissions,
    removeFromPermissionList,
    confirmAddToBlockchain,
    deleteReportMetaData,
    openConfirmDialog,
    closeConfirmPopUp,
    reviewReport,
    handleCreateSelfReport,
    closeAddToBlockChainPopUp,
    handleReportListUI,
    loadReport
)