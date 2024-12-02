<form class="pdf-report-form">
    <div class="report-form-input-container user-search-container">
        <span class="report-form-input-label">patient name</span>
        <input class="report-form-input" oninput="fetchUsers(this)" placeholder="Patient Name" type="text" required>
        <span class="release-input-lock" onclick="releaseInputThenFocus(this)"></span>
        <div class="search-list-of-users">
        </div>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">patient date of birth</span>
        <input class="report-form-input patient-dob" placeholder="Date of Birth" type="text" disabled required>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">patient gender</span>
        <input class="report-form-input patient-gender" placeholder="Gender" type="text" disabled>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">patient blood group</span>
        <input class="report-form-input patient-blood-group" placeholder="Blood Group" type="text" disabled>
    </div>

    <div class="report-form-input-container span-two">
        <span class="report-form-input-label">patient email</span>
        <input class="report-form-input patient-email" placeholder="Email" type="text" disabled>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">date of test</span>
        <input class="report-form-input patient-date-of-test" placeholder="Date of Test" type="date" required>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">blood pressure Measurement A *</span>
        <div class="half-input-container">
            <span>
                <div class="title-tag">systolic</div>
                <input class="report-form-half-input bp-systolic-a"  placeholder="Systolic" type="number" required>
            </span>
            <span>
                <div class="title-tag">diastolic</div>
                <input class="report-form-half-input bp-diastolic-a"  placeholder="Diastolic" type="number" required>
            </span>
        </div>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">blood pressure Measurement B *</span>
        <div class="half-input-container">
            <span>
                <div class="title-tag">systolic</div>
                <input class="report-form-half-input bp-systolic-b"  placeholder="Systolic" type="number" required>
            </span>
            <span>
                <div class="title-tag">diastolic</div>
                <input class="report-form-half-input bp-diastolic-b"  placeholder="Diastolic" type="number" required>
            </span>
        </div>
    </div>

    <div class="report-form-input-container">
        <span class="report-form-input-label">blood pressure Measurement C *</span>
        <div class="half-input-container">
            <span>
                <div class="title-tag">systolic</div>
                <input class="report-form-half-input bp-systolic-c"  placeholder="Systolic" type="number" required>
            </span>
            <span>
                <div class="title-tag">diastolic</div>
                <input class="report-form-half-input bp-diastolic-c"  placeholder="Diastolic" type="number" required>
            </span>
        </div>
    </div>

    <div class="report-form-input-container span-two">
        <span class="report-form-input-label">medication</span>
        <input class="report-form-input hbp-medication" placeholder="Medication" type="text" required>
    </div>

    <div class="report-form-input-container span-three">
        <span class="report-form-input-label">remarks</span>
        <input class="report-form-input doctor-remarks" placeholder="Remarks" type="text" required>
    </div>

    <div class="report-form-input-container span-one">
        <span class="report-form-input-label">Doctor Name</span>
        <input class="report-form-input doctor-name" placeholder="Doctor Name" type="text" disabled>
    </div>

    <button class="submit-button stretch-x" type="button" onclick="createReport('hbp',this)">Create Report</button>
    <div class="sk-bounce hidden-at-launch stretch-x create-report-loader">
        <div class="sk-bounce-dot"></div>
        <div class="sk-bounce-dot"></div>
    </div>
</form>