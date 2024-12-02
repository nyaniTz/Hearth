

function setCookie(uid,value,exp_days) {
    let d = new Date();
    d.setTime(d.getTime() + (exp_days*24*60*60*1000));
    let expires = "expires=" + d.toGMTString();
    let user = $("#User").val();
    document.cookies = user + "=" + value + ";" + expires + ";path=/";
}


function getCurrentLocation() {
  return new Promise((resolve, reject) => {
    // Check if browser supports Geolocation API
    if (!navigator.geolocation) {
      reject(new Error("Geolocation is not supported by your browser"));
    }

    // Fetch current position
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        resolve({ latitude, longitude });
      },
      () => {
        reject(new Error("Unable to retrieve your location"));
      }
    );
  });
}



(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })
  
   
    /*=============== [ Validate ]  ===============*/
    let input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(event){
        
        $(".loader").css("visibility", "visible");
        
        let check = true;

        for(let i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }


        var latit = 1001;
        var longit = 1002;
        
        getCurrentLocation()
          .then((coords) => {
            // Do something with the coordinates
            latit =  coords.latitude;
            longit =  coords.longitude;
            console.log("Latitude:", coords.latitude);
            console.log("Longitude:", coords.longitude);
          })
          .catch((err) => {
            // Handle error
            console.error(err.message);
          });




        let formData = {
            user: $("#User").val(),
            pass: $("#pass").val(),
            lat: latit,
            lng: longit,
          };

        $.ajax({
            type: "GET",
            url: "https://health.aiiot.center/login/login.php",
            crossDomain: true,
            data: formData,
            dataType: "json",
            encode: true,
          }).done(function (data) {
            sessionStorage.setItem('user', $("#User").val());
            sessionStorage.setItem('token', data.token);
            sessionStorage.setItem('displayName',data.displayName);
            console.log("The token returned is: ", data.token);
        
            if (data.status === "patient") {
                location.href = "../dashboard/patient/";
            } else if (data.status === "doctor") {
                location.href = "../dashboard/doctor/";
            } else if (data.status === "admin") {
                location.href = "../dashboard/admin/";
            }else {
                console.log("Unknown user status: ", data.status);
            }
        }).fail(function (data) {
            for(let i=0; i<input.length; i++) {
                showValidate(input[i]);
                check=false;

            }
          });
      
          event.preventDefault();

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if((!$(input).attr('type') == 'text') || (!$(input).attr('name') == 'password')) {
            return true;
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        let thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
        $(".alert-v").addClass('alert-validate-s');
        $(".loader").css("visibility", "hidden");
    }

    function hideValidate(input) {
        let thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
        $(".alert-v").removeClass('alert-validate-s');
    }
    
    /*==================================================================
    [ Show pass ]*/
    let showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).find('i').removeClass('zmdi-eye');
            $(this).find('i').addClass('zmdi-eye-off');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).find('i').addClass('zmdi-eye');
            $(this).find('i').removeClass('zmdi-eye-off');
            showPass = 0;
        }
        
    });


})(jQuery);
