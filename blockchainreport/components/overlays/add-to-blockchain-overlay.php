<div class="overlay add-to-blockchain-overlay">
    <div class="popup add-to-blockchain-view select-none">
        <h3 class="pop-up-title">Add to Blockchain</h3>
        <div class="report-details-container">
            <img src="images/pdf-icon-orange.png" alt="" class="pdf-icon">
            <div class="report-details rp-dt-fill">
            </div>
        </div>

        <div class="permission-container">
            <h3 class="extra-small-font pop-up-title">People To Notify</h3>
            
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
                    <div class="confirm-button add-to-blockchain" onclick="confirmAddToBlockchain()">Confirm Payment</div>
                </div>
            </div>
        </div>
    </div>  
</div>