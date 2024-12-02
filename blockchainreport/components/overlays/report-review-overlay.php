<div class="overlay report-review-overlay">
    <span class="delete-pdf-button display-none" data-animation="false" onclick="deleteReport(this)">
        <div class="sk-flow">
            <div class="sk-flow-dot"></div>
            <div class="sk-flow-dot"></div>
            <div class="sk-flow-dot"></div>
        </div>
    </span>

    <div class="pdf-viewer-loader">
        <div class="sk-chase">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>
    </div>

    <div class="popup report-review-popup select-none">
        <span class="close-pop-up blue-bg" id="report-review-close" onclick="closeReview()"></span>
        <canvas class="pdf-viewer"></canvas>
    </div>
</div>