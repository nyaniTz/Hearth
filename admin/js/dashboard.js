let overlay = document.querySelector(".overlay");
let addPatientPopup = document.querySelector("#add-patient-popup");
let addPatientButton = document.querySelector(".add-patient-button");

let addDoctorPopup = document.querySelector("#add-doctor-popup");
let addDoctorButton = document.querySelector(".add-doctor-button");

let addStaffPopup = document.querySelector("#add-staff-popup");
let addStaffButton = document.querySelector(".add-staff-button");

let addDevicePopup = document.querySelector("#add-device-popup");
let addDeviceButton = document.querySelector(".add-device-button");

closePopup();

function closePopup() {
  overlay.style.display = "none";
  addPatientPopup.style.display = "none";
  addDoctorPopup.style.display = "none";
  addStaffPopup.style.display = "none";
  addDevicePopup.style.display = "none";
}

addPatientButton.addEventListener('click', () => {
  overlay.style.display = "grid";
  addPatientPopup.style.display = "grid";
})

addDoctorButton.addEventListener('click', () => {
  overlay.style.display = "grid";
  addDoctorPopup.style.display = "grid";
})

addStaffButton.addEventListener('click', () => {
  overlay.style.display = "grid";
  addStaffPopup.style.display = "grid";
})

addDeviceButton.addEventListener('click', () => {
  overlay.style.display = "grid";
  addDevicePopup.style.display = "grid";
})