var patID="";

$(document).ready(function(){
// (function ($) {
//     "use strict";

    
    var user = sessionStorage.getItem('user');
    var token = sessionStorage.getItem('token');
    let formData = {
            user: user,
            token: token,
          };


        function checkHealthStatus(temperature, spo2, heartrate) {
  // Define the normal ranges for temperature, spo2, and heartrate
  const temperatureRange = [35.0, 37.5];
  const spo2Range = [90, 100];
  const heartrateRange = [60, 100];

  // Function to check if a value falls within a range
  function isWithinRange(value, range) {
    return value >= range[0] && value <= range[1];
  }

  // Check if temperature, spo2, and heartrate are within their respective normal ranges
  const isTemperatureHealthy = isWithinRange(temperature, temperatureRange);
  const isSpo2Healthy = isWithinRange(spo2, spo2Range);
  const isHeartrateHealthy = isWithinRange(heartrate, heartrateRange);

  // Determine the overall health status and confidence score
  let confidenceScore = 0;
  if (isTemperatureHealthy) {
    confidenceScore += 1;
  }
  if (isSpo2Healthy) {
    confidenceScore += 1;
  }
  if (isHeartrateHealthy) {
    confidenceScore += 1;
  }
  const confidenceLevel = confidenceScore / 3 * 100;
  let healthStatus = "";
  if (confidenceScore < 3) {
    healthStatus = "Unhealthy";
  } else {
    healthStatus = "Healthy";
  }

  // Return the health status and confidence level
  return {
    healthStatus: healthStatus,
    confidenceLevel: confidenceLevel
  };
}

// Example usage:
const temperature = 36.8;
const spo2 = 98;
const heartrate = 75;



setInterval(function(){    

    $.ajax({
      type: "GET",
      url: "https://health.aiiot.center/dashboard/patient/data.php",
      data: formData,
      crossDomain: true,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      patID = data.patient[0]._id;
      $('.username').text(data.patient[0].Name);
      $('.chills').text(data.patient[0].Chills);
      $('.dbp').text(data.patient[0].DBP);
      $('.sbp').text(data.patient[0].SBP);
      $('.heartrate').text(data.patient[0].HeartRate);
      $('.respiration').text(data.patient[0].RR);
      $('.spo2').text(data.patient[0].SpO2);
      $('.bloodg').text(data.patient[0].BGroup);
      $('.temp').text(data.patient[0].Temp);
      $('.ambulation').text(data.patient[0].Ambulation);
      $('.fever').text(data.patient[0].HistoryFever);
      $('.bmi').text(data.patient[0].BMI);
      $('.fio2').text(data.patient[0].FiO2);
      
const { healthStatus, confidenceLevel } = checkHealthStatus(data.patient[0].Temp, data.patient[0].SpO2, data.patient[0].HeartRate);

      $('.pred').text(healthStatus);
      $('.confi').text(confidenceLevel);
    }).fail(function (data) {
      console.log("Failed to get patient data to display");
      window.location.href = "../../login/";
    });
    
  },3000);



    
    
    $(".log_out").click(function(){
      sessionStorage.removeItem('uid');
      location.href = "../../login/"
    });


    $.ajax({
      type: "GET",
      url: "https://health.aiiot.center/dashboard/patient/geo_locate.php"+user,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      
      $.ajax({
        type: "GET",
        url: "https://api.ipgeolocation.io/ipgeo?apiKey=" + data.geo_api,
        dataType: "json",
        encode: true,
      }).done(function (data) {
        console.log(data.city);
        sessionStorage.setItem('geo_loc',data.city);
        
      }).fail(function (data) {
        console.log("api failed");
      });
      
    }).fail(function (data) {
      console.log("geo server failed");
    });

    
    
      var map_link = "https://maps.google.com/maps?q=hospitals%20in%20"+sessionStorage.getItem('geo_loc')+"&t=&z=10&ie=UTF8&iwloc=&output=embed";
      $('#hospital-map').attr('src', map_link);

      let min_meet_time = new Date().toJSON().slice(0, 16);
      
      $('#meeting-time').attr('min', min_meet_time);

      function updatePatient(){

        let url = "https://health.aiiot.center/dashboard/patient/update.php/" + patID;

        let formData = 
        {
          "patientData":{
              "SBP":	$('.sbp.number').text(),
              "DBP":  $('.dbp.number').text(),
              "HeartRate": $('.heartrate.number').text(),
              "RR": $('.respiration.number').text(),
              "SpO2": $('.spo2.number').text(),
              "Temp": $('.temp.number').text(),
              "FiO2": $('.fio2.number').text()
          }
        };

        

        $.ajax({
          type: "PUT",
          url: url,
          data : JSON.stringify(formData),
          crossDomain: true,
          dataType: "json",
          encode: true,
          headers: {
            "Content-Type": "application/json"
          },
          processData: false,
        }).done(function (data) {
          console.log("Updated");
          
        }).fail(function (data) {
          console.log("update failed");
          
        });

      }


      //setInterval(updatePatient, 60000*10); //every 10 mins

// })(jQuery);

});

