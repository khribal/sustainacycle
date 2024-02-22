<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php include('./includes/boot-head.php');?>

    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>SustainaCycle</title>
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

<?php 
include('includes/nav.php');
include('./includes/chart-data.php');

//Registration completed for new user
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
    echo '<div style="text-align: center; color: green; font-size: 16px; font-weight: bold;">Registration successful! Welcome, ' . $_SESSION['name'] . '!</div>';
    // Reset the flag to avoid showing the message on subsequent visits
    $_SESSION['registration_success'] = false;

  //Add material sucessfully completed
}elseif (isset($_SESSION['add_success']) && $_SESSION['add_success']){
  echo '<div style="text-align: center; color: green; font-size: 16px; font-weight: bold;"> Material successfully added!</div>';
  $_SESSION['add_success'] = false;
}

//Login successful
if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
  echo '<div style="text-align: center; color: green; font-size: 16px; font-weight: bold;">Login successful! Welcome, ' . $_SESSION['name'] . '!</div>';
  // Reset the flag to avoid showing the message on subsequent visits
  $_SESSION['login_success'] = false;
}
?>



<main role="main" class="index">

<div class="container">
<section class="index">
      <img src="logo.png" alt="logo" height="300px" width="300px">
      <h1 class="index">SustainaCycle</h1>
      <h4 class="index">Transforming fashion: bridging the gap between keeping up with fast moving trends and environmental responsibility through a circular fashion ecosystem.</h4>
      <p><a class="button mt-2" href="project.php">Learn more &raquo;</a></p>
  </section>
</div>


<div class="container">
<h2>Our Sustainable Fashion Initiative</h2>
<section class="row">
    <div class="col-md-4">
      <h2 class="index">Sustainability</h2>
      <p class="index">The core of our solution is rooted in sustainability, and the ability to maintain the current fashion market without causing significant negative impacts on the environment, society, and economy. We are looking to meet the needs of the present generation without compromising the ability of future generations to meet their needs.</p>
    </div>
    <div class="col-md-4">
      <h2 class="index">Circular Fashion Solution</h2>
      <p class="index">Our solution is designed to break free from the linear fashion system, and instead advocating for a circular fashion ecosystem where clothing waste is repurposed instead of ending up in landfills. Discover how we connect recycling companies with manufacturers to establish a sustainable fashion economy.</p>
    </div>
    <div class="col-md-4">
      <h2 class="index">Aligning Style with the Environment</h2>
      <p class="index">The heart of our project is addressing the critical gap between fashion demand and environmental responsibility. We hope to align the pulse of social trends with sustainability, to reduce the industry's environmental footprint and contribute to a more responsible future.</p>
    </div>
</section>
</div>

<!-- Sneak peek at logistics -->
<div class="container">
  <h4>Our Impact</h4>
  <p>Explore our visual overview showcasing the transformative journey of your textile donations. We bridge manufacturers, users, and recycling centers, creating a circular fashion ecosystem. Dive into the graphs below to witness the collective impact on sustainability. Check out our recycling logistics page in the navigation for more charts and information about the impact we have made since the launch of our site.
</p>
<!-- Container for graphs -->
<div class="container">
  <div class="row align-items-center">
    <div class="col">
      <div>
        <h4>Top Manufacturers' Impact</h4>
        <p>Discover the leading manufacturers contributing to our sustainable fashion ecosystem. See who's making a significant impact through textile donations.</p>
        <canvas id="manu-chart" class="chart-container"></canvas>
      </div>
    </div>
    <div class="col">
      <div>
        <h4>Recycler Rankings</h4>
        <p>Explore recyclers who embrace sustainability by accepting various textile quantities. Find out who leads in recycling efforts.</p>
        <canvas id="recy-chart" class="chart-container"></canvas>
      </div>
    </div>
  </div>
  <div class="row align-items-end">
    <div class="col">
    <div>
      <h4>Textiles Recycled Timeline</h4>
      <p>Track the evolving pattern of textile donations over time. Gain insights into the historical impact of your contributions.</p>
      <canvas id="lineSpot" class="chart-container"></canvas>
    </div>
    </div>
    <div class="col">
      <div>
        <h4>Diverse Textile Recycling</h4>
        <p>Dive into the pie chart showcasing the variety of textiles recycled. Understand the proportions of each material, contributing to a more eco-friendly future.</p>
        <canvas id="materialSpot" class="chart-container"></canvas>
      </div>
    </div>
  </div>
</div>
</div>

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
<?php 
include('includes/footer.php');
?>

<!-- JS files --> 
<script src="js/confirm-logout.js"></script>
    <!-- Link to charts.js extension -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./js/charts.js" type="module"></script>


<!-- Call chart functions -->
<script type="module">
    //manufacturer
    import { createHorizontalBarChart, createLine, vertBar } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.manufacturer), dataFromPHP.map(entry => entry.quantity), 'manu-chart');

    //recycler
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.recycler), dataFromPHP1.map(entry => entry.quantity), 'recy-chart');

    //textiles recycled over time
    var dataFromPHP2 = <?php echo $jsonResult2; ?>;
    createLine(dataFromPHP2.map(entry => entry.quantity), dataFromPHP2.map(entry => entry.transationDate), 'lineSpot');
    
    //materials chart
    var dataFromPHP3 = <?php echo $jsonResult3; ?>;
    vertBar(dataFromPHP3.map(entry => entry.materialName), dataFromPHP3.map(entry => entry.quantity), 'materialSpot');

</script>


<!-- Bootstrap -->
<?php include('./includes/boot-script.php');?>

<!-- Additional documentation for <main> portion of body -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>



</body>
</html>