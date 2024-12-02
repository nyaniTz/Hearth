<div class="overlay create-new-report-overlay">
    <div class="popup template-report-popup select-none">
        <span class="close-pop-up" onclick="closeAllTemplates()"></span>
        
        <h3 class="pop-up-title green-font">Create New Report</h3>
        <span class="hint">Select Template From Below</span>
        <ul class="report-template-list">
            <li onclick="openCovidReportPopup()">
                <img src="images/covid-icon.png" alt="">
                <span>Covid Report</span>
            </li>
            <li onclick="openBloodPressureReportPopup()">
                <img src="images/blood-pressure-icon.png" alt="">
                <span>Blood Pressure Report</span>
            </li>
        </ul>
    </div>

    <div class="popup create-new-report-popup select-none" id="covid-report-template">
        <span class="close-pop-up" onclick="closeAllTemplates(); resetPDFReportForm(this);"></span>
        <h3 class="pop-up-title green-font">Create New Covid Report</h3>
        <span class="hint">All fields marked with * are required. Data will be fetched for patient automatically after you select the patient's name.</span>
        <?php include 'components/forms/covid-form.php'; ?>
    </div>


    <div class="popup create-new-report-popup select-none" id="blood-pressure-report-template">
        <span class="close-pop-up" onclick="closeAllTemplates(this); resetPDFReportForm(this);"></span>
        <h3 class="pop-up-title green-font">Create New Blood Pressure Report</h3>
        <span class="hint align-start">All fields marked with * are required. Data will be fetched for patient automatically after you select the patient's name.</span>    
        <?php include 'components/forms/blood-pressure-form.php'; ?>
    </div>
</div>