<head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
    /* Style for the time input when not focused */


    /* Style for the time input when focused */
  

</style>



</head>

<?php
// Connect to the MySQL database
include("../../includes/conn.php");

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

if (isset($_POST['updateBtn'])) {
    $appointmentId = $_POST['appointment_id'];
    $appointmentDate = $_POST["appointmentDate"];
    $appointmentTime = $_POST["appointmentTime"];
    $serviceType = $_POST["serviceType"];


    // Check if 'appointmentStatus' key exists in the $_POST array
    if (isset($_POST['appointmentStatus'])) {
        $appointmentStatus = $_POST['appointmentStatus'];

        // Perform database query to update the appointment data
        // Replace the placeholders below with your actual database connection code
        $sql = "UPDATE `appointments` SET `appointment_date` = '$appointmentDate', `appointment_time` = '$appointmentTime', `service_type` = '$serviceType', `appointment_status` = '$appointmentStatus' WHERE `appointment_id` = $appointmentId  ";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            // Appointment updated successfully
           
          
        } else {
            // Failed to update appointment
            echo "Error updating appointment: " . $conn->error;
         
        }
    } else {
        // 'appointmentStatus' key is not set in the $_POST array
        echo "Error updating appointment: Appointment status is missing.";
    }

 
}
?>



<div class="row" >
				<div class="col-md-12">
					<div class="tile">
                        <br><br>
						<div class="tile-body">
							<div class="table-responsive">
								<table class="display table-striped table-bordered table-sm" id="tableID" style=""> 
                                <br><br>
                                <thead style="height:12%;">

                         


										<tr align="center">
										<th style="background-color: #0A2558;color:white;">No</th>
								
										
										<th style="background-color: #0A2558;color:white;">appointment_date</th>
										<th style="background-color: #0A2558;color:white;">appointment_time</th>

                                        <th style="background-color:#0A2558;color:white;">service_type</th>
                                        <th style="background-color: #0A2558;color:white;">service_description</th>
                                        <th style="background-color:#0A2558; color:white;">appointment_status</th>
                                        <th style="background-color: #0A2558;color:white;">created_at</th>
                                        <th style="background-color:#0A2559;color:white;">Action</th> 
                                        
							
										</tr>
									</thead>
									<tbody>
										<?php
                                          $getOfferType = mysqli_query($conn, "SELECT * FROM `appointments` ") or die(mysqli_error($conn));
                                           if (mysqli_num_rows($getOfferType) >= 1) {
                                            $sn=1;
                                            while ($rs = mysqli_fetch_array($getOfferType)) {
										            
			
            											?>
            											<tr id="row_<?php echo $rs[0]; ?>">
															

															<td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"> <?php echo $sn;?></td>
            										
            													<td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;"  align="center"><?php echo  $rs[3]; ?></td>
            													<td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"><?php echo $rs[4]; ?></td>
            													<td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"><?php echo  $rs[5]; ?></td>
                                                                <td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"><?php echo  $rs[6]; ?></td>
                                                                <td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"><?php echo  $rs[7]; ?></td>
                                                                <td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;" align="center"><?php echo  $rs[8]; ?></td>
                                                            
                                                                <td style="box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;">
                                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                                                <form method="POST" action="fetch_data.php" onsubmit="event.preventDefault();">
                                                               
  <input type="submit" class="btn btn-success" style="display:none" onclick="showPopup(<?php echo $rs['appointment_id']; ?>)" value="" data-placement="top" />
  <img src="image/editbtn.png" style="width:20px; cursor:pointer;" onclick="showPopup(<?php echo $rs['appointment_id']; ?>)" alt="Edit Button">


</form>

<script>
  function showPopup(id) {
    document.getElementById('id01').style.display = 'block';
    sendData(id);
    

  

    
  }
  function sendData(id) {
  $.ajax({
    url: 'fetch_data.php',
    type: 'GET',
    data: { 'id': id },
    success: function(data) {
      // Handle the response from the server
      console.log(data);

      // Access the individual values from the JSON response
      var appointment_id = data.appointment_id;
      var appointment_date = data.appointment_date;
      var appointment_time = data.appointment_time;
      var service_type = data.service_type;
      var service_description = data.service_description;
        var appointment_status=data.appointment_status;
       var created_at=data.created_at;

        console.log(created_at);

      // Update input elements with the retrieved data
      document.getElementById('created_at').value = created_at;
      document.getElementById('appointment_id').value = appointment_id;
      document.getElementById('appointment_date').value = appointment_date;
      document.getElementById('appointment_time').value = appointment_time;
      document.getElementById('service_description').value = service_description;

      // Set the selected option in the service_type <select> element
      document.getElementById('service_type').value = service_type;
      document.getElementById('option_value').textContent = service_type;


      document.getElementById('appointment_status').value = appointment_status;
      document.getElementById('appointment_statusO').textContent = appointment_status;
      
      // Call any additional functions or update the UI as needed
    },
    error: function(err) {
      // Handle error
      console.log(err);
    }
  });
}



</script>










<button name="appointmentId" value="<?php echo $rs[0]; ?>" onclick="confirmDelete(this)" style="color:white;border-style:none;background-color:transparent; cursor:pointer;">
    <div class="item">
        <img src="image/delete.png" style="width:20px;" id="delete">
    </div>
</button>

<script>
    function confirmDelete(button) {
        var confirmResult = confirm("Are you sure you want to delete this item?");
        if (confirmResult) {
            var appointmentId = button.value;

            // Send an AJAX request to delete.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Process the response from delete.php
                    console.log(xhr.responseText);

                    // Remove the deleted row from the table
                    var row = button.closest('tr');
                    if (row) {
                        row.parentNode.removeChild(row);
                    }
                }
            };
            xhr.send("appointmentId=" + appointmentId);
        }
    }
</script>

</td>
                                                            </tr>
												</form>
            											<?php
    										        
												
											$sn++;}} else { ?>
						  <tr>
						   <td colspan="8">No data found</td>
						  </tr>
					   <?php } ?>

									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>






<input type="hidden" id="service_description" value="">



<div class="w3-container">
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>

            <br>
            <form id="editForm" method="POST" action="">
           


            <input type="hidden" id="appointment_id" value="" name="appointment_id">
                                
            <label for="createdAt">Created At:</label>
                                <input type="text" id="created_at"  name="createdAt" value="" name="createdAt" disabled>
        
                                <br>
         <br>
         <label for="appointmentDate">Appointment Date:</label>
          <input type="date" class="form-control" id="appointment_date" name="appointmentDate" min="<?php echo date("Y-m-d"); ?>"value=""  >
          
         <br>
         <br>
        

         <label for="appointmentTime">Appointment Time:</label>
<input type="time" id="appointment_time" style="" value="" name="appointmentTime" oninput="updateAppointmentTime(this.value)"><br><br>

<script>
    function updateAppointmentTime(value) {
        var timeParts = value.split(":");
        var hours = timeParts[0];
        var minutes = timeParts[1];
       
        console.log("Hours: " + hours);
        console.log("Minutes: " + minutes);
    }
</script>

<input type="hidden" id="service_type" value="" name="serviceType">
<label for="serviceType">Service Type:</label>
<select class="form-select" name="newSkill" id="newSkill" onchange="getValue1(this)" required>
  <option selected disabled id="option_value"></option>
  <option value="1">Procedure</option>
  <option value="2">Checkup</option>
  <option value="3">Consultation</option>
  <option value="4">Dentistry</option>
  <option value="5">General Medicine</option>
</select>

<script>
function getValue1(obj) {
  var text = obj.options[obj.selectedIndex].innerHTML;
  document.getElementById('service_type').value = text;
}
</script>



<br><br>
<input type="hidden" id="appointment_status" value="" name="appointmentStatus" required>

<label for="appointmentStatus">Appointment Status:</label>
<select class="form-select" name="newSkill" id="newSkill" onchange="getValue2(this)" required>
  <option selected disabled id="appointment_statusO"></option>
  <option value="1">Pending</option>
  <option value="2">Confirmed</option>
</select>

<script>
function getValue2(obj) {
  var text = obj.options[obj.selectedIndex].innerHTML;
  document.getElementById('appointment_status').value = text;
}
</script>


<br><br>
                         
                            
                            </tr>
                 
                    <br>
                    <div class="modal-footer" style="">
                        <button type="submit" name="updateBtn" class="w3-button w3-green">Update</button>
                        <br><br>
                    </div>
            </form>