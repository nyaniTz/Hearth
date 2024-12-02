<!DOCTYPE html>
<html>
<head>
	<title>Appointment Booking Form</title>
	<style>
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		h1 {
			text-align: center;
			margin-top: 50px;
		}

		form {
			max-width: 500px;
			margin: 50px auto;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}

		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
		}

		input[type="text"],
		input[type="email"],
		input[type="tel"],
		select {
			display: block;
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border-radius: 5px;
			border: none;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
		}

		input[type="submit"] {
			background-color: #4caf50;
			color: #fff;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			font-weight: bold;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<h1>Appointment Booking Form</h1>
	<section>
		<form action="confirmation.php" method="post">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" required>

			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>

			<label for="phone">Phone:</label>
			<input type="tel" id="phone" name="phone" required>

			<label for="service">Service:</label>
			<select id="service" name="service" required>
				<option value="dentist">Dentist</option>
				<option value="optometrist">Optometrist</option>
				<option value="physiotherapist">Physiotherapist</option>
			</select>

			<label for="date">Date:</label>
			<input type="date" id="date" name="date" required>

			<label for="time">Time:</label>
			<input type="time" id="time" name="time" required>

			<input type="submit" value="Book Appointment">
		</form>
	</section>
</body>
</html>
