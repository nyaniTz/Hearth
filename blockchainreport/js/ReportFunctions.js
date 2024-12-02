import { sendMetadataToDatabase } from "PostFunctions";

function loadReport(url){
    let canvasElementClass = ".pdf-viewer";
    let reviewReportOverlay = find(".report-review-overlay");

    show(reviewReportOverlay);

    reviewReportOverlay.style.alignItems = "center";
    hide(find(".report-review-popup"));
    gridShow(find(".pdf-viewer-loader"));

    pdfjsLib
        .getDocument({ url, password: "" })
        .promise.then((data) => {
            initialReportState.pdfDoc = data;
            renderReport( canvasElementClass );
        })
        .catch((err) => {
            alert(err.message);
    });
}

async function generateReportByTemplate(template,status){

    let { fileBlob, filename } = await generatePDF(template);
    await uploadPDF( fileBlob, filename );
    await sendMetadataToDatabase(template,filename,status);
    
}

async function generatePDF( template ) {

    let templateName = ((template.reportName).trim()).split(" ").join("-");
    let filename = `${templateName}-Report@${template.reportID}.pdf`;
    let HTMLTemplate = template.HTML();

    let fileBlob = await html2pdf().set({ html2canvas: { scale: 5 } }).from(HTMLTemplate).output('blob'); // promise

    return { fileBlob, filename };
    
}

async function uploadPDF(PDFFile,filename){

    let formData = new FormData();
        formData.append('pdf', PDFFile, filename);

    await fetch('include/upload-report.script.php', {
            method: 'POST',
            body: formData,
    });
}

export { loadReport, generateReportByTemplate };