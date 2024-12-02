async function makePrediction() {
    // Load the saved model
    const model = await tf.loadLayersModel('model.json');
  
    // Get the selected options from the dropdown menus
    const dayOfWeekSelect = document.getElementById('dayOfWeek');
    const selectedDayOfWeek = parseInt(dayOfWeekSelect.value);
  
    const serviceTypeSelect = document.getElementById('serviceType');
    const selectedServiceType = parseInt(serviceTypeSelect.value);
  
    // Create an input tensor for prediction
    const input = tf.tensor2d([[selectedDayOfWeek, selectedServiceType]]);
  
    // Perform prediction
    const prediction = model.predict(input);
    const predictedClass = prediction.argMax(1).dataSync()[0];
    const probability = prediction.dataSync()[predictedClass].toFixed(2);
  
    // Display the predicted class and probability
    const predictionResult = document.getElementById('predictionResult');
    let timeSlot = '';
  
    if (predictedClass + 1 === 1) {
      timeSlot = 'Morning';
    } else if (predictedClass + 1 === 2) {
      timeSlot = 'Afternoon';
    } else if (predictedClass + 1 === 3) {
      timeSlot = 'Evening';
    }
  
    predictionResult.innerHTML = `
      <p >Predicted Time Slot:<h1 style="color:blue"> ${timeSlot}</h1></p>
      <p>Probability: <h1 style="color:blue"> ${probability}</h1></p>
    `;
  }
  
  