<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'active';} ?>">
        <a class="nav-link" href="../index.php">Home</a>
      </li>

      <!-- Logged out and individual users have access to education tab -->
      <?php 
      //get access to session vars
      session_start();

        if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] == 'individual_user') {
            echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'education.php' ? ' active' : '') . '"><a class="nav-link" href="../education.php">Learn About Sustainability</a></li>';
        }
      ?>
      
        <!-- Only show "Find Nearby Recycling" to users not logged in, individuals, or manufacturers -->
      <?php 
        if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] == 'individual_user' || $_SESSION['usertype'] == 'manufacturer') {
            echo '<li class="nav-item' . (basename($_SERVER['PHP_SELF']) == 'maps.php' ? 'active' : '') . '"><a class="nav-link" href="../maps.php">Find Nearby Recycling</a></li>';
        }
      ?>
      
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'tableau.php'){echo 'active';} ?>">
        <a class="nav-link" href="../tableau.php">Recycling Logistics</a>
      </li>
    
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
              else{
                echo '<a class="dropdown-item" href="../login-files/logout.php">Log out</a></div></div>';
              }
          } else {
              // User is not logged in
              echo '<li class="nav-item"><a class="nav-link" href="login.php">Log in</a></li>';
          }
      ?>
    </ul>
  </div>
</nav>
