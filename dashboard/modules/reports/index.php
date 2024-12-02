<!DOCTYPE html>
<html>
<head>
	<title>Generate Reports</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="script.js"></script>


</head>
<body>
	<div class="container">
		<h1 class="my-form">Generate Reports</h1>
		<form class="my-form" method="post" action="">
			<label for="report_type">Report Type:</label>
			<select id="report_type" name="report_type" onchange="toggleFields()">
				<option value="list">List Report</option>
				<option value="individual">Individual Report</option>
			</select>
			<div id="table_name_div">
				<label for="table_name">Table Name:</label>
				<select id="table_name" name="table_name" style="display: block;">
					<?php
                        
                        // Connect to the database
                        $dbHost = "localhost";
                        $dbUser = "aiiovdft_health";
                        $dbPass = "Marvelyiky";
                        $dbName = "aiiovdft_health";

						$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

						// Check connection
						if ($conn->connect_error) {
						    die("Connection failed: " . $conn->connect_error);
						}

						// Fetch table names from MySQL database
						$sql = "SHOW TABLES";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
						        echo "<option value='".$row["Tables_in_aiiovdft_health"]."'>".$row["Tables_in_aiiovdft_health"]."</option>";
						    }
						} else {
						    echo "<option value=''>No tables found</option>";
						}

						$conn->close();
					?>
				</select>
			</div>
			<div id="patient_name_div" style="display: none;">
				<label for="patient_name">Patient Name:</label>
				<select id="patient_name" name="patient_name">
					<?php
                        // Connect to the database
                        $dbHost = "localhost";
                        $dbUser = "aiiovdft_health";
                        $dbPass = "Marvelyiky";
                        $dbName = "aiiovdft_health";

						$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

						// Check connection
						if ($conn->connect_error) {
						    die("Connection failed: " . $conn->connect_error);
						}

						// Fetch patient names from MySQL database
						$sql = "SELECT name, user FROM patients";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
						    while($row = $result->fetch_assoc()) {
						        echo "<option value='".$row["user"]."'>".$row["name"]."</option>";
						    }
						} else {
						    echo "<option value=''>No patients found</option>";
						}

						$conn->close();
					?>
				</select>
			</div>
			<div id="date_range_div" style="display: none;">
				<label for="start_date">Start Date:</label>
				<input type="date" id="start_date" name="start_date">
				<label for="end_date">End Date:</label>
				<input type="date" id="end_date" name="end_date">
</div>
<input type="submit" name="generate_report" value="Generate Report">
</form>
</div>

</body>
</html>
<?php
                        // Connect to the database
                        $dbHost = "localhost";
                        $dbUser = "aiiovdft_health";
                        $dbPass = "Marvelyiky";
                        $dbName = "aiiovdft_health";

						$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the report type
        $type = $_POST["report_type"];

        // Get the table name or patient name depending on the report type
        if ($type == "list") {
            $table_name = $_POST["table_name"];
        } else {
            $patient_name = $_POST["patient_name"];
        }

        // Get the start and end dates
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];

        // Do something with the form data, such as generate a report
        // ...
    }

    // Print the company name and logo at the report header
    echo "<div style='display:flex; justify-content: space-between; align-items: center;'>
            <img src='aiiot_logo.png' alt='Company Logo' style='height:50px; margin-right: 20px;'>
            <h1 style='font-size: 2.5rem;'>AI.IoT Research Center</h1>
         </div>";

    //$type = $_GET["type"]; // - this line has been commented out for security purposes

    if ($type == "list") {
        //$table_name =  filter_input(INPUT_GET, "table_name", FILTER_SANITIZE_STRING);
        $sql = "SELECT * FROM `$table_name`";
        $result = $conn->query($sql);
	

        if ($result->num_rows > 0) {
            echo "<table><tr>";
            $i=0;
            while ($row = $result->fetch_assoc()) {
                if ($i == 0) {
                    foreach ($row as $key => $value) {
                        echo "<th>" . htmlspecialchars($key) . "</th>";
                    }
                    echo "</tr><tr>";
                }
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr><tr>";
                $i++;
            }
            echo "</tr></table>";
		echo "<br><br><br><button class='my-form' onclick='window.print()'>Print Report</button>";
        } else {
            echo "No records found.";
        }
    } else if ($type == "individual") {
        $patient_id = $patient_name; //filter_input(INPUT_GET, "patient_id", FILTER_SANITIZE_NUMBER_INT);
        $from_date = $start_date; //filter_input(INPUT_GET, "from_date", FILTER_SANITIZE_STRING);
        $to_date = $end_date; //filter_input(INPUT_GET, "to_date", FILTER_SANITIZE_STRING);

        $sql = "SELECT * FROM `patients` WHERE `user` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $patient_id);
        $stmt->execute();
        $result = $stmt->get_result();

	

	
	

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>Patient: " . htmlspecialchars($row["Name"]) . "</h2>";

	//echo "<h2>AI Predicted State of Health</h2>";
	echo "<h3><div id='result', style='background-color:gray; height:50px; color:black; border-radius:10px'> AI Prediction Here </div></h3>";

echo "<h4>HeartRate: " . htmlspecialchars($row["HeartRate"]) . "</h4>";
echo "<h4>Temperature: " . htmlspecialchars($row["Temp"]) . "</h4>";
echo "<h4>SpO2: " . htmlspecialchars($row["SpO2"]) . "</h4>";
echo "<h4>Age: " . htmlspecialchars($row["Age"]) . "</h4>";
echo "<h4>BMI: " . htmlspecialchars($row["BMI"]) . "</h4>";
echo "<h4>DBP: " . htmlspecialchars($row["DBP"]) . "</h4>";
echo "<hr>";

            echo "<p>From: " . htmlspecialchars($from_date) . " To: " . htmlspecialchars($to_date) . "</p>";
			$sql = "SELECT * FROM `schedules` WHERE `user` = ? AND `date` BETWEEN ? AND ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sss", $row["user"], $from_date, $to_date);
			$stmt->execute();
			$result = $stmt->get_result();
		
			if ($result->num_rows > 0) {
				echo "<table><tr>";
				$i=0;
				while ($row = $result->fetch_assoc()) {
					if ($i == 0) {
						foreach ($row as $key => $value) {
							echo "<th>" . htmlspecialchars($key) . "</th>";
						}
						echo "</tr><tr>";
					}
					foreach ($row as $value) {
						echo "<td>" . htmlspecialchars($value) . "</td>";
					}
					echo "</tr><tr>";
					$i++;
				}
				echo "</tr></table>";
			} else {
				echo "No records found in Patients Medical history in this date range.";
				echo "<br><br><br><button onclick='window.print()'>Print Report</button>";
			}
		} else {
			echo "Invalid request type.";
			echo "<br><br><br><button class='my-form' onclick='window.print()'>Print Report</button>";
		}
		
		// close the database connection
		$conn->close();
	}
?>




<?php
// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the input data sent from the JavaScript
    // $inputData = $_POST['inputData'];

    // Load the TensorFlow.js library
    $tfjs = file_get_contents('https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.8.0/dist/tf.min.js');
    echo '<script>' . $tfjs . '</script>';

    // Load the model
    echo '<script>
            async function makePrediction() {
                // Load the saved model
                const model = await tf.loadLayersModel("model.json");

                // Retrieve the patient data from the database
                const response = await fetch("fetch_health_data.php?user=document.getElementById(\'patient_name\').value");
                const data = await response.json();

                // Extract the required input features from the fetched data
                const heartRate = parseFloat(data.HeartRate);
                const temperature = parseFloat(data.Temp);
                const dbp = parseFloat(data.DBP);
                const spo2 = parseFloat(data.SpO2);
                const age = parseFloat(data.Age);
                const bmi = parseFloat(data.BMI);

                // Create a sample input tensor for prediction
                const sampleInput = tf.tensor2d([[heartRate, temperature, dbp, spo2, age, bmi]]);

                // Perform prediction
                const prediction = model.predict(sampleInput);
                const predictedValue = prediction.dataSync()[0];
                let predictedState;

                if (predictedValue < 0.5) {
                    predictedState = "Healthy";
                    predictedValue = 1 - predictedValue;
                } else {
                    predictedState = "Not Healthy";
                }

                // Display the prediction result on the web page
                document.getElementById("result").innerText = `AI Predicted State: ${predictedState}, Probability: ${predictedValue.toFixed(3)*100} % Sure`;

                // Send the predicted value and state back to PHP
                const predictedValueInput = document.createElement("input");
                predictedValueInput.setAttribute("type", "hidden");
                predictedValueInput.setAttribute("name", "predictedValue");
                predictedValueInput.setAttribute("value", predictedValue.toFixed(2));
                document.getElementById("form").appendChild(predictedValueInput);

                const predictedStateInput = document.createElement("input");
                predictedStateInput.setAttribute("type", "hidden");
                predictedStateInput.setAttribute("name", "predictedState");
                predictedStateInput.setAttribute("value", predictedState);
                document.getElementById("form").appendChild(predictedStateInput);

                // Submit the form to PHP
                document.getElementById("form").submit();
            }
            makePrediction();
        </script>';
}
?>
