<?php
$api_key = 'AIzaSyDfM9phS4T2l9brU8UX75MhdGYYja8Fyvk';

if(isset($_GET['error']))
{
  if($_GET['error'] == "ip_address_unknown")
  {
    $error = "<div class='alert alert-danger'>Error IP Address unknown !</div>";
  }
}

if(isset($_GET['ip_address']))
{
  if(!empty($_GET['ip_address']))
  {
      $user_ip = htmlspecialchars($_GET['ip_address']); 
      $geo = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$user_ip?key=3PJkdWc9mMfE1rmuTf8i"));
      $country = $geo->country;
      $city = $geo->city;
      $ipType = $geo->ipType;
      $isp = $geo->isp;
      $region = $geo->region;
      $continent = $geo->continent;
      $countryCode = $geo->countryCode;
      $ipName = $geo->ipName;
      $lat = $geo->lat;
      $lon = $geo->lon;
      $businessName = $geo->businessName;
      $businessWebsite = $geo->businessWebsite;
      $success = $geo->status;
      if($success == "fail")
      {
        header('Location: index.php?error=ip_address_unknown');
      }

  }else{
    echo "<script>document.location.replace('index.php?error=ip_address_unknown')</script>";
  }
}
  else
{
  $user_ip_no_get = $_SERVER['REMOTE_ADDR'];
  $geo_no_get = json_decode(file_get_contents("http://extreme-ip-lookup.com/json/$user_ip_no_get?key=3PJkdWc9mMfE1rmuTf8i"));
  $country_no_get = $geo_no_get->country;
  $city_no_get = $geo_no_get->city;
  $ipType_no_get = $geo_no_get->ipType;
  $isp_no_get = $geo_no_get->isp;
  $region_no_get = $geo_no_get->region;
  $continent_no_get = $geo_no_get->continent;
  $countryCode_no_get = $geo_no_get->countryCode;
  $ipName_no_get = $geo_no_get->ipName;
  $lat_no_get = $geo_no_get->lat;
  $lon_no_get = $geo_no_get->lon;
  $businessName_no_get = $geo_no_get->businessName;
  $businessWebsite_no_get = $geo_no_get->businessWebsite;
}



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <script src="js/login.js"></script>

    <title>Dashboard | AI IoT Health Solutions</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../assets/favicon/site.webmanifest">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/device-list.css">
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body>
    <div class="container" id="blur">
        <div class="sidebar">
            <div class="logo-details">
            </div>
            <ul class="nav-links">
                <li class="dash content active">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </li>
                <li class="diagnosis content">
                    <i class="bx bx-line-chart"></i>
                    <span class="links_name">Diagnosis</span>
                </li>

                <li class="device content">
                    <i class="bx bx-add-to-queue"></i>
                    <span class="links_name">Medical Devices</span>
                </li>
                <li class="treatment content">
                    <i class="bx bxs-capsule"></i>
                    <span class="links_name">Treatment</span>
                </li>
                <li class="schedule content">
                    <i class="bx bx-calendar"></i>
                    <span class="links_name">My Schedule</span>
                </li>
                <li class="helpline content">
                    <i class="bx bxs-phone-call"></i>
                    <span class="links_name">Healthcare Visit</span>
                </li>
                <li class="symptom-bot content">
                    <i class="bx bxs-bot "></i>
                    <span class="links_name">Symptoms ChatBot</span>

                </li>
                <li class="emotion-bot content">
                    <i class="bx bxs-bot "></i>
                    <span class="links_name">Emotion Checker</span>

                </li>
                <li class="location content">
                    <i class="fa-solid fa-location-dot cart two "></i>
                   <a href="location.php"><span class="links_name">Patient Location</span></a> 
                </li>
                <li class="log_out">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Log out</span>
                </li>
            </ul>
        </div>
        <section class="home-section">
            <nav>
                <div class="sidebar-button">
                    <i class='bx bx-menu sidebarBtn'></i>
                    <span class="dashboard">Dashboard</span>
                </div>
                <div class="logo">
                    <img src="../../assets/img/logo%20blue%20bg.PNG?raw=true" class="logo" alt="logo-blue-bg" style="width: 50%;height: auto;margin: 15px;" border="0">
                </div>
                <div class="search-box">
                    <input type="text" placeholder="Search...">
                    <i class='bx bx-search'></i>
                </div>
                <div class="profile-details">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="DP">
                    <span class="admin_name username"></span>
                    <i class='bx bx-chevron-up'></i>

                    <div class="section-dropdown">

                        <a class="sd-list" href="../account/">Account</a>
                        <a class="sd-list" href="../documentation/">Documentation</a>
                        <a class="sd-list" href="../premium/">Premium</a>
                        <a class="sd-list" href="../preference/">Preference</a>

                    </div>

                </div>
            </nav>

           <br><br><br><br><br>
                <div class="diagnosis-boxes">
                    <div class="graphout box">
                        <?php 
                          if(isset($error)) {
                            echo $error; ?>
                             
                        <?php }else{ ?>
                        <?php if(isset($_GET['ip_address'])) { ?>
                       
                        <?php }else{ ?>
                          <div class="col-lg-9">
                          <br>
                        <h2 class="text-center"><i class="fas fa-info-circle"></i> Patient Location Info</h2>
                          <table class="info_ip card">
                            <tr>
                              <td id="info_class_ip"> Location IP</td>
                              <td id="result_ip"><?=$user_ip_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">IPType</td>
                              <td id="result_ip"><?=$ipType_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">ISP</td>
                              <td id="result_ip"><?=$isp_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">City</td>
                              <td id="result_ip"><?=$city_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">Latitude</td>
                              <td id="result_ip"><?=$lat_no_get?></td>
                            </tr>
                              <td id="info_class_ip">Longitude</td>
                              <td id="result_ip"><?=$lon_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">Region</td>
                              <td id="result_ip"><?=$region_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">Country</td>
                              <td id="result_ip"><?=$country_no_get?>, <?=$countryCode_no_get?></td>
                            </tr>
                            <tr>
                              <td id="info_class_ip">Continent</td>
                              <td id="result_ip"><?=$continent_no_get?></td>
                            </tr>
                          </table>
                        </div>
                        <div class="col-lg-12">
                        <br>
                        <h2 class="text-center"><i class="fas fa-map-marked-alt"></i> Map Location</h2>
                            <iframe
                              width="100%"
                              height="450"
                              frameborder="0" style="border:3px solid #343a40;"
                                src="https://www.google.com/maps/embed/v1/place?key=<?=$api_key?>&q=<?=$lat_no_get?>,<?=$lon_no_get?>&zoom=16" allowfullscreen>
                            </iframe>
                        </div>
                        <div class="col-lg-6">
                        <br>
                        <h2 class="text-center"><i class="fas fa-info-circle"></i> Additional info</h2>
                          <table class="info_ip card">
                            <tr>
                              <td id="info_class_ip">Connected Device Details: </td>
                              <td id="result_ip"><?=$_SERVER['HTTP_USER_AGENT']?></td>
                            </tr>
                            </tr>
                          </table>
                        </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    </div>
                  </div>
                  <div class="col-lg-12 text-center">
             </div>=
        </div>
  </div>
</div>

