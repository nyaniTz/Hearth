// let pdf = 'https://health.aiiot.website/reports/document.pdf';
// pdf = 'document.pdf';

// let loader = document.querySelector(".loader");

const initialState = {
	pdfDoc: null,
	currentPage: 1,
	pageCount: 0,
	zoom: 1,
};

const renderPage = (canvasElementClass) => {
	// Load the first page.
	console.log(initialState.pdfDoc, 'pdfDoc');
	initialState.pdfDoc
		.getPage(initialState.currentPage)
		.then((page) => {
			console.log('page', page);

			const canvas = document.querySelector(canvasElementClass);
			const ctx = canvas.getContext('2d');
			const viewport = page.getViewport({
				scale: initialState.zoom,
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
		initialState.pdfDoc = data;
		console.log('pdfDocument', initialState.pdfDoc);

		renderPage();
	})
	.catch((err) => {
		alert(err.message);
	});