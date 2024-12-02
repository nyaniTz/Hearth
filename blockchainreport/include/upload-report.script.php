<?php
    $name = $_FILES['pdf']['name'];
    $path = "../reports/";

    move_uploaded_file(
        $_FILES['pdf']['tmp_name'], 
        $path.$name
    );
?>