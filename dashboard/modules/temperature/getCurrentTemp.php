  <?php
  include('../../../includes/conn.php');
$table ="<table><tr>
    <th colspan='5'>
        Patients Data
    </th>
  </tr>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Sex</th>
    <th>Age</th>
    <th>Address</th>
    <th>Temprature</th>
    <th>View Graphical</th>
  </tr>
";
$sql ="SELECT * FROM `patients`";
$res = mysqli_query($conn, $sql);
if(mysqli_num_rows($res)>0){
    while($row = mysqli_fetch_assoc($res)){
        $table .="<tr>";
        $table .= "<td>".$row['ID']."</td>";
        $table .= "<td>".$row['Name']."</td>";
        $table .= "<td>".$row['Sex']."</td>";
        $table .= "<td>".$row['Age']."</td>";
        $table .= "<td>".$row['Address']."</td>";
        $table .= "<td>".$row['Temp']."</td>";
        $table .= "<td><a href='dataGraph.php?UName=".$row['user']."'>See Graph</a></td>";
        $table .= "</tr>";
    }
    
}
$table .= "</table>";
echo $table;
?>