// Function to toggle fields based on report type
function toggleFields() {
    var reportType = document.getElementById("report_type").value;
    var tableNameDiv = document.getElementById("table_name_div");
    var patientNameDiv = document.getElementById("patient_name_div");
    var dateRangeDiv = document.getElementById("date_range_div");

    if (reportType == "list") {
        tableNameDiv.style.display = "block";
        patientNameDiv.style.display = "none";
        dateRangeDiv.style.display = "none";
    } else if (reportType == "individual") {
        tableNameDiv.style.display = "none";
        patientNameDiv.style.display = "block";
        dateRangeDiv.style.display = "block";
    }
}

// Add event listener to call toggleFields() when the page loads
window.addEventListener("load", toggleFields);