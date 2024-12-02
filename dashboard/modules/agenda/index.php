<?php 
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Appointment Booking System</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-/fBkZj3ZL/c6U9o6U4x+zsj2n0yM31NtNNFN6FU7CEk8JvSXo&amp;lt;=3K3M4h3VRENOEHNT9FwZx6U&amp;lt;" crossorigin="anonymous">
    </script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.10.0"></script>
  <script src="main.js"></script>

    <link rel="stylesheet" href="multi.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #F5F5F5;
			padding: 20px;
		}

	h1 {
		text-align: center;
		margin-bottom: 30px;
	}

	p {
		margin-bottom: 10px;
	}

	.form-group {
		margin-bottom: 20px;
	}

	label {
		display: block;
		margin-bottom: 5px;
		font-weight: bold;
	}

	select {
		display: block;
		padding: 10px;
		width: 100%;
		border: 2px solid #CCCCCC;
		border-radius: 5px;
		font-size: 16px;
		background-color: #FFFFFF;
		box-sizing: border-box;
	}

	button {
		display: block;
		margin-top: 20px;
		padding: 10px 20px;
		background-color: #0066CC;
		color: #FFFFFF;
		border: none;
		border-radius: 5px;
		font-size: 16px;
		text-align: center;
		text-decoration: none;
		cursor: pointer;
	}

	button:hover {
		background-color: #004C99;
	}

	.card {
		max-width: 500px;
		margin: 0 auto;
		background-color: #FFFFFF;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
	}

	.card h2 {
		margin-bottom: 20px;
		font-size: 24px;
		font-weight: bold;
		text-align: center;
	}

	.card img {
		display: block;
		margin: 0 auto 20px;
		max-width: 100%;
		border-radius: 50%;
	}

	.card p {
		text-align: center;
	}

	.form-container {
		max-width: 500px;
		margin: 0 auto;
		background-color: #FFFFFF;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
	}

	form {
		max-width: 100%;
		box-sizing: border-box;
	}
.container {
	display: flex;
	justify-content: center;
	align-items: center;
	gap: 10px;
	margin: 50px auto;
}

/* Modal Styles */
.modal {
	display: none;
	position: fixed;
	z-index: 1;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
	background-color: #fefefe;
	margin: 10% auto;
	padding: 20px;
	border-radius: 5px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
max-width: 500px;
}

.close {
color: #aaa;
float: right;
font-size: 28px;
font-weight: bold;
}

.close:hover,
.close:focus {
color: black;
text-decoration: none;
cursor: pointer;
}

table {
border-collapse: collapse;
width: 100%;
}

th, td {
text-align: left;
padding: 8px;
}

th {
background-color: #555;
color: white;
}

tr:nth-child(even) {
background-color: #f2f2f2;
}

tr:hover {
background-color: #ddd;
}

/* New Card Styles */
.card2 {
background-color: #f1f1f1;
padding: 20px;
box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
border-radius: 5px;
text-align: center;
max-width: 100px;
}

.card2 .button {
background-color: #4CAF50;
}

.card2 .button:nth-child(2) {
background-color: #008CBA;
}

.card2 .button:nth-child(3) {
background-color: #f44336;
}

.card2 .button:last-child {
background-color: #555;
}

/* Responsive Styles */
@media screen and (max-width: 768px) {
.container {
flex-direction: column;
}
.card2 {
	max-width: none;
	margin-top: 10px;
}
}

/* Hover Styles */
.card:hover {
box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.card2:hover {
box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.button:hover {
background-color: #555;
color: #fff;
}
</style>



<style>
/* Modal container */
.pmodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* Close button */
.pclose {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.pclose:hover,
.pclose:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}


/* Close button */
.lclose {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.lclose:hover,
.lclose:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
</head>
<body>
	<h1>My Agenda</h1>
	<div class="container">
	<div class="card">
		<img src="https://via.placeholder.com/150" alt="User Photo">
		<h2>Welcome, <span id="putName">App User</span></h2>
		<p>Thank you for choosing our Appointment Booking System. Please select a service and doctor below to get started.</p>
	</div>
	<div class="card" style="max-width: 200px;">
		<button class="button" style="background-color: #2196f3;" onclick="openpModal()">Prediction</button>
		<button class="button" style="background-color: #4CAF50;">Dashboard</button>
		<button class="button" style="background-color: #f44336; " onclick="openlModal()">Booking list</button>
		
		<button id="open-modal">Book appointment</button>
	</div>
</div>

<div id="mylModal" class="modal">
	<div class="modal-content" style="max-width: 500px;">
		<span class="lclose">&times;</span>
		<h2>Appointment Booking List</h2>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Service</th>
					<th>Doctor's Name</th>
					<th>Appointment status</th>
				</tr>
			</thead>
			<tbody id="appointmentList">
			</tbody>
		</table>
	</div>
</div>







  <!-- Modal -->
  <div id="mypModal" class="pmodal">
    <!-- Modal content -->
    <div class="modal-content">
      <span class="pclose">&times;</span>

  <h1>Predict Best time to book appointment</h1>
  <label for="dayOfWeek">Day of Week:</label>
  <select id="dayOfWeek">
    <option value="1">Monday</option>
    <option value="2">Tuesday</option>
    <option value="3">Wednesday</option>
    <option value="4">Thursday</option>
    <option value="5">Friday</option>
    <option value="6">Saturday</option>
    <option value="7">Sunday</option>
  </select>
  <label for="serviceType">Service Type:</label>
  <select id="serviceType">
    <option value="1">General Checkup</option>
    <option value="2">Specialist Consultation</option>
    <option value="3">Lab Test</option>
    <option value="4">Surgical Procedure</option>
    <option value="5">Follow-up Visit</option>
  </select>
  <button onclick="makePrediction()">Make Prediction</button>
      <div id="predictionResult"></div>
    </div>
  </div>








    <div id="my-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>AI.IoT Booking Service</h5>

            <div>
                <h1>Healthcare Appointment booking</h1>
                <div id="multi-step-form-container">
                    <!-- Form Steps / Progress Bar -->
                    <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                        <!-- Step 1 -->
                        <li class="form-stepper-active text-center form-stepper-list" step="1">
                            <a class="mx-2">
                                <span class="form-stepper-circle">
                            <span>1</span>
                                </span>
                                <div class="label">Personal details</div>
                            </a>
                        </li>
                        <!-- Step 2 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                            <span>2</span>
                                </span>
                                <div class="label text-muted">Select Service</div>
                            </a>
                        </li>
                        <!-- Step 3 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                            <span>3</span>
                                </span>
                                <div class="label text-muted">Chose Date/Time</div>
                            </a>
                        </li>
                        <!-- Step 4 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                            <span>4</span>
                                </span>
                                <div class="label text-muted">Payment Option</div>
                            </a>
                        </li>
                        <!-- Step 5 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="5">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                            <span>5</span>
                                </span>
                                <div class="label text-muted">Confirm</div>
                            </a>
                        </li>
                    </ul>
                    <!-- Step Wise Form Content -->
                    <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" method="POST">
                        <!-- Step 1 Content -->
                        <section id="step-1" class="form-step">

                            <h2 class="font-normal">Personal Details</h2>
                            <!-- Step 1 input fields -->
                            <div class="mt-3">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="mt-3">
                                <label for="email">Email Address:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="mt-3">
                                <label for="phone">Phone Number:</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="2">Next</button>
                            </div>


                        </section>
                        <!-- Step 2 Content, default hidden on page load. -->
                        <section id="step-2" class="form-step d-none">
                            <h2 class="font-normal">Medical Service</h2>
                            <!-- Step 2 input fields -->
                            <div class="mt-3">
                                <label for="service">Select a Service:</label>
                                <select name="service" id="service">
                            <option value="">-- Select a Service --</option>
                            <!-- options will be populated dynamically through ajax call -->
                        </select>
                            </div>
                            <div class="mt-3">
                                <label for="doctor">Select a Doctor:</label>
                                <select name="doctor" id="doctor">
                            <option value="">-- Select a Doctor --</option>
                            <!-- options will be populated dynamically through ajax call -->
                        </select>
                            </div>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="1">Prev</button>
                                <button class="button btn-navigate-form-step" type="button" step_number="3">Next</button>
                            </div>
                        </section>
                        <!-- Step 3 Content, default hidden on page load. -->
                        <section id="step-3" class="form-step d-none">
                            <h2 class="font-normal">Date/Time</h2>
                            <!-- Step 3 input fields -->
                            <div class="mt-3">
                                <label for="date">Choose a date:</label>
                                <input type="date" id="date" name="date">
                            </div>
                            <div class="mt-3">
                                <label for="time">Choose a time:</label>
                                <input type="time" id="time" name="time">
                            </div>
                            <div class="mt-3">
                                <button id="check-availability" class="button" type="button">Check Availability</button>
                            </div>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="2">Prev</button>
                                <button class="button btn-navigate-form-step btn-availability" type="button" step_number="4">Next</button>
                            </div>
                        </section>
                        <!-- Step 4 Content, default hidden on page load. -->
                        <section id="step-4" class="form-step d-none">
                            <h2 class="font-normal">Payment Details</h2>
                            <!-- Step 4input fields -->


                            <div class="mt-3">
                                <label for="payment_method">Payment Method</label>
                                <select id="payment_method" name="payment_method">
                          <option value="">-- Select a Payment Method --</option>
                          <option value="cash">Cash on Visit</option>
                          <option value="visa">Visa Card</option>
                        </select>
                            </div>

                            <div class="mt-3" id="visa_card_info" style="display:none">

                                <label for="invoice_amount">Invoice Amount</label>
                                <input type="text" id="invoice_amount" name="invoice_amount" value="$20">

                                <label for="card_number">Card Number</label>
                                <input type="text" id="card_number" name="card_number">

                                <button id="pay_button" type="button">Pay</button>
                            </div>

                            <!-- <div class="mt-3">
                        <button id="next_button" type="button" disabled>Next</button>
                      </div> -->



                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="3">Prev</button>
                                <button id="next_button" class="button btn-navigate-form-step to-confirm" type="button" step_number="5" disabled>Next</button>
                            </div>
                        </section>
                        <!-- Step 5 Content, default hidden on page load. -->
                        <section id="step-5" class="form-step d-none">
                            <h2 class="font-normal">Review and Confirm</h2>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Summary</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Name</h6>
                                            <p class="card-text" id="preview-name"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Email</h6>
                                            <p class="card-text" id="preview-email"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Service</h6>
                                            <p class="card-text" id="preview-service"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Doctor</h6>
                                            <p class="card-text" id="preview-doctor"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Date</h6>
                                            <p class="card-text" id="preview-date"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Time</h6>
                                            <p class="card-text" id="preview-time"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="4">Prev</button>
                                <button class="button submit-btn to-save" type="submit">Confirm</button>
                            </div>
                        </section>

                    </form>
                </div>
            </div>

        </div>
    </div>









<script>
var putname = sessionStorage.getItem('user');
var nameloc = document.getElementById('putName');
nameloc.innerHTML = putname;
    // Fetch data from the appointments table
    $.ajax({
        url: "getdata.php",
        method: "POST",
		data: {
			action:"get_appointments",
		},
        success: function(response) {
			console.log(response);
            var appointments = JSON.parse(response);
            var tbody = document.getElementById("appointmentList");
            appointments.forEach(function(appointment) {
                var tr = document.createElement("tr");
                tr.innerHTML = "<td>" + appointment.appointment_date + "</td><td>" + appointment.appointment_time + "</td><td>" + appointment.service_type + "</td><td>" + appointment.doctor_id + "</td> <td>" + appointment.appointment_status + "</td>";
                tbody.appendChild(tr);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
</script> 

<script>
	// Get the modal element
	var lmodal = document.getElementById("mylModal");

	// Get the <span> element that closes the modal
	var closelBtn = document.getElementsByClassName("lclose")[0];

	// When the user clicks the button, open the modal
	function openlModal() {
		lmodal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	closelBtn.onclick = function() {
		lmodal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == lmodal) {
			lmodal.style.display = "none";
		}
	}
</script>



<script>
// Get the modal PREDICTION MODAL
var pmodal = document.getElementById("mypModal");

// Get the button that opens the modal
var pbtn = document.getElementsByTagName("button")[0];

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("pclose")[0];

// When the user clicks on the button, open the modal
function openpModal() {
  pmodal.style.display = "block";
  
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  pmodal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == pmodal) {
    pmodal.style.display = "none";
  }
}

</script>
<script src="multi.js"></script>
</body>
</html>
