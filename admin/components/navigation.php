<?php
  session_start();

  if(!isset($_SESSION['username'])){
    header('location:./login/');
  }
?>

<nav>
  <div class="sidebar-button bx bx-menu">
    </div>

    <div class="search-box">
      <input type="text" placeholder="Search . . .">
      <i class='bx bx-search'></i>
    </div>
    <div class="profile-details" onclick="dropdown()">
      <span class="admin-name"><?php echo $_SESSION['username'] ?></span>
      <i class='bx bx-chevron-down'></i>

      <div class="profile-details-dropdown">
        <a href="./logout/">Logout</a>
        <a href="./settings.php">Settings</a>
      </div>
    </div>
</nav>

<script>
  let isDropDown = false;
  function dropdown(){
    let dropdownItem = document.querySelector(".profile-details-dropdown");
    
    if(isDropDown){
      dropdownItem.style.display = "none";
      isDropDown = false;
    }
    else{
      dropdownItem.style.display = "grid";
      isDropDown = true;
    }
      
  }
</script>