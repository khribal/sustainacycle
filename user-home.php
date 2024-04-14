<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <?php include('./includes/boot-head.php');?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <style>
        .index-line {
        height: 250px;
        }
        /*hover effects */
/*!
 * Hover.css (http://ianlunn.github.io/Hover/)
 * Version: 2.3.2
 * Author: Ian Lunn @IanLunn
 * Author URL: http://ianlunn.co.uk/
 * Github: https://github.com/IanLunn/Hover

 * Hover.css Copyright Ian Lunn 2017. Generated with Sass.
 */
/* Grow */
.hvr-grow {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -webkit-transition-property: transform;
    transition-property: transform;
}

.hvr-grow:hover,
.hvr-grow:focus,
.hvr-grow:active {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
    </style>
    <title>SustainaCycle</title>
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
}
?>

<!-- container around body to prevent dropdowns from appearing off the page -->
<main role="main" class="index">

<div class="container mx-auto p-2">
<img src="./img/logo.png" alt="logo" height="250px" width="250px">
    <h1 class="index">Welcome to SustainaCycle!</h1>
    <div class="options">
        <a href="maps.php" class="option-button">
            <img src="img/map.png" alt="Location Icon" class="option-icon" height="96px" width="96px">
            <div class="option-content">
                <span>See nearby recycling centers to donate waste.</span>
</div></a>
        <a href="project.php" class="option-button">
            <img src="img/tree.png" alt="Project Icon" class="option-icon" height="96px" width="96px">
            <div class="option-content">
                <span>Learn more about the project.</span>
</div></a>
    </div>
</div>





<div class="container mx-auto p-2">
<h2 class="index mb-0">Our Sustainable Fashion Initiative</h2>
<p class="index mb-5">Learn more about why we created our platform, and the goals of our site.</p>
<section class="row">
  <div class="col hvr-grow">
    <div class="card h-100" style="width: 21rem;">
      <img class="card-img-top mx-auto" src="./img/homepage_icons/1.png" alt="Card image cap" style="height: 50%; width: 50%;">
      <div class="card-body">
        <h3 class="index">Sustainability</h3>
        <p class="index">The core of our solution is rooted in sustainability, and the ability to maintain the current fashion market without causing significant negative impacts on the environment, society, and economy. We are looking to meet the needs of the present generation without compromising the ability of future generations to meet their needs.</p>
      </div>
    </div>
  </div>
  
  <div class="col hvr-grow">
    <div class="card h-100" style="width: 21rem;">
      <img class="card-img-top mx-auto" src="./img/homepage_icons/2.png" alt="Card image cap" style="height: 50%; width: 50%;">
      <div class="card-body">
        <h3 class="index">Circular Fashion Solution</h3>
        <p class="index">Our solution is designed to break free from the linear fashion system, and instead advocating for a circular fashion ecosystem where clothing waste is repurposed instead of ending up in landfills. Discover how we connect recycling companies with manufacturers to establish a sustainable fashion economy.</p>
      </div>
    </div>
  </div>

  <div class="col hvr-grow">
    <div class="card h-100" style="width: 21rem;">
      <img class="card-img-top mx-auto" src="./img/homepage_icons/3.png" alt="Card image cap" style="height: 50%; width: 50%;">
      <div class="card-body">
        <h3 class="index">Aligning Style with the Environment</h3>
        <p class="index">The heart of our project is addressing the critical gap between fashion demand and environmental responsibility. We hope to align the pulse of social trends with sustainability, to reduce the industry's environmental footprint and contribute to a more responsible future.</p>
      </div>
    </div>
  </div>

</section>
  
</div>






<!-- Sneak peek at logistics -->
<div class="container mx-auto p-2">
  <h2 class="index">Our Impact</h2>
  <p class="index">Explore our visual overview showcasing the transformative journey of your textile donations. We bridge manufacturers, users, and recycling centers, creating a circular fashion ecosystem. Dive into the graphs below to witness the collective impact on sustainability. Check out our <a href="./tableau.php">recycling logistics page</a> in the navigation for more charts and information about the impact we have made since the launch of our site.
</p>
<!-- Container for graphs -->
<div class="container mx-auto p-2">
  <div class="row align-items-center">
    <div class="col">
      <div>
        <h3 class="index">Top Manufacturers' Impact</h3>
        <p class="index">See who's making a significant impact through textile donations.</p>
        <canvas id="manu-chart" class="chart-container"></canvas>
      </div>
    </div>
    <div class="col">
      <div>
        <h3 class="index">Recycler Rankings</h3>
        <p class="index">Find out who leads in recycling efforts.</p>
        <canvas id="recy-chart" class="chart-container"></canvas>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
    <div>
      <h3 class="index">Textiles Recycled Timeline</h3>
      <p class="index">Track the evolving pattern of textile donations over time.</p>
      <canvas id="lineSpot" class="chart-container"></canvas>
    </div>
    </div>
    <div class="col">
      <div class="index-line">
        <h3 class="index">Diverse Textile Recycling</h3>
        <p class="index">Dive into the bar chart showcasing the variety of textiles recycled.</p>
        <canvas id="materialSpot" class="chart-container"></canvas>
      </div>
    </div>
  </div>
</div>

</div>

</main>


<!-- Footer --> 
<?php 
include('includes/footer.php');
?>
</div>
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
    createHorizontalBarChart(dataFromPHP.map(entry => entry.manufacturer), dataFromPHP.map(entry => entry.quantity), 'manu-chart', 'rgba(72, 143, 132, 0.2)', 'rgba(72, 143, 132, 1)');

    //recycler
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.recycler), dataFromPHP1.map(entry => entry.quantity), 'recy-chart', 'rgba(65, 135, 0, 0.2)', 'rgba(65, 135, 0, 1)');

    //textiles recycled over time
    var dataFromPHP2 = <?php echo $jsonResult2; ?>;
    createLine(dataFromPHP2.map(entry => entry.quantity), dataFromPHP2.map(entry => entry.transationDate), 'lineSpot');
    
    //materials chart
    var dataFromPHP3 = <?php echo $jsonResult3; ?>;
    vertBar(dataFromPHP3.map(entry => entry.materialName), dataFromPHP3.map(entry => entry.quantity), 'materialSpot', 'rgba(65, 135, 0, 0.2)', 'rgba(65, 135, 0, 1)');

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