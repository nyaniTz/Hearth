function hide(element){ element.style.display = "none"; }
function show(element){ element.style.display = "block"; }
function gridShow(element){ element.style.display = "grid"; }
function find(element){ return document.querySelector(element) };
function findAll(elements){ return document.querySelectorAll(elements) };

let createReportOverlay = find(".create-new-report-overlay");
let templateListPopup = find(".template-report-popup");
let covidReportPopup = find("#covid-report-template");
let bloodPresurePopup = find("#blood-pressure-report-template");

let reportTemplates = findAll(".create-new-report-popup");

function addNewReport(){
    gridShow(createReportOverlay);
    gridShow(templateListPopup);
}

function openCovidReportPopup(){
    gridShow(createReportOverlay);
    hide(templateListPopup)
    gridShow(covidReportPopup);
}

function openBloodPressureReportPopup(){
    gridShow(createReportOverlay);
    hide(templateListPopup);
    gridShow(bloodPresurePopup);
}

function closeAllTemplates(){
    reportTemplates.forEach( template => hide(template) );
    hide(createReportOverlay);
}

function resetPDFReportForm(_form,state="all"){
    let form = _form.parentElement.querySelector(".pdf-report-form");
    let formInputsContainers = form.querySelectorAll(".report-form-input-container");
    let userSearchContainer = form.querySelector(".user-search-container");
    let userSearchInput = userSearchContainer.querySelector(".report-form-input");

        formInputsContainers.forEach( container => {
            let formInput = container.querySelector(".report-form-input"); 
        
            switch (state){
                case "all":
                    formInput.value = "";
                    userSearchInput.removeAttribute("disabled");
                    formInput.setAttribute("data-isRequired","false")
                    break;
                case "locked":
                    if(formInput.disabled){
                        formInput.value = "";
                    }
                    break;
                default:
                    console.log("state ",state," not available")
                    break;
            }

            if( formInput.disabled && formInput.getAttribute("type") == "date" )
                formInput.setAttribute("type","text");

            
        });

    let submitButton = form.querySelector(".submit-button");
    submitButton.textContent = "Create Report";
    submitButton.setAttribute('data-error',"");
}

function releaseInputThenFocus(inputLock){
    
    let form = inputLock.parentElement.parentElement;
    let siblingInputElement = inputLock.parentElement.querySelector(".report-form-input");

    resetPDFReportForm(form,"locked");
    siblingInputElement.removeAttribute("disabled");
    siblingInputElement.focus();

}

function isRequiredFieldsEmpty(form){

    let inputs = form.querySelectorAll("input");
    let requiredInputs = [];

    inputs.forEach( input => {
        if( input.hasAttribute("required") && (input.value == "" || input.value == null))
            requiredInputs.push(input);
    });

    if(requiredInputs.length > 0) {
        highlightBorder(requiredInputs[0]);
        return true;
    }

    return false;
}

function highlightBorder(formInput){ 
    formInput.setAttribute("data-isRequired","true");
    formInput.focus(); 
}

function closeReview(){
    hide( find(".report-review-overlay") );
}