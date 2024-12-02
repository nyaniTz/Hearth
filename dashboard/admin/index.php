<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js"
      type="text/javascript"
    ></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <title>Doctor Dashboard</title>

    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="../../assets/favicon/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="../../assets/favicon/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="../../assets/favicon/favicon-16x16.png"
    />
    <link rel="manifest" href="../../assets/favicon/site.webmanifest" />

    <link rel="stylesheet" href="css/main.css" />
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    
    <link rel="stylesheet" href="path/to/bootstrap/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="path/to/font-awesome/css/font-awesome.min.css"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.7);
}

/* Modal Header */
.modal-header {
  padding: 10px;
  background-color: #333;
  color: #fff;
}

/* Close Button */
.close {
  float: right;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: #fff;
  text-decoration: none;
  cursor: pointer;
}

/* Modal Body */
.modal-body {
  padding: 20px;
}

/* Google Map */
#map {
  height: 400px;
  width: 100%;
}

/* Box */
.box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 10px 0;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

/* Font Awesome Icon */
.cart {
  font-size: 30px;
  color: #333;
  cursor: pointer;
}

.select {
    position: relative;
    z-index: 9999; /* Adjust the z-index value as needed */
  }
  .select iframe {
    display: block;
    width: 100%; /* Set the initial width to 100% */
    height: 100%;
    border: none;
    overflow-x: none; /* Hide horizontal scroll */
    overflow-x: none; /* Hide horizontal scroll */
  }




/* Custom select styles */
.custom-select {
  position: relative;
}

.custom-select select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
  cursor: pointer;
}

.custom-select::after {
  content: '\25BC';
  position: absolute;
  top: 50%;
 left: 10%;
  transform: translateY(-50%);
  pointer-events: none;
}

/* Optional styles to enhance the visual appearance */
.custom-select select:focus {
  outline: none;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
}







    </style>
  </head>

  <body>
    <div class="container" id="blur">
      <div class="sidebar">
        <div class="logo-details"></div>
        <ul class="nav-links">
            
            
          <li class="dash content active">
              <i class="bx bx-grid-alt"></i>
              <span class="links_name">Dashboard</span>
            </a>
          </li>
          
          
          <li class="home content" style="display: none;">
              <i class="bx bx-home-alt"></i>
              <span class="links_name">Home</span>
            </a>
          </li>
          
          
          <li class="patient content" style="display: none;">
              <i class="fas fa-person" aria-hidden="true"></i>
              <span class="links_name">Patients</span>
            </a>
          </li>
          
          
          <li class="schedule content" style="display: none;">
              <i class="bx bx-time"></i>
              <span class="links_name">Schedule</span>
            </a>
          </li>


          <li class="reports content" style="display: none;">
              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
              <span class="links_name">Reports</span>
            </a>
          </li>
          
          
          <li class="camera content" style="display: none;">
              <i class="fa fa-camera"></i>
              <span class="links_name">Camera</span>
            </a>
          </li>
          


          <li class="appointments content">
            <i class="fa fa-columns" aria-hidden="true"></i>
            <span class="links_name">Appointments</span>
          </a>
        </li>




          
          <li class="log_out">
              <i class="bx bx-log-out"></i>
              <span class="links_name">Log out</span>
            </a>
          </li>
          
        </ul>
      </div>
      <section class="home-section">
        <nav>
          <div class="sidebar-button">
            <i class="bx bx-menu sidebarBtn"></i>
            <span class="dashboard">Dashboard</span>
          </div>
          <div class="logo">
            <img
              src="../../assets/img/logo%20blue%20bg.PNG?raw=true"
              class="logo"
              alt="logo-blue-bg"
              style="width: 50%; height: auto; margin: 15px"
              border="0"
            />
          </div>
          <div class="search-box">
            <input type="text" placeholder="Search..." />
            <i class="bx bx-search"></i>
          </div>
          <div class="profile-details">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png"
            alt="DP" />
            <span class="admin_name"><!--Dr Smith Wright --></span>
            <i class="bx bx-chevron-up"></i>
          
            <div class="section-dropdown">
                <a class="sd-list" href="../account/">Account</a>
                <a class="sd-list" href="../documentation/">Documentation</a>
                <a class="sd-list" href="../premium/">Premium</a>
                <a class="sd-list" href="../preference/">Preference</a>
            </div>
          </div>
        </nav>

<br><br>
<br>
<br><br>
<br>

<div class="select" style="margin-top:-4%;margin-left:2%;">
  <?php
    // index.php code

    include("../../includes/conn.php");

    $query = "SELECT * FROM appointments WHERE appointment_status = 'confirmed' ORDER BY doctor_id ASC";
    $result = $conn->query($query);
  ?>


<div class="container">
  <h1 class="mt-2 mb-3 text-center text-primary"></h1>
  <div class="row">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-6">
      <div class="custom-select">
        <select name="select_box" class="select2" id="select_box" onchange="getTotalPatients(this.value)">
          <option value="">Doctors</option>
          <?php 
            foreach($result as $row) {
              echo '<option value="'.$row["doctor_id"].'">'.$row["doctor_id"].'</option>';
            }
          ?>  
        </select>
      </div>
    </div>
  </div>

</div>






</div>

<script>
  var select_box_element = document.querySelector('#select_box');

  dselect(select_box_element, {
    search: true
  });
</script>



<br><br><br />
  <br /><br />
  <br />
<br>
        <div class="box-content main dashboard active">

          <div class="overview-boxes" >
            
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Total Patients</div>
                
                <?php
// Assuming you have a database connection established
include("../../includes/conn.php");


$query= "SELECT COUNT(*) AS appointment_status FROM appointments WHERE appointment_status = 'confirmed' ";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows  = $row['appointment_status'];


// Echo the HTML code with the dynamic total number
echo '<div class="number1">' . $totalRows . '</div>';
?>



    <div class="box-topic" style="">Total Today</div>


    <?php
// Assuming you have a database connection established




// Query to retrieve the total appointments for the selected doctor (today)
$currentDate = date("Y-m-d");
$query = "SELECT COUNT(*) AS appointment_status FROM appointments WHERE appointment_status = 'confirmed'  AND DATE(created_at) = '$currentDate'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows  = $row['appointment_status'];


// Echo the HTML code with the dynamic total number
echo '<div class="number2">' . $totalRows . '</div>';
?>

    



    <script>
function getTotalPatients(doctorName) {
  // Send an AJAX request to fetch the total appointments data for the selected doctor
  $.ajax({
    url: 'getTotalPatients.php',
    type: 'POST',
    data: { doctorName: doctorName },
    success: function(response) {
      // Parse the JSON response
      var totalAppointments = JSON.parse(response);

      // Update the total appointments (all-time) count on the page with the fetched data
      $('.number1').text(totalAppointments.allTime);

      // Update the total appointments for today count on the page with the fetched data
      $('.number2').text(totalAppointments.today);
      $('.number3').text('Confirmed ' + totalAppointments.today);
      
      $('.pending').text('Pending ' + totalAppointments.todaypending);
      
     
      $('.number4').text('Today ' + totalAppointments.service_count);

      $('.number4all').text('All ' + totalAppointments.service_countAllTime);
      
    }
  });
}

</script>
























                <div class="indicator">
                  <i class="bx bx-up-arrow-alt"></i>
                  <span class="text">Up from yesterday</span>
                </div>
              </div>
              
         <i class="fas fa-person cart two" aria-hidden="true" onclick="document.getElementById('id01').style.display='block'"></i>
            
            

<!-- total patient -->

            <?php
// Assuming you have a database connection established

// Query to retrieve today's appointments
$query = "SELECT * FROM appointments WHERE DATE(appointment_date) = CURDATE()";
$result = mysqli_query($conn, $query);
$totalAppointments = mysqli_num_rows($result);

// Fetch the appointment data
$appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
            <!-- total patient  -->
            <div id="id01" class="w3-modal">
    <div class="w3-modal-content" style="margin-left:21%;">
      <div class="w3-container">
        <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <?php
      if ($totalAppointments > 0) {
        foreach ($appointments as $appointment) {
            echo '<br/>';
             echo '<p>Doctor ID: ' . $appointment['doctor_id'] . '</p>';
             echo '<br/>';
          echo '<p>Appointment Date: ' . $appointment['appointment_date'] . '</p>';
           echo '<br/>';
           
           
          echo '<p>Appointment Date: ' . $appointment['appointment_time'] . '</p>';
           echo '<br/>';
           
          // Add more appointment details as needed
        }
      } else {
          echo '<br/>';
        echo '<p>No appointments found for today.</p>';
        echo '<br/>';
      }
      ?>
      </div>
    </div>
  </div>
</div>
            
            
            
            
            
            
            
            <div class="box">
              <div class="right-side">
                <div class="box-topic" style="">Appointments </div>
                <div class="box-topic" style="font-size:14px;">Today</div>

                <?php
// Assuming you have a database connection established




// Query to retrieve the total appointments for the selected doctor (today)
$currentDate = date("Y-m-d");
$query = "SELECT COUNT(*) AS appointment_status FROM appointments WHERE appointment_status = 'confirmed'  AND DATE(created_at) = '$currentDate'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows  = $row['appointment_status'];


// Echo the HTML code with the dynamic total number
echo '<div class="number3">'.' Confirmed '  . $totalRows . '</div>';
?>


         
<?php
// Assuming you have a database connection established




// Query to retrieve the total appointments for the selected doctor (today)
$currentDate = date("Y-m-d");
$query = "SELECT COUNT(*) AS appointment_status FROM appointments WHERE appointment_status = 'confirmed'  AND DATE(created_at) = '$currentDate'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows  = $row['appointment_status'];


// Echo the HTML code with the dynamic total number
echo '<div class="pending">' . ' Pending ' . $totalRows . '</div>';

?>
                

                
                <div class="indicator">
                  <i class="bx bx-up-arrow-alt"></i>
                  <span class="text">For Today</span>
                </div>
              </div>
              <i class="fas fa-calendar cart" aria-hidden="true"></i>
            </div>


            <div class="box">
              <div class="right-side">
                <div class="box-topic">Services</div>
                <?php
// Assuming you have a database connection established
include("../../includes/conn.php");
// Query to retrieve the total number of rows
$query = "SELECT COUNT(*) AS name FROM services";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows = $row['name'];

// Echo the HTML code with the dynamic total number
echo '<div class="number4">' . $totalRows . '</div>';
?>
<div class="number4all"> </div>

                <div class="indicator">
                  <i class="bx bx-up-arrow-alt"></i>
                  <span class="text">Up from yesterday</span>
                </div>
              </div>
              <i class="fas fa-user-tie cart three" aria-hidden="true"></i>
            </div>
        
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Total Services</div>
                <?php
// Assuming you have a database connection established
include("../../includes/conn.php");
// Query to retrieve the total number of rows
$query = "SELECT COUNT(*) AS TotalRows FROM services";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalRows = $row['TotalRows'];

// Echo the HTML code with the dynamic total number
echo '<div class="number5">' . $totalRows . '</div>';
?>








                <div class="indicator">
                  <i class="bx bx-down-arrow-alt down"></i>
                  <span class="text">Down From Today</span>
                </div>
              </div>
              <i class="fa fa-ambulance" aria-hidden="true"></i>
            </div> 
          </div>
          <div class="doc-box" style="display:none;">
            <div class="right-side">
        <!--
              <img class="doc-img" src="../../assets/img/doctors/doctors-2.jpg" alt="">
-->
              <div class="box-topic"></div>
              <p class="text"></p>
            
            </div>
            
          </div>

          


          <div class="appointment">
            
          </div>
          
        </div>
        








<div class="chart">



</div>






































        <div class="box-content home dashboard">
          <div class="sales-boxes">
            <div class="recent-sales">
              <div class="sales-details box">
                <ul class="details">
                  <li class="topic">Patients</li>
            Alex Doe</a></li>
                  <li><a href="#">David Mart</a></li>
                  <li><a href="#">Roe Parter</a></li>
                  <li><a href="#">Diana Penty</a></li>
                  <li><a href="#">Diana Penty</a></li>
                  <li><a href="#">Martin Paw</a></li>
                  <li><a href="#">Doe Alex</a></li>
                  <li><a href="#">Aiana Lexa</a></li>
                  <li><a href="#">Rexel Mags</a></li>
                </ul>
                <ul class="details">
                  <li class="topic">Age</li>
                  <li><a href="#">34</a></li>
                  <li><a href="#">24</a></li>
                  <li><a href="#">64</a></li>
                  <li><a href="#">54</a></li>
                  <li><a href="#">23</a></li>
                  <li><a href="#">54</a></li>
                  <li><a href="#">13</a></li>
                  <li><a href="#">25</a></li>
                  <li><a href="#">26</a></li>
                </ul>
                <ul class="details">
                  <li class="topic">Gender</li>
                  <li><a href="#">Male</a></li>
                  <li><a href="#">Male</a></li>
                  <li><a href="#">Male</a></li>
                  <li><a href="#">Female</a></li>
                  <li><a href="#">Female</a></li>
                  <li><a href="#">Male</a></li>
                  <li><a href="#">Male</a></li>
                  <li><a href="#">Female</a></li>
                  <li><a href="#">Male</a></li>
                </ul>
                <ul class="details">
                  <li class="topic">Diagonsed</li>
                  <li><a href="#">CBC</a></li>
                  <li><a href="#">CDX X-Ray</a></li>
                  <li><a href="#">CRPCS</a></li>
                  <li><a href="#">CBC</a></li>
                  <li><a href="#">CDX X-Ray</a></li>
                  <li><a href="#">CRPCS</a></li>
                  <li><a href="#">CBC</a></li>
                  <li><a href="#">CDX X-Ray</a></li>
                  <li><a href="#">CRPCS</a></li>
                </ul>
                <ul class="details">
                  <li class="topic">Reports</li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                  <li>
                    <a href="#"><u>View</u></a>
                  </li>
                </ul>
              </div>
              <div class="button">
                <a href="#">See All</a>
              </div>
            </div>
          </div>
          
        </div>

        <div class="box-content patient dashboard ">

          <div class="search-box">
            <select name="" id="search_select" >
              <option value="" selected disabled>--select a patient--</option>
            </select>
              <button id="search_button"><i class="bx bx-search"></i></button>
              
          </div>
          
          <div class="patient-box">
            <div class="box-topic name"></div>
            <p class="text"> Age: <span class="age"></span></p>
            <p class="text"> Date of Birth: <span class="dob"></span></p>
            <p class="text"> Address: <span class="add"></span></p>
          </div>
          <div class="overview-boxes">     
            <div class="box">
              <div class="right-side">
                <div class="box-topic">chills</div>
                <div class="number chills"></div>
                <div class="indicator">
                  <span class="text"> Safe: false</span>
                </div>
              </div>
              <i
                class="cart"
                style="font-size: 50px; font-style: initial; font-weight: bold"
                >❄</i
              >
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Diastole BP</div>
                <div class="number dbp"></div>
                <div class="indicator">
                  <span class="text">Safe [60 - 80 mm Hg]</span>
                </div>
              </div>
              <i class="fas fa-heart cart two"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Systole BP</div>
                <div class="number sbp"></div>
                <div class="indicator">
                  <span class="text">Safe [90 - 120 mm Hg]</span>
                </div>
              </div>
              <i class="fas fa-heart cart three"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">HeartRate</div>
                <div class="number heartrate"></div>
                <div class="indicator">
                  <span class="text">Safe [60 to 100 beats]</span>
                </div>
              </div>
              <i class="fas fa-heartbeat cart four"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Respiration Rate</div>
                <div class="number respiration"></div>
                <div class="indicator">
                  <span class="text">Safe [12 to 16 breaths/min]</span>
                </div>
              </div>
              <i class="fas fa-lungs cart two"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">SpO2</div>
                <div class="number spo2"></div>
                <div class="indicator">
                  <span class="text">Range [95% or higher]</span>
                </div>
              </div>
              <i class="fas fa-wind cart three"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Blood Group</div>
                <div class="number bloodg"></div>
                <div class="indicator">
                  <span class="text"></span>
                </div>
              </div>
              <i class="fas fa-droplet cart four"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Temperature</div>
                <div class="number temp"></div>
                <div class="indicator">
                  <span class="text">Range [97°F to 99°F]</span>
                </div>
              </div>
              <i class="fa-solid fa-temperature-half cart"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Ambulation</div>
                <div class="number ambulation"></div>
                <div class="indicator">
                  <span class="text">Values possible : True/False</span>
                </div>
              </div>
              <i class="fa-solid fa-face-thermometer"></i>
              <i class="fas fa-syringe cart three"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Fever History</div>
                <div class="number fever"></div>
                <div class="indicator">
                  <span class="text">Values possible : Yes/No/Other</span>
                </div>
              </div>
              <i class="fas fa-temperature-half cart four"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">BMI</div>
                <div class="number bmi"></div>
                <div class="indicator">
                  <span class="text">Range [18.5 to 24.9]</span>
                </div>
              </div>
              <i class="fas fa-balance-scale cart"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">FiO2</div>
                <div class="number fio2"></div>
                <div class="indicator">
                  <span class="text">Range [50 to 100]</span>
                </div>
              </div>
              <i class="fas fa-lungs cart two"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Emotion</div>
                <div class="number emotion"></div>
                <div class="indicator">
                  <span class="text">Values Possible:happy/neutral/sad</span>
                </div>
              </div>
              <i class="fa-sharp fa-solid fa-face-smile cart two"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Location</div>
                <div class="location"></div>
                <div class="number city-name"></div>
                <div class="indicator">
                
                  <span class="text">GPS + City</span>
                 
                </div>
              </div>
              <i class="fa-solid fa-location-dot cart two" id="open-map"></i>
            </div>
          </div>
        </div>
      
        <div class="schedule dashboard">
          <div id="calendar" class="calendar-box"></div>
        </div>

        <div class="reports dashboard">

            <iframe style="height: 100%; width: 100%; border: none;" src="https://health.aiiot.center/dashboard/modules/reports/index.php"></iframe>

        </div>


        <div class="camera dashboard">

            <iframe style="height: 100%; width: 100%; border: none;" src="https://detectron-vmercel.vercel.app/" allow="camera *; microphone *"></iframe>

        </div>

        <div class="appointments dashboard">

          <iframe style="height: 100%; width: 100%; border: none;" src="appointments.php"></iframe>

          <script>
let now = sessionStorage.setItem('user','doctor');
let user = sessionStorage.getItem('user');
console.log("hello",user);

          </script>

      </div>

<!-- Modal -->
<div id="map-modal" class="modal">
  <div class="modal-header">
    <span class="close">&times;</span>
  </div>
  <div class="modal-body">
    <div id="map"></div>
  </div>
</div>     
  
        
      </section>
      <footer >
        <div class="container-fluid bg-dark text-light py-3">
          <div class="row">
            <img
              src="../../assets/img/logo%20blue%20bg.PNG?raw=true"
              class="logo"
              alt="logo-blue-bg"
              style="width: 15%; display: block; height: auto; margin: auto"
              border="0"
            />
            <small >Copyright &copy; <span id="year"></span> AI and Robotics
              Institute, NEU</small
            >
          </div>
        </div>
      </footer>
    </div>
  <!-- <div id="popup">
    <div data-role="popup" id="popupBot" data-overlay-theme="b" data-theme="a" data-tolerance="15,15"
      class="ui-content">
      <iframe src='https://dodxtx.shinyapps.io/EMSC/' width="1000px" height="500px" sandbox=""></iframe>
    </div>
  </div> -->
      <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.ie11.min.js"></script>
      <!-- <script src="assets/js/script.js"></script> -->
      <script src="js/nav.js"></script>
      <script src="js/sidebar.js"></script>
      <script src="js/index.js"></script>
      <script src="js/calendar.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <script
        src="https://kit.fontawesome.com/1ed7106697.js"
        crossorigin="anonymous"
      ></script>
      
      <script>
        // Set the current year in the copyright notice
        const currentYear = new Date().getFullYear();
        document.getElementById("year").innerHTML = currentYear;
      </script>
      
      
<script>

// Set the latitude and longitude for the map marker
var markerLatLng = {lat: latitude, lng: longitude}; // Replace with your coordinates

// When the font awesome icon is clicked, open the modal
document.getElementById("open-map").addEventListener("click", function() {
  document.getElementById("map-modal").style.display = "block";
  
  // Load the Google Maps API
  var script = document.createElement("script");
  script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyC-dFHYjTqEVLndbN2gdvXsx09jfJHmNc8";
  document.head.appendChild(script);

  // Create the Google Map
  script.onload = function() {
    var mapOptions = {
      center: markerLatLng,
      zoom: 12 // Adjust the zoom level
    };
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    
    // Add marker to the map
    var marker = new google.maps.Marker({
      position: markerLatLng,
      map: map,
      title: "Marker title" // Replace with your marker title
    });
  };
});

// When the user clicks on <span> (x), close the modal
document.getElementsByClassName("close")[0].addEventListener("click", function() {
  document.getElementById("map-modal").style.display = "none";
});

console.log(latitude)
</script>



  
  </body>
</html>
<!-- -->
