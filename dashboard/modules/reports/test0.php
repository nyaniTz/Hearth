<?php
// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the input data sent from the JavaScript
    $inputData = $_POST['inputData'];

    // Load the TensorFlow.js library
    $tfjs = file_get_contents('https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.8.0/dist/tf.min.js');
    echo '<script>' . $tfjs . '</script>';

    // Load the model
    echo '<script>
            async function makePrediction(event) {
                event.preventDefault();
                // Load the saved model
                const model = await tf.loadLayersModel("model.json");

                // Create a sample input tensor for prediction
                const sampleInput = tf.tensor2d([[${$inputData}]]);

                // Perform prediction
                var prediction = model.predict(sampleInput);
                var predictedValue = prediction.dataSync()[0];
                var predictedState;

                if (predictedValue < 0.5) {
                  predictedState = "Healthy";
                  predictedValue = 1 - predictedValue;
                } else {
                  predictedState = "Not Healthy";
                }

                // Display the prediction result on the web page
                document.getElementById("result").innerText = `Predicted State: ${predictedState} | Probability: ${predictedValue.toFixed(2)}% Sure`;
            }
            makePrediction();
        </script>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Model Prediction</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Model Prediction</h1>
    <form id="myForm">
        <p><h3>Enter 6 Health parameter values separated by commas in the format:</h3></p>
        <p><h2>HeartRate, Temperature, DBP, SpO2, Age, BMI</h2></p>
        <label for="inputData">Enter Input Data:</label>
        <input type="text" id="inputData" name="inputData" required>
        <button type="button" onclick="submitForm()">Submit</button>
    </form>
    <div id="result"></div>

    <script>
        function submitForm() {
            // Get form data
            var formData = $('#myForm').serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'https://health.aiiot.website/dashboard/modules/reports/test0.php', // Specify the URL where the request should be sent
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>

