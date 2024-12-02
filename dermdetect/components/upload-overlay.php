<div class="overlay upload">
    <div class="popup">
        <div class="popup-body">
            <h1 class="pop-up-title">Upload a picture from your device</h1>
            <form class="upload-area" name="upload-form">
                <!-- <div class="derm-button">upload an image</div> -->

                <label for="images" class="drop-container" id="dropcontainer">
                <span class="drop-title">Take an image of your skin or select a photo from your gallery.</span>
                <input type="file" id="images" accept="image/*" capture="environment" required>
                </label>
                
                <progress value="0" max="100"></progress>

                <div class="loader">
                    Detecting...
                </div>
            </form>

            <div class="two-column-grid">
                <div class="derm-button danger" onclick="closeUploadPopup()">cancel</div>
                <div class="derm-button" onclick="startDermProcess()">start detection</div>
            </div>
        </div>
    </div>
</div>