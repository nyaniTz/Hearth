var patID = "";
var latitude = 35.2157696;
var longitude = 33.34144;
const apiKey = "671df62777b746a780050a726b5af2ea";


        // Function to get City Name
        function getCityName(lat, lng) {
        	const url = `https://api.opencagedata.com/geocode/v1/json?key=${apiKey}&q=${lat}+${lng}&pretty=1`;
        	$.get(url, function(data) {
        		if (data.results.length > 0) {
        			const city = data.results[0].components.city || data.results[0].components.town || data.results[0].components.village || data.results[0].components.county || data.results[0].components.state;
        			$(".city-name").text(city);
        		} else {
        			$(".city-name").text("City not found.");
        		}
        	});

        }  

(function ($) {
  "use strict";
  $("#search_button").click(function () {
    var searchName = $("#search_select").val();
    // console.log(searchName);

    $.ajax({
      type: "POST",
      url: "https://health.aiiot.website/dashboard/doctor/patient_data.php",
      data: { searchName: searchName },
      crossDomain: true,
      dataType: "json",
      encode: true,
    })
      .done(function (data) {
          console.log(data.patient[0])
        patID = data.patient[0]._id;
        latitude = data.patient[0].latitude;
        longitude = data.patient[0].longitude;
        sessionStorage.setItem("latitude",latitude);
        sessionStorage.setItem("longitude", longitude);
        
        $(".name").text(data.patient[0].Name);
        $(".age").text(data.patient[0].Age);
        $(".dob").text(data.patient[0].DOB);
        $(".add").text(data.patient[0].Address);
        $(".chills").text(data.patient[0].Chills);
        $(".dbp").text(data.patient[0].DBP);
        $(".sbp").text(data.patient[0].SBP);
        $(".heartrate").text(data.patient[0].HeartRate);
        $(".respiration").text(data.patient[0].RR);
        $(".spo2").text(data.patient[0].SpO2);
        $(".bloodg").text(data.patient[0].BGroup);
        $(".temp").text(data.patient[0].Temp);
        $(".ambulation").text(data.patient[0].Ambulation);
        $(".fever").text(data.patient[0].HistoryFever);
        $(".bmi").text(data.patient[0].BMI);
        $(".fio2").text(data.patient[0].FiO2);
        $(".location").text("lat: " + data.patient[0].latitude + " long: "+data.patient[0].longitude + " ");
        //$(".city-name").text("City Name: " + city);
        getCityName(latitude, longitude);
      })
      .fail(function (data) {
        console.log("failed to get patient data TO DISPLAY");
        // window.location.href = "../../login/";
      });
  });

  $.ajax({
    url: "search.php",
    type: "GET",
    success: function (response) {
      $("#search_select").append(response);
    },
  });

  $(".log_out").click(function () {
    sessionStorage.removeItem("uid");
    location.href = "../../login/";
  });
})(jQuery);




