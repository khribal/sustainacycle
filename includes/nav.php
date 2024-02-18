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
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'team.php'){echo 'active';} ?>">
        <a class="nav-link" href="team.php">About Us</a>
      </li>
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'project.php'){echo 'active';} ?>">
        <a class="nav-link" href="project.php">About the Project</a>
      </li>
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'video.php'){echo 'active';} ?>">
        <a class="nav-link" href="video.php">Promotional Video</a>
      </li>
      <li class="nav-item <?php if(basename($_SERVER['PHP_SELF']) == 'education.php'){echo 'active';} ?>">
        <a class="nav-link" href="education.php">Learn About Sustainability</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <?php
          session_start(); // Start the session at the beginning of the script
          if (isset($_SESSION['username'])) {
              // User is logged in
              echo '<li class="nav-item"><a class="nav-link" href="login-files/logout.php">Logout</a></li>';
          } else {
              // User is not logged in
              echo '<li class="nav-item"><a class="nav-link" href="login-files/login.php">Log in</a></li>';
          }
      ?>
    </ul>
  </div>
</nav>
