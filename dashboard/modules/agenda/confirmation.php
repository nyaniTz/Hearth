<!DOCTYPE html>
<html>
<head>
	<title>Appointment Confirmation</title>
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

		.container {
			max-width: 500px;
			margin: 0 auto;
			background-color: #FFFFFF;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
		}

		.details {
			margin-bottom: 20px;
		}

		label {
			display: inline-block;
			margin-bottom: 5px;
			font-weight: bold;
		}

		p {
			margin-bottom: 10px;
		}

		button {
			display: block;
			margin: 20px auto 0;
			padding: 10px 20px;
			background-color: #0066CC;
			color: #FFFFFF;
			border: none;
			border-radius: 5px;
			font-size: 16px;
			cursor: pointer;
		}

		button
{
display: block;
margin: 20px auto 0;
padding: 10px 20px;
background-color: #0066CC;
color: #FFFFFF;
border: none;
border-radius: 5px;
font-size: 16px;
cursor: pointer;
}

	button:hover {
		background-color: #004C99;
	}

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
		margin: 15% auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
		max-width: 500px;
		border-radius: 10px;
		box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
	}

	.modal-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 20px;
	}

	.modal-header h2 {
		margin: 0;
	}

	.modal-close {
		color: #aaa;
		font-size: 28px;
		font-weight: bold;
		cursor: pointer;
	}

	.modal-close:hover,
	.modal-close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}

	.modal-body {
		margin-bottom: 20px;
	}

	 .paid-text {
      display: none;
      text-align: center;
      margin-top: -10px;
      font-weight: bold;
      color: green;
    }
</style>

</head>
<body>
	<div class="container">
		<h1>Appointment Confirmation</h1>
		<div class="details">
			<label>Name:</label>
			<p><?php echo $_POST['name']; ?></p>

		<label>Email:</label>
		<p><?php echo $_POST['email']; ?></p>

		<label>Phone:</label>
		<p><?php echo $_POST['phone']; ?></p>

		<label>Service:</label>
		<p><?php echo ucfirst($_POST['service']); ?></p>

		<label>Date:</label>
		<p><?php echo date('D, j M Y', strtotime($_POST['date'])); ?></p>

		<label>Time:</label>
		<p><?php echo date('g:i A', strtotime($_POST['time'])); ?></p>
	</div>
	<button id="payment-btn">Proceed to payment</button>
</div>

<!-- Modal -->
<div id="payment-modal" class="modal">
	<div class="modal-content">
		<div class="modal-header">
			<h2>Payment Details</h2>
			<span class="modal-close">&times;</span>
		</div>
		<div class="modal-body">
			<form id="payment-form" method="POST">
				<label for="card-number">Card Number:</label>
				<input type="text" id="card-number" name="card-number" required>
				<br>
				<label for="expiration-date">Expiration Date:</label>
				<input type="month" id="expiration-date" name="expiration-date" required">
<br>
<label for="security-code">Security Code:</label>
<input type="number" id="security-code" name="security-code" required>
<br>
<button type="submit">Pay Now</button>
</form>
</div>
</div>

</div>
<script>
// Get the modal
var modal = document.getElementById("payment-modal");

// Get the button that opens the modal
var btn = document.querySelector("button");

// Get the <span> element that closes the modal
var span = document.querySelector(".modal-close");

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
  btn.textContent = "Return Home";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  btn.textContent = "Proceed to payment";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    btn.textContent = "Proceed to payment";
  }
}

// Add listener to payment form submit event
var paymentForm = document.getElementById("payment-form");
paymentForm.addEventListener("submit", function(event) {
  event.preventDefault(); // prevent form from submitting
  var paidText = document.createElement("p");
  paidText.textContent = "BOOKING PAID AND VALIDATED";
  var container = document.querySelector(".container");
  container.insertBefore(paidText, container.firstChild);
  modal.style.display = "none";
  btn.onclick = function() {
    window.location.href = "index.php";
  };
});
</script>
</body>
</html>
