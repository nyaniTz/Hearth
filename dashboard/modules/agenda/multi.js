/**
 * Define a function to navigate betweens form steps.
 * It accepts one parameter. That is - step number.
 */
var appUserName;
var appUserEmail;
var appUserPhone;
var appService;
var appDoctor;
var appDate;
var appTime;

$(document).ready(function() {
    // Fetch services from the database and populate the service dropdown
    console.log("READY");
    $.ajax({
        type: "POST",
        url: "getdata.php",
        data: {
            'action': 'fetch_services'
        },
        success: function(services) {
            $('#service').html(services);
            console.log(services);
        }
    });

    // Fetch doctors based on selected service and populate the doctor dropdown
    $('#service').on('change', function() {
        var service_id = $(this).val();
        appService = service_id;
        console.log("Appointment SERVICE ID IS:  " + appService)

        if (service_id) {
            $.ajax({
                type: "POST",
                async: false,
                url: "getdata.php",
                data: {
                    action: 'fetch_doctors',
                    service_id: service_id
                },
                success: function(doctors) {
                    $('#doctor').html(doctors);
                }
            });
        } else {
            $('#doctor').html('<option value="">-- Select a Doctor --</option>');
        }
    });

    $('#doctor').on('change', function() {
        appDoctor = $(this).val();
        console.log("Appointment Doctor booked is: " + appDoctor);
    });





});

const navigateToFormStep = (stepNumber) => {
    /**
     * Hide all form steps.
     */
    document.querySelectorAll(".form-step").forEach((formStepElement) => {
        formStepElement.classList.add("d-none");
    });
    /**
     * Mark all form steps as unfinished.
     */
    document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
        formStepHeader.classList.add("form-stepper-unfinished");
        formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
    });
    /**
     * Show the current form step (as passed to the function).
     */
    document.querySelector("#step-" + stepNumber).classList.remove("d-none");
    /**
     * Select the form step circle (progress bar).
     */
    const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
    /**
     * Mark the current form step as active.
     */
    formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
    formStepCircle.classList.add("form-stepper-active");
    /**
     * Loop through each form step circles.
     * This loop will continue up to the current step number.
     * Example: If the current step is 3,
     * then the loop will perform operations for step 1 and 2.
     */
    for (let index = 0; index < stepNumber; index++) {
        /**
         * Select the form step circle (progress bar).
         */
        const formStepCircle = document.querySelector('li[step="' + index + '"]');
        /**
         * Check if the element exist. If yes, then proceed.
         */
        if (formStepCircle) {
            /**
             * Mark the form step as completed.
             */
            formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
            formStepCircle.classList.add("form-stepper-completed");
        }
    }
};
/**
 * Select all form navigation buttons, and loop through them.
 */
document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
    /**
     * Add a click event listener to the button.
     */
    formNavigationBtn.addEventListener("click", () => {
        /**
         * Get the value of the step.
         */
        const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
        /**
         * Call the function to navigate to the target form step.
         */
        navigateToFormStep(stepNumber);
    });
});


// modal
// Get the modal
var modal = document.getElementById("my-modal");

// Get the button that opens the modal
var btn = document.getElementById("open-modal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


$(document).ready(function() {
    var avail = document.querySelector('.btn-availability');
    avail.disabled = true;
    // Fetch services and populate service dropdown
    // Fetch doctors based on selected service and populate doctor dropdown

    // Check availability based on selected doctor, date, and time
    $('#check-availability').on('click', function() {


        console.log("Clicked The Check");
        var doctor_id = $('#doctor').val();
        var date = $('#date').val();
        var time = $('#time').val();
        if (doctor_id && date && time) {
            $.ajax({
                type: 'POST',
                url: 'getdata.php',
                async: false,
                data: {
                    doctor_id: doctor_id,
                    date: date,
                    time: time,
                    action: 'check_schedule_conflict'
                },
                success: function(response) {
                    if (response == 'available') {
                        alert('Slot is available!');
                        appDoctor = doctor_id;
                        appDate = date;
                        appTime = time;
                        avail.disabled = false;
                    } else {
                        alert('Slot is not available. Please choose a different date or time.');
                    }
                }
            });
        } else {
            alert('Please choose a doctor, date, and time.');
        }
    });
});



$(document).ready(function() {
    // Dependent dropdown for payment method and visa card info
    $('#payment_method').on('change', function() {
        var payment_method = $(this).val();
        if (payment_method === 'visa') {
            $('#visa_card_info').show();
            $('#next_button').prop('disabled', true);
        } else {
            $('#visa_card_info').hide();
            $('#next_button').prop('disabled', false);
        }
    });

    // Payment verification for visa card
    $('#pay_button').on('click', function() {
        var card_number = $('#card_number').val();
        if (card_number.length === 16 && card_number.charAt(0) === '4') {
            alert('Payment accepted');
            $('#next_button').prop('disabled', false);
            console.log("Date is: " + appDate)
            console.log("Time is: " + appTime)
            console.log("Service" + appService)
        } else {
            alert('Invalid card number');
        }
    });
});


// Select the button using the unique class name "to-confirm"
var confirmation = document.querySelector('.to-confirm');

// Add a click event listener to the button
confirmation.addEventListener('click', function() {
    appUserName = document.getElementById('name').value;
    appUserEmail = document.getElementById('email').value;
    appUserPhone = document.getElementById('phone').value;
    appService = document.getElementById('service').value;
    appDoctor = document.getElementById('doctor').value;
    appDate = document.getElementById('date').value;
    appTime = document.getElementById('time').value;
    appPay = document.getElementById('payment_method').value;
    var appStatus = "pending"
    if (appPay === "visa") {
        appStatus = "confirmed"
    }
    // Convert the time value to a Date object
    var wtime = new Date(Date.parse("01/01/2022 " + appTime));

    // Add one hour to the Date object
    wtime.setHours(wtime.getHours() + 1);

    // Convert the updated Date object to a time string
    var endtime = wtime.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

    console.log("End time is: " + endtime);


    // Handle the click event here
    console.log('Button clicked!');
    // Get the preview elements
    var previewName = document.getElementById("preview-name");
    var previewEmail = document.getElementById("preview-email");
    var previewService = document.getElementById("preview-service");
    var previewDoctor = document.getElementById("preview-doctor");
    var previewDate = document.getElementById("preview-date");
    var previewTime = document.getElementById("preview-time");

    // Update the preview elements with the form data
    previewName.innerHTML = appUserName; //document.getElementById("name").value;
    previewEmail.innerHTML = appUserEmail; //document.getElementById("email").value;
    previewService.innerHTML = appService; //document.getElementById("service").options[document.getElementById("service").selectedIndex].text;
    previewDoctor.innerHTML = appDoctor; //document.getElementById("doctor").options[document.getElementById("doctor").selectedIndex].text;
    previewDate.innerHTML = appDate; //document.getElementById("date").value;
    previewTime.innerHTML = appTime; //document.getElementById("time").value;

    $.ajax({
        url: "getdata.php",
        type: "POST",
        data: {
            name: appUserName,
            email: appUserEmail,
            phone: appUserPhone,
            date: appDate,
            time: appTime,
            endtime: endtime,
            payment_method: "any",
            status: appStatus,
            service: appService,
            doctor: appDoctor,
            action: "save_appointment"
        },
        success: function(response) {
            console.log("AJAX request SENT");
            console.log(response); // log the response from the server
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX request failed.");
            console.log(textStatus + ": " + errorThrown);
        }
    });


});

// Select the button using the unique class name "to-confirm"
var tosave = document.querySelector('.to-save');


// Add a click event listener to the button
tosave.addEventListener('click', function() {
    appUserName = document.getElementById('name').value;
    appUserEmail = document.getElementById('email').value;
    appUserPhone = document.getElementById('phone').value;
    appService = document.getElementById('service').value;
    appDoctor = document.getElementById('doctor').value;
    appDate = document.getElementById('date').value;
    appTime = document.getElementById('time').value;
    appPay = document.getElementById('payment_method').value;
    var appStatus = "unpaid";
    if (appPay === "visa") {
        appStatus = "paid";
    }



    // Convert the time value to a Date object
    var wtime = new Date(Date.parse("01/01/2022 " + appTime));

    // Add one hour to the Date object
    wtime.setHours(wtime.getHours() + 1);

    // Convert the updated Date object to a time string
    var endtime = wtime.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });

    console.log("End time is: " + endtime);





    // // Insert data into appointments table
    // var xhttp = new XMLHttpRequest();
    // xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         console.log("Data inserted into appointments table.");
    //     }
    // };
    // xhttp.open("POST", "getdata.php", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send("name=" + appUserName + "&email=" + appUserEmail + "&phone=" + appUserPhone + "&date=" + appDate + "&time=" + appTime + "&endtime=" + endtime + "&payment_method=" + appPay + "&status=" + appStatus + "&service=" + appService + "&doctor=" + appDoctor);

    $.ajax({
        url: "getdata.php",
        type: "POST",
        data: {
            name: appUserName,
            email: appUserEmail,
            phone: appUserPhone,
            date: appDate,
            time: appTime,
            endtime: endtime,
            payment_method: "any",
            status: appStatus,
            service: appService,
            doctor: appDoctor,
            action: "save_appointment"
        },
        success: function(response) {
            console.log("AJAX request successful.");
            console.log(response); // log the response from the server
            
            

                // Send the AJAX request
                $.ajax({
                  url: '../../../api/main.php',
                  type: 'GET',
                  data: {
                      appointdate: appDate,
                      name: appUserName,
                      email: appUserEmail,
                      time: appTime,
                      doctor: appDoctor,
                  },
                  success: function(response) {
                    // Handle the success response
                    console.log('Appointment Email notification sent successfully');
                  },
                  error: function(xhr, status, error) {
                    // Handle the error response
                    console.log('Error sending appointment Email Notification: ' + error);
                  }
                });            
            
            
            window.location.href = "index.php";
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX request failed.");
            console.log(textStatus + ": " + errorThrown);
        }
    });
    window.location.href = "index.php";
});