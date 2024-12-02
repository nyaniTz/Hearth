<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Patients</title>

  <link rel="apple-touch-icon" sizes="180x180" href="../../assets/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/favicon/favicon-16x16.png">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/table.css">

  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <script src="js/script.js" defer></script>

</head>

<body>
  <?php include "components/sidebar.php" ?>
  <section class="home-section">
  <?php include "components/navigation.php" ?>
  
    <div class="home-content"> 

    <h1 class="home-content-heading">Patients</h1>

    <table class="customTable">
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Insurance Number</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>John</td>
          <td>Doe</td>
          <td>23</td>
          <td>Male</td>
          <td>234567890</td>
        </tr>
        <tr>
          <td>Mary</td>
          <td>Jane</td>
          <td>44</td>
          <td>Female</td>
          <td>098765432</td>
        </tr>
        <tr>
          <td>Kevin</td>
          <td>Denis</td>
          <td>20</td>
          <td>Male</td>
          <td>987654321</td>
        </tr>
        <tr>
          <td>Reena</td>
          <td>Pan</td>
          <td>24</td>
          <td>Female</td>
          <td>123456789</td>
        </tr>
      </tbody>
    </table>
  </section>
  </div>
</body>

</html>
