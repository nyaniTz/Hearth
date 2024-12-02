<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/popup.css">
    <link rel="stylesheet" href="css/permissions.css">
    <script src="js/logout.js" defer></script>
    <script src="js/patient.js" defer></script>
</head>
<body>

    <h1 class="main-heading">Reports on Blockchain</h1>

    <nav class="dashboard-menu select-none">
        <div class="disconnect-button">Disconnect</div>
        <div class="menu-container">
            <div class="overflow-container">
                <div class="metamask-address">0x4FB85eC5b96037eA1e09594C2D673b6C9e597f90</div>
                <div class="username" onclick="dropdown()"><?php echo $_SESSION['patient-username']; ?></div>
            </div>
            <a class="logout" href="logout.php">logout</a>
        </div>
    </nav>

    <section>
        
        <div class="local-report-list select-none">
            <h3 class="small-font report-title">New Health Reports From Doctors</h3>
            <div class="report-item">
                <div class="report-item-itemization">1.</div>
                <div class="report-item-name">Covid Report</div>
                <div class="report-item-buttons">
                    <!-- <a href="#" class="report-button review">Review</a> -->
                    <div class="report-button add-to-blockchain" data-reportid="123456" onclick="openAddToBlockChainPopUp(this)">Add to Blockchain</div>
                </div>
            </div>

            <div class="report-item">
                <div class="report-item-itemization">2.</div>
                <div class="report-item-name">Heart Rate Report</div>
                <div class="report-item-buttons">
                    <!-- <a href="#" class="report-button review">Review</a> -->
                    <div class="report-button add-to-blockchain" data-reportid="123456" onclick="openAddToBlockChainPopUp(this)">Add to Blockchain</div>
                </div>
            </div>
        </div>
    </section>

    <section>

        <div class="metamask-container select-none">
            <img class="bg-image place-absolute" src="images/metamask-icon.png" alt="">
            
            <div class="inner-grid">
                <div class="metamask-button connect-wallet"></div> 
                <span class="metamask-attribute detected-browser"></span>
            </div>

            <h1 class="total-heading brown-font"><b>6</b> Reports Detected on Blockchain</h1>
    
            <div class="reports-container">
                <div class="report-link"> <!-- turn link into an anchor element -->
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">Covid Report Wednesday</span>
                </div>
    
                <div class="report-link">
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">High Blood Pressure Report Thursday</span>
                </div>
    
                <div class="report-link">
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">High Blood Pressure Report Friday</span>
                </div>
    
                <div class="report-link">
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">High Blood Pressure Report Saturday</span>
                </div>
    
                <div class="report-link">
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">High Blood Pressure Report Sunday</span>
                </div>
    
                <div class="report-link">
                    <img src="images/pdf-icon-orange.png" alt="">
                    <span class="detected-attribute">High Blood Pressure Report Monday</span>
                </div>
            </div>
        </div>

    </section>

    <section class="instructions">
        <h1 class="heading">Instructions</h1>
        <ol>
            <li class="brown-font">Make sure you have metamask installed as an extension on your browser.
            </li>

            <li class="brown-font">If you don't have metamask installed, you can install it from <a class="link" href="https://metamask.io/download/">https://metamask.io/download/</a>
            </li>
            
            <li class="brown-font">Connect to you wallet on this page, and accept the connection.
            </li>

            <li class="brown-font">Verify the pdf from the doctor before saving it onto the blockchain.
            </li>

            <li class="brown-font">Remember to disconnect before logging out.
            </li>
        </ol>
    </section>

    <div class="overlay add-to-blockchain-overlay">
        <div class="popup add-to-blockchain-view select-none">
            <h3 class="pop-up-title">Add to Blockchain</h3>
            <div class="report-details-container">
                <img src="images/pdf-icon-orange.png" alt="" class="pdf-icon">
                <div class="report-details">
                    <div class="report-name"><b>Name:</b> High Blood Pressure Report</div>
                    <div class="report-owner"><b>Owner:</b> Ibrahim Ame</div>
                    <div class="report-doctor"><b>Doctor:</b> John Wayans </div>
                    <div class="report-date"><b>Date Created:</b> 22/02/2023</div>
                    <div class="report-filetype"><b>FileType:</b> typex/PDF</div>
                </div>
            </div>

            <div class="permission-container">
                <h3 class="extra-small-font pop-up-title">Permissions to View</h3>
                
                <div class="permission-items-list">
                </div>
            </div>

            <div class="confirmation-buttons">
                <div class="confirm-button cancel" onclick="closeAddToBlockChainPopUp()">Cancel</div>
                <div class="confirm-button add-to-blockchain" onclick="openConfirmDialog()">Add Report To Blockchain</div>
            </div>

            <div class="overlay confirm-add-overlay">
                <div class="popup confirm-popup-view">
                    <h3 class="small-font pop-up-title">Confirm</h3>
                    <div class="popup-message">
                    </div>
                    <div class="confirmation-buttons" style="margin: 0;">
                        <div class="confirm-button cancel" onclick="closeConfirmPopUp()">No</div>
                        <div class="confirm-button add-to-blockchain" onclick="confirmAddToBlockchain()">Yes</div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</body>
</html>