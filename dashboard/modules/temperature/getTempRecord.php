  <?php
  include('../../../includes/conn.php');
  if(isset($_REQUEST["UName"])){
    //   echo $_REQUEST["UName"];
  }
  $UName=$_REQUEST['UName'];
$sql ="SELECT * FROM `patienntTemp` WHERE `userName`='$UName'";
$res = mysqli_query($conn, $sql);
if(mysqli_num_rows($res)>0){
    $row = mysqli_fetch_assoc($res);
    $temp=$row['Temp'];
        $tempArray = json_encode(explode(" ", $temp));
        // print_r ($tempArray);
       
    
}

 echo '
 <div>
    <h3>
        Patient Name : '.$UName.'
    </h3>
</div>
 <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
<script>
var xValues = [1,3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48,51,54,57,60];
var yValues = [];
//yValues[0]=1;
yValues.push(1);
new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: '.$tempArray.',
      borderColor: "blue",
      fill: false
    }, { 
      data: [37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,50,20],
      borderColor: "green",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script>';
?>
