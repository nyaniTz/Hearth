<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

    
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="js/script.js" defer></script>
    <script src="js/dashboard.js" defer></script>
    <script src="js/XHRPOST.js" defer></script>
  </head>

  <body>
    <?php include "components/sidebar.php" ?>
    
    <section class="home-section">
      <?php include "components/navigation.php" ?>
      
      <div class="home-content"> 
          <ul class="function-bar">
            <li class="function-bar-button add-patient-button">
              <i class="bx bx-plus-circle"></i>
              <p>Add Patient</p>
            </li>

            <li class="function-bar-button add-doctor-button">
              <i class="bx bx-plus-circle"></i>
              <p>Add Doctor</p>
            </li>

            <li class="function-bar-button add-staff-button">
              <i class="bx bx-plus-circle"></i>
              <p>Add Staff</p>
            </li>

            <li class="function-bar-button add-device-button">
              <i class="bx bx-plus-circle"></i>
              <p>Add Device</p>
            </li>
          </ul>

          <div class="quick-links">
            <a class="quick-link-item" href="patients.php">
              <i class="bx bx-shield"></i>
              <h2>Patients</h2>
              <div>
                <p>100</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="doctors.php">
              <i class="bx bx-user-voice"></i>
              <h2>Doctors</h2>
              <div>
                <p>50</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="staff.php">
              <i class="bx bx-user-circle"></i>
              <h2>Staff</h2>
              <div>
                <p>50</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="devices.php">
              <i class="bx bx-user-circle"></i>
              <h2>Devices</h2>
              <div>
                <p>20</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="notifications.php">
              <i class="bx bx-user-circle"></i>
              <h2>Notifications</h2>
              <div>
                <p>33</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="reports.php">
              <i class="bx bx-user-circle"></i>
              <h2>Reports</h2>
              <div>
                <p>220</p>
                <p>on record</p>
              </div>
            </a>

            <a class="quick-link-item" href="settings.php">
              <i class="bx bx-cog"></i>
              <h2>Settings</h2>
              <div>
                <p>Edit</p>
                <p>Settings</p>
              </div>
            </a>
          </div>
        
      </div>
    </section>

    <div class="overlay">
      <form class="popup" id="add-patient-popup">
        <h1>Add Patient</h1>
        <p class="note">All marked * are mandatory</p>
        <div class="form-input-container">
          <input type="text" class="patient-firstname" placeholder="First Name *" required>
          <input type="text" class="patient-lastname" placeholder="Last Name *" required>
          <input type="number" class="patient-age" placeholder="Age *" required>
          <input type="text" class="patient-insurance" placeholder="Health Insurance Number">
          <input type="text" class="patient-phone" placeholder="Phone Number">
          <select name="gender-select" class="patient-gender" id="gender-select">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <input type="text" class="patient-address" placeholder="Address">
        </div>

        <div class="button-container">
          <button type="button" class="cancel close-popup" onclick="closePopup()">Cancel</button>
          <button class="submit">Add Patient</button>
        </div>
      </form>

      <form class="popup" id="add-doctor-popup">
        <h1>Add Doctor</h1>
        <p class="note">All marked * are mandatory</p>
        <div class="form-input-container">
          <input type="text" class="doctor-firstname" placeholder="First Name *" required>
          <input type="text" class="doctor-lastname" placeholder="Last Name *" required>
          <input type="number" class="doctor-age" placeholder="Age *" required>
          <input type="text" class="doctor-license" placeholder="Doctor License Number">
          <input type="text" class="doctor-phone" placeholder="Phone Number">
          <select class="doctor-gender" id="gender-select">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <input type="text" class="doctor-address" placeholder="Address">
        </div>

        <div class="button-container">
          <button type="button" class="cancel close-popup" onclick="closePopup()">Cancel</button>
          <button class="submit-doctor" type="button">Add Doctor</button>
        </div>
      </form>

      <form class="popup" id="add-staff-popup">
        <h1>Add Staff</h1>
        <p class="note">All marked * are mandatory</p>
        <div class="form-input-container">
          <input type="text" class="staff-firstname"placeholder="First Name *" required>
          <input type="text" class="staff-lastname"placeholder="Last Name *" required>
          <input type="number" class="staff-age"placeholder="Age *" required>
          <input type="text" class="staff-id"placeholder="Work ID">
          <input type="text" class="staff-phone"placeholder="Phone Number">
          <select name="gender-select" class="staff-gender"id="gender-select">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <input type="text" class="staff-department"placeholder="Department">
          <input type="text" class="staff-address"placeholder="Address">
          <input type="text" class="staff-work-description"placeholder="Work Description">
        </div>

        <div class="button-container">
          <button type="button" class="cancel close-popup" onclick="closePopup()">Cancel</button>
          <button class="submit">Add Staff</button>
        </div>
      </form>

      <form class="popup" id="add-device-popup">
          <h1>Add Device</h1>
          <p class="note">All marked * are mandatory</p>
          <div class="form-input-container">
            <input type="text" class="device-id" placeholder="Device ID" required>
            <input type="text" class="device-url" placeholder="URL" required>
            <input type="number" class="device-port" placeholder="port" required>
            <input type="text" class="device-patient" placeholder="Patient">
            <input type="text" class="device-assigned-doctor" placeholder="Assigned Doctor">
          </div>

        <div class="button-container">
          <button type="button" class="cancel close-popup" onclick="closePopup()">Cancel</button>
          <button class="submit">Add Device</button>
        </div>
      </form>

    </div>
  </body>

</html>
