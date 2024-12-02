import { unformattedDate } from "UtilFunctions";

async function fetchReportDetails(reportID){

    return new Promise((resolve,reject) => {
        let params = `report_id=${reportID}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report-details.fetch.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let reportDetails = JSON.parse(this.responseText);

                let details = reportDetails[0];

                if(details == "") reject("Report Does Not Exist");
                else { resolve(details) }
            }
            else{
                reject("Error Fetching User Details");
            }
        }

        xhr.send(params);

    });
}

async function fetchReports(field_name,field_value,status) { 
    return new Promise((resolve,reject) => {
        
        if(field_name && field_value && status){
            let params = `field_name=${field_name}&&field_value=${field_value}&&status=${status}`;
            let xhr = new XMLHttpRequest();

            xhr.open("POST", "include/reports.fetch.php", true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function(){
                let reports;
                if( this.status == 200 ){
                    reports = JSON.parse(this.responseText);
                    if(reports) resolve(reports);
                }
                else reject("Error Fetching Users");
            } 
            xhr.send(params);
        }
    });

}

function sendMetadataToDatabase( template, filename, status="doctor"){

    return new Promise((resolve, reject) => {

        let reportTitle = template.reportTitle.split(" ").join("-");
     
        let params = `report_id=${template.reportID}&&`+
        `patient_id=${template.patientID}&&`+
        `doctor_id=${template.doctorID}&&`+
        `filename=${filename}&&`+
        `patient_name=${template.patientName}&&`+
        `report_type=${reportTitle}&&`+
        `doctor_email=${template.doctorEmail}&&`+
        `status=${status}&&`+
        `created_date=${unformattedDate()}`;

        let xhr = new XMLHttpRequest();
        
        xhr.open("POST", "include/add-report.post.php", true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let message = this.responseText;

                if(message == "success") resolve();
                else reject();
            }
            else{
                reject();
            }
        }

        xhr.send(params);
    });
}

function fetchUser(id) {

    return new Promise((resolve,reject) => {

        let params = `id=${id}`;
        let xhr = new XMLHttpRequest();
        
        xhr.open("POST", "include/patient-details.fetch.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){
                let userDetails = JSON.parse(this.responseText);

                if(userDetails.length == 0) 
                    throw new Error('userDetails Came Empty');
                else 
                    resolve(userDetails[0]);
            }
            else{
                reject("Error Fetching User Details");
            }
        }

        xhr.send(params);
    });

}

function deleteReportMetaData(reportID){

    let deletePromise = new Promise((resolve,reject) => {
        let params = `report_id=${reportID}`;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "include/report-metadata.delete.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            if( this.status == 200 ){

                let deleteDetails = this.responseText;
                if(deleteDetails == "record deleted") resolve();
                else { reject(deleteDetails) };
            }
            else{
                reject("Error Deleting Report");
            }
        }

        xhr.send(params);
    });

    return deletePromise;
}

export {    fetchReportDetails, fetchReports, 
            sendMetadataToDatabase, fetchUser, 
            deleteReportMetaData
};