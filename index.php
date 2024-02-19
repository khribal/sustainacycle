<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,200;0,9..40,400;0,9..40,600;1,9..40,200;1,9..40,400;1,9..40,600&family=DM+Serif+Display:ital@0;1&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Landing Page</title>
    <!-- Google API Client -->
    <!-- <script src="https://apis.google.com/js/platform.js" async defer></script>  -->
     <!-- Javascript file for Google Login -->
    <!-- <script src="js/login.js"></script> -->

    <!-- Google verification oauth-->
    <!-- <meta name="google-site-verification" content="V5zeazYMAdNXYes51Fa5-pHgIBwW86BP6LbgHnVT98Y" />
    <script src="https://apis.google.com/js/platform.js" async defer></script> -->

    <!-- Google login attempt 2 -->
    <!-- <meta name="google-signin-client_id" content="605347545950-imrjc8ufcpoeb1rv424p2ggd4qtghpku.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script> -->
  </head>
<body class="index">

<?php include('includes/nav.php') ?>


<!-- Registration Completed Notification-->
<?php
session_start();

if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
    echo '<div style="text-align: center; color: green; font-size: 16px; font-weight: bold;">Registration successful! Welcome, ' . $_SESSION['username'] . '!</div>';
    
    // Reset the flag to avoid showing the message on subsequent visits
    $_SESSION['registration_success'] = false;
}
?>


<main role="main" class="index">

<article class="container index mx-auto p-2">
    <section class="index">
      <img src="logo.png" alt="logo" height="300px" width="300px">
      <h1 class="display-3 index">Sustainable Fashion</h1>
      <h4>Transforming fashion: bridging the gap between keeping up with fast moving trends and environmental responsibility through a circular fashion ecosystem.</h4>
      <p><a class="btn btn-primary btn-lg" href="project.php" role="button">Learn more &raquo;</a></p>
  </section>
</article>


<article class="container  mx-auto p-2">
  <!-- Example row of columns -->
  <section class="row">
    <div class="col-md-4">
      <h2>Sustainability</h2>
      <p>The core of our solution is rooted in sustainability, and the ability to maintain the current fashion market without causing significant negative impacts on the environment, society, and economy. We are looking to meet the needs of the present generation without compromising the ability of future generations to meet their needs.</p>
    </div>
    <div class="col-md-4">
      <h2>Circular Fashion Solution</h2>
      <p>Our solution is designed to break free from the linear fashion system, and instead advocating for a circular fashion ecosystem where clothing waste is repurposed instead of ending up in landfills. Discover how we connect recycling companies with manufacturers to establish a sustainable fashion economy.</p>
    </div>
    <div class="col-md-4">
      <h2>Aligning Style with the Environment</h2>
      <p>The heart of our project is addressing the critical gap between fashion demand and environmental responsibility. We hope to align the pulse of social trends with sustainability, to reduce the industry's environmental footprint and contribute to a more responsible future.</p>
    </div>
</section>
</article>


  <hr>
</div> <!-- /container -->


<a href="login-files/login.php"><h1>TEST</h1></a>
<!-- Google login -->
<!-- <div class="g-signin2" data-onsuccess="onSignIn"></div>

<a href="#" onclick="signOut();">Sign out</a>

<script src="js/google-login.js"></script>

<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script> -->

</main>


<!-- Footer --> 
<footer class="container  mx-auto p-2">
<p>&copy; Team 20, 2023-2024</p>
</footer>

<!-- JS folder --> 
<script src="js/confirm-logout.js"></script>


<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Additional documentation for <main> portion of body -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>



</body>
</html>