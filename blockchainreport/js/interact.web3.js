import { trim, strip, filterOut, isEmail, exposeEventListeners, 
  createObjectByMatchingArrays, existsInArray, find } from "UtilFunctions"
import { loadContract, getContractAddress } from "BlockchainContract";
import { fetchReports } from "PostFunctions"

const contractAddress = getContractAddress();
const healthReportContract = await loadContract();
let currentAddress;

let totalHeadingPlaceholder = find(".total-heading");
let patientReportListContainer = find(".outer-reports-container");
let metamaskButton = find(".metamask-button.connect-wallet");

let newPermissionsToAdd = [];
let oldPermissionsToRemove = [];
let mutablePermissions = [];
let immutablePermissions = [];
let permissionChanges = 0;

try {
  if(DOCTOR_EMAIL) fetchReportsByGroupedIdentifiers(DOCTOR_EMAIL)
}catch{}

try {
  if(PATIENT_ID) syncronizeReportUI(10);
}catch{}




function confirmWalletisConnected(){
    if(currentAddress != null) return true;
    return false;
}

async function connectWallet(){

    if (window.ethereum) {
        try {
          const addressArray = await window.ethereum.request({
            method: "eth_requestAccounts",
          });
          const obj = {
            status: "connected to metamask",
            address: addressArray[0],
          };
          currentAddress = addressArray[0];
          return obj;
        } catch (err) {
          return {
            address: "",
            status: "error",
          };
        }
    } else {
        return {
          address: "",
          status: "error",
        };
    }    
};

let handleConnectWallet = async () => {
  const walletResponse = await connectWallet();
  console.log(walletResponse.status);

    if( walletResponse.status != "error"){
      showAlert("Connected To Wallet");
      metamaskButton.textContent = walletResponse.address;
      fetchBlockchainReports();
    }
    else{
      showAlert("Wallet Error");
      return "error";
    }
};

async function addReport(reportObject) {

    let { _reportID,
          _reportName,
          _reportPermissions,
          _reportLink,
          _reportOwnerName,
          _doctorsEmail,
          _ownersEmail,
          _reportUploadDate } = reportObject;

    if (!window.ethereum || currentAddress === null) {
      return {
        status:
          "💡 Connect your Metamask wallet to update the message on the blockchain.",
      };
    }

    if (!reportObject) {
      return {
        status: "Your report Object is null",
      };
    }

    //set up transaction parameters
    const transactionParameters = {
      to: contractAddress, // Required except during contract publications.
      from: currentAddress, // must match user's active address.
      data: healthReportContract.methods.addReport(
          _reportID,
          _reportName,
          _reportPermissions,
          _reportLink,
          _reportOwnerName,
          _doctorsEmail,
          _ownersEmail,
          _reportUploadDate
      ).encodeABI(),
    };

    //sign the transaction
    //and more
    try {
          const txHash = await window.ethereum.request({
          method: "eth_sendTransaction",
          params: [transactionParameters],
          });
          return { status: "success" }
      } catch (error) {
      return {
        status: "😥 " + error.message,
      };
    }
    
}

async function fetchBlockchainReports(){
  if( currentAddress ){
    const ownedReports = await healthReportContract.methods.getReports(currentAddress).call();
    const { 0:reportIDs, 1:reportNames, 2:reportLinks, 3:reportDates } = ownedReports;

    let reportCount = 0;
    let reportListUI = "";
    let reportListByDate;
    let filteredDates = [...new Set(reportDates)];

    for(let k = 0; k < filteredDates.length; k++){

      reportListByDate = "";

    let sortedByDate = createObjectByMatchingArrays(reportDates,{reportIDs,reportNames,reportLinks});
    let { reportIDs: _reportIDs, reportNames:_reportNames, reportLinks:_reportLinks } = sortedByDate[filteredDates[k]];

      for ( let i = 0; i < _reportLinks.length; i++){
        reportListByDate += renderReportItem(_reportIDs[i],_reportNames[i],_reportLinks[i]);
        reportCount += 1;
      }

      reportListUI += `
      <div class="sorted-by-date-container">
        <span class="reports-date">${filteredDates[k]}</span>
        <div class="reports-container">${reportListByDate}</div>
      </div>`;
    }

    if(reportCount == 1)
      totalHeadingPlaceholder.innerHTML = `<b>${reportCount}</b> Report Detected on Blockchain`;
    else 
      totalHeadingPlaceholder.innerHTML = `<b>${reportCount}</b> Reports Detected on Blockchain`;

    patientReportListContainer.innerHTML = reportListUI;
  }

  function renderReportItem(reportID,reportName,reportLink){
      let result = `                
      <div class="report-link">
        <img src="images/pdf-icon-orange.png" alt="">
        <span class="report-link-filename">${reportName}</span>
        <div class="blockchain-report-action-button link-icon" data-popup="link" data-reportid="${reportID}" onclick="showReportLink('${reportID}')">
          <img src="images/link-orange.png" class="action-icon">
        </div>
        <div class="blockchain-report-action-button" data-popup="view" onclick="loadReport('${reportLink}')">
          <img src="images/view.png" class="action-icon">
        </div>
      </div> 
      `;

        // deleted code for permissions UI
        // <div class="blockchain-report-action-button" data-popup="permissions" data-reportid="${reportID}" data-reportlink="${reportLink}" onclick="editPermissions('${reportID}')">
        //   <img src="images/shield.png" class="action-icon">
        // </div>
        
      return result;
  }
}

async function editPermissions( reportID ){
 
  permissionChanges = 0;
  handleButtonChangesUI();

  let permissions = await healthReportContract.methods.getReportPermissions( reportID ).call();
  let changePermissionsOverlay = find(".change-permissions-overlay");
  let permissionTitle = changePermissionsOverlay.querySelector(".popup-title");
  permissionTitle.textContent = `Permissions for ${reportID}`;

  let reportURL = `http://health.aiiot.center/blockchainreport/view/?id=${reportID}`;
  
  let viewLink = changePermissionsOverlay.querySelector(".report-share-link");
  viewLink.textContent = reportURL;

  viewLink.addEventListener("click", () => {
      navigator.clipboard.writeText(reportURL);
      showAlert("Link Copied To Clipboard");
  });

  let permissionsContainerList = changePermissionsOverlay.querySelector(".blockchain-permission-items-list");

  let { 0: _immutablePermissions, 1: _mutablePermissions } = permissions;
  immutablePermissions = _immutablePermissions;
  mutablePermissions = filterOut(_mutablePermissions, immutablePermissions);

  function handleEditPermissionsUI() {
    let finalPermissionsUI = "";

    finalPermissionsUI += 
    `
      <div class="permission-item">
        <span class="permission-item-name">me ( <b>${immutablePermissions[0]}</b> )</span>
      </div>
      <div class="permission-item">
        <span class="permission-item-name">doctor ( <b>${immutablePermissions[1]}</b> )</span>
      </div>`

    if ( oldPermissionsToRemove > 0 ) mutablePermissions = filterOut( oldPermissionsToRemove, mutablePermissions );
    finalPermissionsUI += renderPermissions(mutablePermissions);
    if( newPermissionsToAdd.length > 0 ) finalPermissionsUI += renderPermissions(newPermissionsToAdd);

    permissionsContainerList.innerHTML = finalPermissionsUI;
  }

  function renderPermissions(permissionList) {

    let permissionUI = "";

    permissionList.forEach( permissionEmail => {
      permissionUI += `
        <div class="permission-item">
          <span class="permission-item-name">${permissionEmail}</span>
          <span onclick="removeFromBlockchainPermissionList(this,'${permissionEmail}')" class="toggle-remove"><img class="permission-icon" src="images/close.png" alt=""></span>
        </div>`;
    });
    return permissionUI;
  }

  handleEditPermissionsUI();
  gridShow(changePermissionsOverlay);

  let addPersonButton = changePermissionsOverlay.querySelector(".add-person-button");
  let permissionInput = changePermissionsOverlay.querySelector(".add-permission-item-input");

  addPersonButton.addEventListener("click", function() {
    let newEmail = permissionInput.value;
    
    if( isEmail(newEmail) ){
        if( existsInArray(newPermissionsToAdd, newEmail).value || 
            existsInArray(mutablePermissions, newEmail).value ||
            existsInArray(immutablePermissions, newEmail).value)
        {   showAlert("Already Added"); return; }
        newPermissionsToAdd.push([newEmail]);
        permissionChanges++;
        handleButtonChangesUI()
        handleEditPermissionsUI();
    }
    else {
      showAlert('Enter a Valid Email');
      return;
    }
  });
}

function handleButtonChangesUI(){
  let permissionChangesButton = find(".change-permissions-button");
  
  switch( permissionChanges ){
    case 0:
      permissionChangesButton.setAttribute("disabled", true);
      permissionChangesButton.textContent = `Apply`;
    break;
    default:
      permissionChangesButton.removeAttribute("disabled");
      permissionChangesButton.textContent = `Apply Changes (${permissionChanges})`;
    break;
  }
}

function removeFromBlockchainPermissionList(elementNode, emailAddress){

  let existsInNewPermissions = existsInArray(newPermissionsToAdd,emailAddress);
  if (existsInNewPermissions.value) {
      newPermissionsToAdd.splice(existsInNewPermissions.index,1);
      permissionChanges--;
  }

  let existsInMutablePermissions = existsInArray(mutablePermissions,emailAddress);
  if (existsInMutablePermissions.value){
    oldPermissionsToRemove.push(emailAddress);
    mutablePermissions.splice(existsInMutablePermissions.index,1);
    permissionChanges++;
  }
  

  let elementParent = elementNode.parentElement;
  elementParent.remove();
  handleButtonChangesUI();
  console.log("permissionsListToAdd: ", newPermissionsToAdd );
  console.log("permissionsListToRemove: ", oldPermissionsToRemove);
  console.log("pCC: ", permissionChanges);

}

function closeChangePermissionsPopUp(){
  hide(find(".change-permissions-overlay"));
}

async function fetchReportsByGroupedIdentifiers( email ){

  let groupedReports = await healthReportContract.methods.getReportsByGroupedIdentifiers(email).call();

  let { 0:reportNames, 1: OwnerNames, 2:reportLinks, 3:reportUploadDates } = groupedReports;
  
  let sortedByName = createObjectByMatchingArrays(OwnerNames,{reportNames,reportLinks,reportUploadDates});

  let patientCount = [...new Set(OwnerNames)].length;
  let totalReportCount = reportNames.length;

  let patientText =  patientCount == 1 ? "Patient" : "Patients";
  let reportText =  totalReportCount == 1 ?  "Report" : "Reports";;
  let totalHeadingPlaceholder = `
  <b class="green-font">${totalReportCount}</b> 
  ${reportText} Total From <b class="green-font">${patientCount}</b> 
  ${patientText}`;
  
  let reportListUIByName = "";

  function renderReportItem(reportName,reportLink){
    let reportID = reportLink.split("@")[1].split(".")[0];
    let result = `                
      <div class="report-link">
        <img src="images/pdf-icon-green.png" alt="">
        <span class="report-link-filename">${reportName}</span>
        <div class="blockchain-report-action-button link-icon" data-popup="link" data-reportid="${reportID}" onclick="showReportLink('${reportID}')">
          <img src="images/link-green.png" class="action-icon">
        </div>
        <div class="blockchain-report-action-button" data-popup="view" onclick="loadReport('${reportLink}')">
            <img src="images/view-green.png" class="action-icon">
        </div>
      </div>`;
    return result;
  }

  for( let key in sortedByName ){
    let { reportNames: _reportNames, reportUploadDates:_reportUploadDates, reportLinks:_reportLinks } = sortedByName[key];
    let sortedByDate = createObjectByMatchingArrays(_reportUploadDates,{_reportNames,_reportLinks});

    let sortedByDateUI = "";

    for( let date in sortedByDate ){

        let UIByDate = ""

        for(let i = 0; i < sortedByDate[date]["_reportNames"].length; i++){
          let report_name = sortedByDate[date]["_reportNames"][i];
          let report_link = sortedByDate[date]["_reportLinks"][i];
          UIByDate += renderReportItem(report_name,report_link);
        };

        sortedByDateUI += `
            
              <div class="sorted-by-date-container">
                <span class="reports-date">${trim(date)}</span>
                <div class="reports-container" style="display: grid;">${UIByDate}</div>
              </div>
        `;
    }

  
    reportListUIByName += `
    <div class="per-patient-container">
      <div class="report-patient-name">${key}</div>
      <div class="outer-reports-container">${sortedByDateUI}</div>
    </div>`;
      
  }

  let blockchainReportsContainerUI = `
            <h1 class="green-font">Patient Reports on the Blockchain</h1>
            <h1 class="total-heading">${totalHeadingPlaceholder}</h1>
            <div class="doctor-reports-container">${reportListUIByName}</div>`;

  let blockchainReportsContainer = find(".blockchain-report-container");
  blockchainReportsContainer.innerHTML = blockchainReportsContainerUI;


    `<div class="outer-reports-container">
            <div class="sorted-by-date-container">
                <span class="reports-date">24/02/2023</span>
            
            </div>
    </div>
      `;
};

function syncronizeReportUI(time){
  let intervalLoops = setInterval( async () => {

    console.log("Syncing UI...")
        let blockchainLoadingReports = await fetchReports("patient_id",PATIENT_ID,"blockchain");
        if (blockchainLoadingReports.length == 0) clearTimeout(intervalLoops);

        blockchainLoadingReports = strip(blockchainLoadingReports,"report_id");

        blockchainLoadingReports.forEach( async (reportID) => {
          let matchedID = await healthReportContract.methods.matchID(reportID).call();
          if( matchedID != 'error'){
              await deleteReportMetaData(matchedID);
              handleReportListUI();
              if(confirmWalletisConnected) fetchBlockchainReports();
          }
        })
  }, time * 1000);
}

exposeEventListeners(
  handleConnectWallet,
  addReport,
  editPermissions,
  removeFromBlockchainPermissionList,
  closeChangePermissionsPopUp,
  confirmWalletisConnected,
  syncronizeReportUI
);