class ReportTemplate {
    
    constructor(name){
        this.reportName = name;
    }

    addField(fieldName,value){
        this[fieldName] = value;
    }

    addFromArray(array){
        array.forEach( (identifier, index) => {
            let field = { sequence: index, value: null };
            this.addField(identifier,field);

            Object.defineProperty(this, identifier ,{
                get: function() { return identifier },
                set: function(value){ identifier = value },
            });
        });
    }
}

class CovidTemplate extends ReportTemplate { 

    constructor(name){
        super(name);

        const covidTemplateFields = [
            "reportID","reportTitle","patientName", 
            "dateOfBirth", "gender", "patientEmail", "bloodGroup",
            "reasonsForTesting", "dateOfTest", "typeOfTest",
            "symptoms", "testResults", "remarks", "doctorName", "doctorEmail",
            "generatedDate", "patientID", "doctorID", 
        ];
        
        super.addFromArray(covidTemplateFields);

        this.remarks = "None";

        // Blank ???
    }

    HTML(){
    
        return `
        <div class="container">
            <span class="report-id-field">
                <span class="justify-end">Report ID: <b>${this.reportID}</b></span>
            </span>
            <h1 class="title">${this.reportTitle}</h1>
            <form>
                <img src="images/coronavirus-blue.png" class="background-image" alt="">

                <div class="inner-container">
                    <span class="inner-title">Personal Information</span>
                    <span class="field-container span-two">
                        <span class="field-title">Name of Patient</span>
                        <span class="input-field">${this.patientName}</span>
                    </span>

                    <span class="field-container">
                        <span class="field-title">Date of Birth</span>
                        <span class="input-field">${this.dateOfBirth}</span>
                    </span>

                    <span class="field-container">
                        <span class="field-title">Gender</span>
                        <span class="input-field">${this.gender}</span>
                    </span>

                    <span class="field-container span-three">
                        <span class="field-title">Email</span>
                        <span class="input-field">${this.patientEmail}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Blood Group</span>
                        <span class="input-field">${this.bloodGroup}</span>
                    </span>

                </div>

                <div class="inner-container">
                    <span class="inner-title">Test Information</span>
                    <span class="field-container span-two">
                        <span class="field-title">Reason for Testing</span>
                        <span class="input-field">${this.reasonsForTesting}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Date of Test</span>
                        <span class="input-field">${this.dateOfTest}</span>
                    </span>

                    <span class="field-container span-one">
                        <span class="field-title">Type of Test</span>
                        <span class="input-field">${this.typeOfTest}</span>
                    </span>

                    <span class="field-container span-four">
                        <span class="field-title">Symptoms</span>
                        <span class="input-field">${this.symptoms}</span>
                    </span>
                </div>

                <div class="inner-container">
                    <span class="inner-title">Result Information</span>
                    <span class="field-container span-four">
                        <span class="field-title">Results</span>
                        <div class="input-field">${this.testResults}</div>
                    </span>

                    <span class="field-container span-four">
                        <span class="field-title">Doctor Remarks and Comments</span>
                        <div class="input-field">${this.remarks}</div>
                    </span>

                    <span class="field-container span-two">
                        <span class="field-title">Doctor Name</span>
                        <span class="input-field">${this.doctorName}</span>
                    </span>

                    <span class="field-container span-two">
                        <span class="field-title">Doctor Email</span>
                        <span class="input-field">${this.doctorEmail}</span>
                    </span>
                </div>

                <span class="report-id-field" id="generated-date">
                    <span class="justify-start">Generated Date: <b>${this.generatedDate}</b></span>
                </span>
            </form>
        </div>
`
    }
}

class HBPReportTemplate extends ReportTemplate { 

    constructor(name){
        super(name);

        const HBPTemplateFields = [
            "reportID","reportTitle","patientName", 
            "dateOfBirth", "gender", "patientEmail",
            "bloodGroup", "BPMeasurementA", "BPMeasurementB",
            "BPMeasurementC", "medication", "remarks", "doctorName", 
            "doctorEmail", "generatedDate", "patientID", "doctorID",
        ];
        
        super.addFromArray(HBPTemplateFields);

        this.remarks = "None";
    }

    HTML(){
    
        return `
        <div class="container" id="container">
        <span class="report-id-field">
            <span class="justify-end">Report ID: <b>${this.reportID}</b></span>
        </span>
        <h1 class="title">${this.reportTitle}</h1>
        <form action="">
            <img src="images/blood-pressure-blue.png" class="background-image" alt="">

            <div class="inner-container">
                <span class="inner-title">Personal Information</span>
                <span class="field-container span-two">
                    <span class="field-title">Name of Patient</span>
                    <span class="input-field">${this.patientName}</span>
                </span>

                <span class="field-container">
                    <span class="field-title">Date of Birth</span>
                    <span class="input-field">${this.dateOfBirth}</span>
                </span>

                <span class="field-container">
                    <span class="field-title">Gender</span>
                    <span class="input-field">${this.gender}</span>
                </span>

                <span class="field-container span-three">
                    <span class="field-title">Email</span>
                    <span class="input-field">${this.patientEmail}</span>
                </span>

                <span class="field-container span-one">
                    <span class="field-title">Blood Group</span>
                    <span class="input-field">${this.bloodGroup}</span>
                </span>
            </div>

            <div class="inner-container">
                <span class="inner-title">Result Information</span>

                <div class="inner-container span-two alone">
                   <span class="field-container">
                        <span class="field-title inner-title">Blood Pressure Measurement A</span>
                        <span class="input-field">${this.BPMeasurementA}</span>
                    </span> 
                </div>

                <div class="inner-container span-two alone">
                    <span class="field-container">
                         <span class="field-title inner-title">Blood Pressure Measurement B</span>
                         <span class="input-field">${this.BPMeasurementB}</span>
                     </span> 
                 </div>

                <div class="inner-container span-two alone">
                    <span class="field-container alone">
                         <span class="field-title inner-title">Blood Pressure Measurement C</span>
                         <span class="input-field">${this.BPMeasurementC}</span>
                     </span> 
                </div>

                <span class="field-container span-four">
                    <span class="field-title">Medication</span>
                    <div class="input-field">${this.medication}</div>
                </span>

                <span class="field-container span-four">
                    <span class="field-title">Doctor Remarks and Comments</span>
                    <div class="input-field">${this.remarks}</div>
                </span>

                <span class="field-container span-two">
                    <span class="field-title">Doctor Name</span>
                    <span class="input-field">${this.doctorName}</span>
                </span>

                <span class="field-container span-two">
                    <span class="field-title">Doctor Email</span>
                    <span class="input-field">${this.doctorEmail}</span>
                </span>
            </div>

            <span class="report-id-field" id="generated-date">
                <span class="justify-start">Generated Date: <b>${this.generatedDate}</b></span>
            </span>
        </form>
    </div>
`
    }
}

class SelfReportTemplate extends ReportTemplate { 

    constructor(name){
        super(name);

        const selfReportTemplateFields = [
            "reportID","reportTitle","patientName", 
            "dateOfBirth", "gender", "patientEmail",
            "patientContact","bloodGroup",
            "temperature", "heartRate", "SBP",
            "DBP", "generatedTime", "generatedDate", "doctorEmail",
            "doctorID"
        ]; 
        
        super.addFromArray(selfReportTemplateFields);
    }

    HTML(){
    
        return `
        <div class="container container-self">
            <span class="report-id-field">
                <span class="justify-end">Report ID: <b>${this.reportID}</b></span>
            </span>
            <h1 class="title">${this.reportTitle}</h1>
            <div class="form-wrapper">
                <form class="form-self">
                    <img src="images/health-shield.png" class="background-image" alt="">
        
                    <div class="inner-container">
                        <span class="inner-title">Personal Information</span>
                        <span class="field-container span-two">
                            <span class="field-title">Name of Patient</span>
                            <span class="input-field">${this.patientName}</span>
                        </span>
        
                        <span class="field-container">
                            <span class="field-title">Date of Birth</span>
                            <span class="input-field">${this.dateOfBirth}</span>
                        </span>
        
                        <span class="field-container">
                            <span class="field-title">Gender</span>
                            <span class="input-field">${this.gender}</span>
                        </span>
        
                        <span class="field-container span-two">
                            <span class="field-title">Email</span>
                            <span class="input-field">${this.patientEmail}</span>
                        </span>
        
                        <span class="field-container span-two">
                            <span class="field-title">Phone Contact</span>
                            <span class="input-field">${this.patientContact}</span>
                        </span>
                    </div>
        
                    <div class="inner-container flat-grid">
                        <span class="inner-title">Health Vitals</span>
                        <span class="field-container span-one">
                            <span class="field-title">Current Temperature</span>
                            <span class="input-field">${this.temperature}</span>
                        </span>
        
                        <span class="field-container span-one">
                            <span class="field-title">Blood Group</span>
                            <span class="input-field">${this.bloodGroup}</span>
                        </span>
        
                        <span class="field-container span-one">
                            <span class="field-title">Heart Rate</span>
                            <span class="input-field">${this.heartRate}</span>
                        </span>
        
                        <span class="field-container span-one">
                            <span class="field-title">SBP</span>
                            <span class="input-field">${this.SBP}</span>
                        </span>
        
                        <span class="field-container span-one">
                            <span class="field-title">DBP</span>
                            <span class="input-field">${this.DBP}</span>
                        </span>
                    </div>
        
                    <span class="report-id-field twin-right" id="generated-date">
                        <span>Generated Time: <b>${this.generatedTime}</b></span>
                        <span>Generated Date: <b>${this.generatedDate}</b></span>
                    </span>
                </form>
            </div>
        </div>
    `
    }
}

export { CovidTemplate, HBPReportTemplate, SelfReportTemplate };