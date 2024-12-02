//module-ize

function hide(element){ element.style.display = "none"; }
function show(element){ element.style.display = "block"; }
function gridShow(element){ element.style.display = "grid"; }
function find(element){ return document.querySelector(element) };
function findAll(element){ return document.querySelectorAll(element) };

//module-ize

let disconnectButton = find(".disconnect-button");
let metamaskAddress = find(".metamask-address");
let username = find(".username");

let metamaskContainer = find(".metamask-container.select-none");
let bgImage = find(".bg-image.place-absolute");
let innerGrid = find(".inner-grid");
let metamaskButton = find(".metamask-button.connect-wallet");
let metamaskAttribute = find(".metamask-attribute.detected-browser");
let totalHeading = find(".total-heading");
let reportsContainer = find(".reports-container");

let newUsersToAddToPermissionList = [];

let overlay = find(".overlay.add-to-blockchain-overlay");
let confirmOverlay = find(".confirm-add-overlay");

let permissionList = find(".permission-items-list");

initialLayout(); // set everything to default look.

function initialLayout() {
    metamaskContainer.className = "metamask-container select-none";
    bgImage.className = "bg-image place-absolute";
    
    metamaskButton.className = "metamask-button connect-wallet select-none";
    metamaskButton.textContent = "Connect to MetaMask";

    metamaskAttribute.className = "metamask-attribute detected-broswer";
    metamaskAttribute.innerHTML = "Metamask Detected on <b>Chrome</b>";

    hide(totalHeading);
    hide(reportsContainer);

}

function initialPermissionLayout(initialDetails){

    let { reportDoctorName, reportPatientName } = initialDetails;

    let permissionInnerHTML = `
    <div class="permission-item-add">
    <input class="add-permission-item-input" placeholder="Add New Person" type="text">
    <span class="add-person-button" onclick="addPersonToPermissions()">
        <img src="images/plus.png" alt="">
    </span>
    </div>
    <div class="permission-item">
        <span class="permission-item-name">me ( <b>${reportPatientName}</b> )</span>
    </div>
    <div class="permission-item">
        <span class="permission-item-name">doctor ( <b>${reportDoctorName}</b> )</span>
    </div>`;

    permissionList.innerHTML = permissionInnerHTML;
}

function connectedLayout(){
    metamaskContainer.className = "metamask-container metamask-logged-in select-none";
    bgImage.className = "bg-image place-relative";
    
    metamaskButton.className = "metamask-button wallet-address";
    metamaskButton.textContent = "0x4FB85eC5b96037eA1e09594C2D673b6C9e597f90";

    metamaskAttribute.className = "metamask-attribute binded-address";
    metamaskAttribute.innerHTML = "Binded Ethereum Address for <b>Michael Scott</b>";

    show(totalHeading);
    gridShow(reportsContainer);
}

disconnectButton.addEventListener("click", () => {
    disconnectButton.style.transitionDelay = "0.5s"; 
    disconnectButton.style.transform = "scale(0)";
    metamaskAddress.style.transform = "translateX(100%)";
    
    setTimeout(() => {
        initialLayout();
    },1300);
})
        

metamaskButton.addEventListener("click", () => { 
    disconnectButton.style.transitionDelay = "1s"; 
    disconnectButton.style.transform = "scale(1)";
    metamaskAddress.style.transform = "translateX(0%)";

    setTimeout(() => {
        connectedLayout();  
    }, 1000);
})

function openAddToBlockChainPopUp(e) {
    let reportid = e.dataset.reportid;

    let initialDetails = {
        reportDoctorName: "John Wayans",
        reportName: "BMI Report",
        reportPatientName: "Ibrahim Ame",
        reportDate: "22/03/2023",
        reportDoctorEmail:"john.wayans@yahoo.com",
        reportPatientEmail: "ame.ibrahim@yahoo.com",
    }

    // remember to use reportid to fetch details. once every
    // thing is confirmed, use it to delete the record from
    // the database. If you sync, then sync the UI.

    initialPermissionLayout(initialDetails);

    newUsersToAddToPermissionList = [];
    
    gridShow(overlay);
}

function closeAddToBlockChainPopUp(){
    hide(overlay);
}

function addPersonToPermissions(){

    let addPermissionItemInput = find(".add-permission-item-input");
    let permissionEmail = addPermissionItemInput.value;
   
    let permissionItem = document.createElement("div");
    permissionItem.className = "permission-item";

    if( !newUsersToAddToPermissionList.includes(permissionEmail) && !(permissionEmail == "")){
        newUsersToAddToPermissionList.push(permissionEmail);

        permissionItem.innerHTML = `
                              <span class="permission-item-name">${permissionEmail}</span>
                              <span onclick="removeFromPermissionList(this,'${permissionEmail}')" class="toggle-remove"><img class="permission-icon" src="images/close.png" alt=""></span>
                              `;

        permissionList.appendChild(permissionItem);

    }
    addPermissionItemInput.value = null;
}

function removeFromPermissionList(e,permissionEmail){

    console.log(newUsersToAddToPermissionList);

    newUsersToAddToPermissionList = newUsersToAddToPermissionList.filter(
        (element) => element != permissionEmail );
    
    console.log(newUsersToAddToPermissionList);

    let elementParent = e.parentElement;
    elementParent.remove();
}

function openConfirmDialog() {
    gridShow(confirmOverlay);
    let popupMessageElement = find(".popup-message");
    
    let confirmMessage = `<span>Are you sure you want to add report to blockchain?</span>`;

    if(newUsersToAddToPermissionList.length > 0){

        let concatEmails = newUsersToAddToPermissionList.map((email) => `<span>${email}</span>`).join();
        
        confirmMessage = `
        <span>Are you sure you want to add report to blockchain? Emails will be sent to: </span>
        <ul class="confirmed-emails">
            ${concatEmails}
        </ul>
        <span>to be able to view report. Click yes to continue.</span>`; 
    }

    popupMessageElement.innerHTML = confirmMessage;

}

function closeConfirmPopUp(){
    hide(confirmOverlay);
}