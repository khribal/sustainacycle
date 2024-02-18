<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="team.php">About Us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="project.php">About the Project</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="video.php">Promotional Video</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="waste.php">See Available Waste</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="join-community.php">Join A Community</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <?php
            session_start(); // Start the session
            if (isset($_SESSION['username'])) {
              // User is logged in
              echo '<li class="nav-item"><a href="login-files/logout.php"><button id="logout-button">Logout</button></a></li>';
          } else {
              // User is not logged in
              echo '<li class="nav-item"><a href="login-files/login.php"><button>Log in</button></a></li>';
          }
      ?>
    </ul>
  </div>
</nav>