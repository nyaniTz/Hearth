(function ($) {
    "use strict";

    var user = sessionStorage.user; //getItem('user');
    var token = sessionStorage.token; //getItem('token');
    let formData = {
            user: user,
            token: token,
          };
    console.log(formData);

setInterval(function(){    
    $.ajax({
        type: "GET",
        url: "https://health.aiiot.center/dashboard/patient/data.php",
        data : formData,
        crossDomain: true,
        dataType: "json",
        encode: true,
      }).done(function (data) {
        //console.log(data.patient[0]._id);
        if (data.message == "Token does not match. Try to Login Again."){
	console.log('token mismatch');
          window.location.href="../../login/";
        }
	console.log('LOGIN PROCESS SUCCESSFUL');
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
      }).fail(function (data) {
        console.log("LOGIN PROCESS FAILED");
        window.location.href="../../login/";
      });
},3000);

})(jQuery);
