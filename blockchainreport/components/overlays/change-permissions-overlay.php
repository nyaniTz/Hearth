<div class="overlay change-permissions-overlay">
    <div class="popup change-permissions-view">
        <div class="popup-header">
            <h3 class="popup-title"></h3>
            <div class="close-button" onclick="closeChangePermissionsPopUp()">
                <img src="images/close.png">
            </div>
        </div>

        <div class="permission-container popup-body"> 
            <div class="report-share-link"></div>

            <div class="permission-items-list blockchain-permission-items-list"> 
            </div>

            <div class="permission-item-add">
                <input class="add-permission-item-input" placeholder="Add New Person" type="text">
                <span class="add-person-button">
                    <img src="images/plus.png" alt="">
                </span>
            </div>
        </div>

        <div class="popup-footer">
            <button type="button" class="confirm-button change-permissions-button" onclick="openConfirmPermissionChanges()">Apply Changes</button>
        </div>
    </div>  
</div>