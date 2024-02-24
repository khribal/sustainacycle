<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'active';} ?>">
        <a class="nav-link" href="index.php">Home</a>
      </li>

      <!-- Logged out and individual users have access to education tab -->
      <?php 
      //get access to session vars
      session_start();

        if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] == 'individual_user') {
            echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'education.php' ? ' active' : '') . '"><a class="nav-link" href="education.php">Learn About Sustainability</a></li>';
        }
      ?>
      
      <!-- Only allow recyclers to see available waste -->
      <?php 
        if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'recycler') {
            echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'waste.php' ? 'active' : '') . '"><a class="nav-link" href="waste.php">See Available Waste</a></li>';
        }
      ?> 

      <!-- Only allow individual users to see their impact -->
        <?php 
            if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'individual_user') {
                echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'u_logistics.php' ? 'active' : '') . '"><a class="nav-link" href="u_logistics.php">Your Impact</a></li>';
            }
          ?> 
      
        <!-- Only show "Find Nearby Recycling" to users not logged in, individuals, or manufacturers -->
      <?php 
        if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] == 'individual_user' || $_SESSION['usertype'] == 'manufacturer') {
            echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'maps.php' ? 'active' : '') . '"><a class="nav-link" href="maps.php">Find Nearby Recycling</a></li>';
        }
      ?>
      
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'logistics.php'){echo 'active';} ?>">
        <a class="nav-link" href="logistics.php">Recycling Logistics</a>
      </li>
    
      <!-- Only allow manufacturer to add waste -->
    <?php 
      if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'manufacturer') {
        echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'add-waste.php' ? 'active' : '') . '"><a class="nav-link" href="add-waste.php">Add textile waste</a></li>';
      }
    ?>
 
 <!-- Only allow recyclers to see available waste -->
  <?php 
      if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'recycler') {
        echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'waste.php' ? 'active' : '') . '"><a class="nav-link" href="waste.php">Available waste</a></li>';
      }
    ?>
  
          <!-- Only allow individual users to join a community -->
          <?php 
        if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'individual_user') {
            echo '<div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Communities
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="./join-community.php">Join a Community</a>
              <a class="dropdown-item" href="./user_communities.php">Your Communities</a>
            </div>
          </div>';
        }
      ?> 
    </ul>

    <!-- Login/logout buttons -->
    <ul class="navbar-nav ml-auto">
      <?php
          if (isset($_SESSION['username'])) {
              // User is logged in
              echo '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $_SESSION['username'] . '</button> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="u_profile.php">Profile</a>';
              if ($_SESSION['usertype'] == 'individual_user'){
                echo '<a class="dropdown-item" href="u_logistics.php">Your Impact</a><a class="dropdown-item" href="user_communities.php">Your Communities</a><a class="dropdown-item" href="./login-files/logout.php">Log out</a></div></div>';
              }
              elseif($_SESSION['usertype'] == 'manufacturer'){
                echo '<a class="dropdown-item" href="./manu_waste.php">Your Materials</a><a class="dropdown-item" href="./login-files/logout.php">Log out</a></div></div>';
              }
              else{
                echo '<a class="dropdown-item" href="./login-files/logout.php">Log out</a></div></div>';
              }
          } else {
              // User is not logged in
              echo '<li class="nav-item"><a class="nav-link" href="login-files/login.php">Log in</a></li>';
          }
      ?>
    </ul>
  </div>
</nav>
