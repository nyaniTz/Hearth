// function randomTimeInterval(min, max) { return Math.floor(Math.random() * (max - min + 1) + min) }
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

const initialReportState = { // duplicate ... move
	pdfDoc: null,
	currentPage: 1,
	pageCount: 0,
	zoom: 3,
};

function addNewReport(){ // misnomer ... rename to handleAddNewReport
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

function closeReview(){
    hide( find(".report-review-overlay") );
}

function closeReportLinkSharePopup(){
    hide(find(".view-report-link-overlay"));
}

const renderReport = async (canvasElementClass) => { // duplicate... move
	// Load the first page.
	initialReportState.pdfDoc
		.getPage(initialReportState.currentPage)
		.then((page) => {

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
            
            page.render(renderCtx);

			setTimeout(() => {
                hide(find(".pdf-viewer-loader")); // Hide Loader 
                find(".report-review-overlay").style.alignItems = "start";
                show(find(".report-review-popup"));
            }, 7000);

		});
};

function showAlert( text ){
    let alertBox = document.createElement("div");
    alertBox.textContent = text;
    alertBox.className = "alert-box select-none";

    let body = find("body");
    body.appendChild(alertBox);

    alertBox = find(".alert-box");

    setTimeout(() => {
        alertBox.style.transform = "translate(-50%, 100px)";
    }, 0);

    setTimeout(() => {
        alertBox.style.transform = "translate(-50%,-100px)";
        setTimeout(() => {
            alertBox.remove();
        },1000)
    }, 2000);
}

function showReportLink(reportID){
    let reportLinkOverlay = document.querySelector(".view-report-link-overlay");
    gridShow(reportLinkOverlay);
    let linkBox = reportLinkOverlay.querySelector(".report-share-link");

    let reportURL = `http://health.aiiot.center/blockchainreport/view/?id=${reportID}`;

    let reportLinkPlaceholder = reportLinkOverlay.querySelector(".report-share-link");
    reportLinkPlaceholder.textContent = reportURL;

    linkBox.addEventListener("click", () => {
        navigator.clipboard.writeText(reportURL);
        showAlert("Link Copied To Clipboard");
    });
}

let isDropDown = false;

function dropdown(){
    let dropdownItem = find(".logout");
    
    if(isDropDown){
        dropdownItem.style.display = "none";
        isDropDown = false;
    }
    else{
        dropdownItem.style.display = "block";
        isDropDown = true;
    }
}


// To Move ??? and then imported into doctor.js

function resetPDFReportForm(_form,state="all"){
    let form = _form.parentElement.querySelector(".pdf-report-form");
    let formInputsContainers = form.querySelectorAll(".report-form-input-container");
    let userSearchContainer = form.querySelector(".user-search-container");
    let userSearchInput = userSearchContainer.querySelector(".report-form-input");

    formInputsContainers.forEach( container => {
        let formInput = container.querySelector(".report-form-input"); 
        let halfFormInput = container.querySelectorAll(".report-form-half-input");
    
        if( formInput ){
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
                    break;
            }

            if( formInput.disabled && formInput.getAttribute("type") == "date" )
                formInput.setAttribute("type","text");
        }

        if( halfFormInput.length > 0 ){
            halfFormInput.forEach( input => {
                input.value = "";
                input.setAttribute("data-isRequired","false");
            });
            userSearchInput.removeAttribute("disabled");
        }  
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

        if( input.hasAttribute("required") && ((input.value == "" || input.value == null)) 
        || input.type == "number" && !isNumberTextAndPositive(input.value)){
            requiredInputs.push(input);
        }
        else {
            if (input.className == "report-form-half-input") {
                let inputWrapper = input.parentElement;
                inputWrapper.setAttribute("data-isRequired","false");
            }
            else{
                input.setAttribute("data-isRequired","false");
            }
        }
    });

    if(requiredInputs.length > 0) {
        highlightBorder(requiredInputs[0]);
        return true;
    }

    return false;
}

function highlightBorder(formInput){ 
    if (formInput.className == "report-form-half-input") {
        let inputWrapper = formInput.parentElement;
        inputWrapper.setAttribute("data-isRequired","true");
    }
    else formInput.setAttribute("data-isRequired","true");

    formInput.focus();
}

function submitTestForm( element ){
    let form = element.parentElement;
    isRequiredFieldsEmpty(form);
}

function isNumberTextAndPositive(x){
    try{
        let number = Number(x);
        if( number > 0 ) return true;
        else return false;
    }
    catch{
        throw new Error("InputNotNumberError"); 
    }
}