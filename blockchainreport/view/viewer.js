const contractAddress = getContractAddress();
const healthReportContract = await loadContract();
const reportID = await loadReportIDParam();
const reportDetails = await fetchBlockchainReportLink(reportID);
const initialReportState = {
	pdfDoc: null,
	currentPage: 1,
	pageCount: 0,
	zoom: 3, 
};
const spinner = document.querySelector(".pdf-viewer-loader");

try {
  const { 0:reportName, 1:reportLink, 2:reportOwnerName } = reportDetails;
  if( !reportLink ) throw new Error("Link Not Found");
  loadReport(reportName,reportLink,reportOwnerName);
}
catch ( err ){
  setTimeout(() => displayError(), 2000);
}

function displayError(){
    let noAccessView = document.querySelector(".viewer-no-access");
    spinner.style.display = "none";
    noAccessView.style.display = "grid";
}

async function loadReportIDParam(){
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  let reportID = urlParams.get("id");
  return reportID;
} 

async function fetchBlockchainReportLink( reportID ){
    return await healthReportContract.methods.getReport(reportID).call();
}

function loadReport( reportName, reportLink , reportOwnerName ) {

  let pdf = "." + reportLink;

  let canvasElementClass = "#reportViewer";
  let reportOwnerNamePlaceholder = reportOwnerName;

  let reportNamePlaceholder = document.querySelector(".blockchain-report-title");
  reportNamePlaceholder.textContent = reportName.split("@").join(" ");

  let viewerUpperContainer = document.querySelector(".viewer-upper-container");
  let viewerReportContainer= document.querySelector(".viewer-report-container");

  const renderPage = (canvasElementClass) => {
    // Load the first page.
    console.log(initialReportState.pdfDoc, 'pdfDoc');
    initialReportState.pdfDoc
      .getPage(initialReportState.currentPage)
      .then((page) => {
        console.log('page', page);
  
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
          spinner.style.display = "none";
          viewerReportContainer.style.display = "grid";
          viewerUpperContainer.style.display = "grid";
        }, 7000);
  
      });
  };
  
  pdfjsLib
    .getDocument(pdf)
    .promise.then((data) => {
      initialReportState.pdfDoc = data;
      console.log('pdfDocument', initialReportState.pdfDoc);
      renderPage( canvasElementClass );
    })
    .catch((err) => {
      alert(err.message);
    });
}

function getAlchemyKey() {
  const alchemyKey = "wss://eth-sepolia.g.alchemy.com/v2/y-jUXCAnXOuLpB7uDAhHLcdyW43vPZNl";
  return alchemyKey;
}

function getContractAddress(){
  const contractAddress = "0xa1A5702faB7cA4415Dba42c7aE9CD15Dda13d04C";
  return contractAddress;
}

async function loadContract() {

  const response = await fetch("/blockchainreport/contracts/health-report-abi.json");
  const contractABI = await response.json();
  
  const web3 = new Web3(getAlchemyKey());
  return new web3.eth.Contract(
      contractABI,
      getContractAddress()
  );

}
