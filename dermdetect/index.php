<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DERM Detect</title>
    <link rel="stylesheet" href="css/main.css?22">
    <link rel="stylesheet" href="css/popup.css?6">
    <link rel="stylesheet" href="css/input.css?2">

    <script src="js/functions.js?1"></script>
    <script src="js/index.js?17" defer></script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsJcP3lhpz8_BASV-vQ7MQdCg_Ywlas5I&callback=console.debug&libraries=maps,marker&v=beta"></script>
</head>
<body>
    
    <div class="outer-container">

        <?php include 'components/startpage.php' ?>

        <div class="header">
            <h1 class="derm-detect-title">Derm Detect</h1>
            <div class="links">
                <a class="derm-button" href="#instructions">Instructions</a>
                <a class="derm-button" href="#skinInfo">Lesion Info</a>
                <a class="derm-button" href="#education">Educational Content</a>
                <a class="derm-button" href="#disclaimer">Disclaimer</a>
                <a class="derm-button" href="#map">Hospitals</a>
            </div>
        </div>

        <?php include 'components/instructions.php' ?>
        <?php include 'components/educational-content.php' ?>
        <?php include 'components/skin-info.php' ?>
        <?php include 'components/results.php' ?>
        <?php include 'components/map.php' ?>
        <?php include 'components/disclaimer.php' ?>

    </div>

    <?php include 'components/results-overlay.php' ?>
    <?php include 'components/upload-overlay.php' ?>

    <?php include 'components/hospitals.php' ?>

</body>
</html>