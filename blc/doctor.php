<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/doctor.css">
    <link rel="stylesheet" href="css/fetch.css">
    <link rel="stylesheet" href="css/report.css">
    <link rel="stylesheet" href="css/spinkit.css">

    <?php 
        echo "<script> 
        const DOCTOR_NAME = '".$_SESSION['doctor-fullname']."';
        const DOCTOR_EMAIL = '".$_SESSION['doctor-email']."';
        const DOCTOR_ID = '".$_SESSION['doctor-id']."';
        </script>"; 
    ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/jquery.js" defer></script>
    <script src="js/doctor-event-listeners.js" defer></script>
    <script src="js/doctor.js" defer></script>
    <!-- <script type="module" src="js/report.js" defer></script> -->
    <script src="js/logout.js" defer></script>

    <script src="view/build/pdf.js" defer></script>
</head>
<body>

    <h1 class="main-heading green-font">Reports on Blockchain</h1>

    <style>
        .test-pdf-creation{
            color: red;
            border-radius: 5px;
            border: 2px solid red;
            cursor: pointer;
            padding: 1em 2em;
        }
    </style>

    <nav class="dashboard-menu select-none">
        <div class="menu-container">            
            <div class="username green-bg" onclick="dropdown()">Doctor <?php echo $_SESSION['doctor-fullname']; ?></div>
            <a class="logout green-border green-font" href="logout.php">logout</a>
        </div>
    </nav>

    <section>
        <div class="local-report-list select-none">
        </div>
    </section>

    <section class="doctor-brc">
        <div class="blockchain-report-container select-none">
            <h1 class="green-font">Patient Reports on the Blockchain</h1>
            <h1 class="total-heading"><b class="green-font">6</b> Reports Total From <b class="green-font">3</b> patients</h1>
    
            <div class="doctor-reports-container">
                <div class="per-patient-container">
                    <div class="report-patient-name">Ibrahim</div>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Tuesday</span>
                        <div class="view-report-button">view report</div>
                    </a>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Wednesday</span>
                        <div class="view-report-button">view report</div>

                    </a>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Thursday</span>
                        <div class="view-report-button">view report</div>
                    </a>
                </div>

                <div class="per-patient-container">
                    <div class="report-patient-name">Ali Ahmed</div>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Tuesday</span>
                        <div class="view-report-button">view report</div>
                    </a>
                </div>


                <div class="per-patient-container">
                    <div class="report-patient-name">Susan</div>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Friday</span>
                        <div class="view-report-button">view report</div>
                    </a>
                    <a class="doctor-report-link">
                        <img src="images/pdf-icon-green.png" alt="">
                        <span class="detected-attribute">Covid Report Wednesday</span>
                        <div class="view-report-button">view report</div>

                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- <section>
        <div class="test-pdf-creation">Test PDF Creation</div>

        ISSSSSSSUEEEESS
        
    </section>  -->

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
            
            <form class="pdf-report-form">
                <div class="report-form-input-container user-search-container">
                    <span class="report-form-input-label">patient name</span>
                    <input class="report-form-input" oninput="fetchUsers(this)" placeholder="Patient Name" type="text" required>
                    <span class="release-input-lock" onclick="releaseInputThenFocus(this)"></span>
                    <div class="search-list-of-users">
                    </div>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient date of birth</span>
                    <input class="report-form-input patient-dob" placeholder="Date of Birth" type="text" disabled>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient gender</span>
                    <input class="report-form-input patient-gender" placeholder="Gender" type="text" disabled>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient blood group</span>
                    <input class="report-form-input patient-blood-group" placeholder="Blood Group" type="text" disabled>
                </div>

                <div class="report-form-input-container span-two">
                    <span class="report-form-input-label">patient email</span>
                    <input class="report-form-input patient-email" placeholder="Email" type="text" disabled>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">date of test</span>
                    <input class="report-form-input patient-date-of-test" placeholder="Date of Test" type="date" required>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">type of test</span>
                    <input class="report-form-input patient-type-of-test" placeholder="Type of Test" type="text" required>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">reason for testing</span>
                    <input class="report-form-input patient-reason-for-testing" placeholder="Reason for Testing" type="text" required>
                </div>

                <div class="report-form-input-container span-two">
                    <span class="report-form-input-label">symptoms</span>
                    <input class="report-form-input patient-symptoms" placeholder="Symptoms" type="text" required>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">covid result</span>
                    <input class="report-form-input patient-result" placeholder="Covid Result" type="text" required>
                </div>

                <div class="report-form-input-container span-three">
                    <span class="report-form-input-label">remarks</span>
                    <input class="report-form-input doctor-remarks" placeholder="Remarks" type="text" required>
                </div>

                <div class="report-form-input-container place-end">
                    <span class="report-form-input-label">Doctor Name</span>
                    <input class="report-form-input doctor-name" placeholder="Doctor Name" type="text" disabled>
                </div>

                <button class="submit-button stretch-x" type="button" onclick="createReport('covid',this)">Create Report</button>
                <div class="sk-bounce hidden-at-launch stretch-x create-report-loader">
                    <div class="sk-bounce-dot"></div>
                    <div class="sk-bounce-dot"></div>
                </div>
            </form>
        </div>


        <div class="popup create-new-report-popup select-none" id="blood-pressure-report-template">
            <span class="close-pop-up" onclick="closeAllTemplates(this); resetPDFReportForm(this);"></span>
            <h3 class="pop-up-title green-font">Create New Blood Pressure Report</h3>
            <span class="hint align-start">All fields marked with * are required. Data will be fetched for patient automatically after you select the patient's name.</span>
            
            <form class="pdf-report-form">
                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient name *</span>
                    <input class="report-form-input" placeholder="Patient Name" type="text" required>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient age</span>
                    <input class="report-form-input" placeholder="Patient Age" type="text" disabled>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">patient gender</span>
                    <input class="report-form-input" placeholder="Patient Name" type="text" disabled>
                </div>

                <div class="report-form-input-container">
                    <span class="report-form-input-label">blood pressure result *</span>
                    <input class="report-form-input" placeholder="Blood Pressure Result" type="text" required>
                </div>

                <div class="report-form-input-container stretch-x">
                    <span class="report-form-input-label">remarks *</span>
                    <textarea class="report-form-input stretch-y" placeholder="Remarks" type="text" resize="false" required></textarea>
                </div>

                <button class="submit-button stretch-x" type="button" onclick="createReport('blood-pressure',this)">Create Report</button>
                <div class="sk-bounce hidden-at-launch stretch-x create-report-loader">
                    <div class="sk-bounce-dot"></div>
                    <div class="sk-bounce-dot"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="overlay report-review-overlay">
        <span class="delete-pdf-button" data-animation="false" onclick="deleteAnimation(this)">
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
            <!-- <div class="centering-container"> -->
                <span class="close-pop-up blue-bg" id="report-review-close" onclick="closeReview()"></span>

                <canvas class="pdf-viewer">

                </canvas>
            <!-- </div> -->
    
        </div>
    </div>

    <span class="delete-pdf-button" data-animation="false" onclick="deleteAnimation(this)">
        <div class="sk-flow">
          <div class="sk-flow-dot"></div>
          <div class="sk-flow-dot"></div>
          <div class="sk-flow-dot"></div>
        </div>
    </span>
</body>
</html>