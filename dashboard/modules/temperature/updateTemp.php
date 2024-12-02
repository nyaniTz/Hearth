<?php

include('../../../includes/conn.php');




if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sensorData = $_POST['temp'];
    $sensorDataToArr = explode("\n", $sensorData);
    $CurentTemp=$sensorDataToArr[0];
    // $CurentTemp=$sensorData;
 $UName="jsmith";
 
    $query="UPDATE `patients` SET `Temp`='$CurentTemp' WHERE `user`='$UName'";
    if(mysqli_query($conn, $query)){
        
        $sql ="SELECT * FROM `patienntTemp` WHERE `userName`='$UName'";
        $res = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($res)>0){
            
            $row = mysqli_fetch_assoc($res);
            
            $temp=$row['Temp'];
            $tempArray = explode(" ", $temp);
            array_shift($tempArray);
            $CurentTemp = str_replace(array("\n", "\r","  "), '', $CurentTemp);
            // $CurentTemp = str_replace("\r\n", "", $CurentTemp);
            array_push($tempArray,$CurentTemp);
            $tempString =implode(" ",$tempArray);
            
            
            $recUpdQue="UPDATE `patienntTemp` SET `Temp`='$tempString' WHERE `userName`='$UName'";
            mysqli_query($conn, $recUpdQue); 
                
        }
        
        
    }
    
    
    
   
}
else{
    $query="UPDATE `patients` SET `Temp`='404' WHERE `ID`=1";
    mysqli_query($conn, $query);
}

?>