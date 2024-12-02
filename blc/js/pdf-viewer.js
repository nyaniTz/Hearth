// let pdf = 'https://health.aiiot.website/reports/document.pdf';
let pdf = 'reports/Covid-Report@24u4czs3xlfy4ztw6.pdf';
let canvasElementClass = ".pdf-viewer";
let loader = document.querySelector(".loader");

const initialReportState = {
	pdfDoc: null,
	currentPage: 1,
	pageCount: 0,
	zoom: 3,
};

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

		});

	// return new Promise();
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