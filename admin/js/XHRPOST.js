function XHRPOST(PHPFilePath, POSTParameters){
    let xhr = new XMLHttpRequest();

    xhr.open("POST", PHPFilePath , true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        if( this.status == 200 ) console.log(this.responseText);
    }
    xhr.send(POSTParameters);
}

let addNewDoctor = document.querySelector('.submit-doctor');

addNewDoctor.addEventListener('click', (e) => {
    e.preventDefault();

    let firstname = document.querySelector(".doctor-firstname").value;
    let lastname = document.querySelector(".doctor-lastname").value;
    let age = document.querySelector(".doctor-age").value;
    let license = document.querySelector(".doctor-license").value;
    let phone = document.querySelector(".doctor-phone").value;
    let gender = document.querySelector(".doctor-gender").value;
    let address = document.querySelector(".doctor-address").value;

    let params = `firstname=${firstname}&lastname=${lastname}&age=${age}&license=${license}&phone=${phone}&gender=${gender}&address=${address}`;

    XHRPOST("./post/add_doctor.php", params);

    closePopup();
});

