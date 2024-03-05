<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    include('./includes/boot-head.php');
    include('./includes/google-fonts.php'); 
    ?>

    <link rel="stylesheet" href="./css/styles.css">
    
    <title>SustainaCycle</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<?php include('./includes/nav.php'); 
  include('./includes/chart-data.php'); ?>

<div class="container mx-auto p-2">
<img src="./img/logo.png" alt="logo" height="250px" width="250px">
    <h1 class="index">Welcome to SustainaCycle!</h1>
    <div class="options mt-5">
        <a href="./waste/add-waste.php" class="option-button">
            <img src="img/shirt.png" alt="Waste Icon" class="option-icon" height="96px" width="96px">
            <div class="option-content">
                <span>Have more available waste? Log it here!</span>
</div></a>
        <a href="project.php" class="option-button">
            <img src="img/tree.png" alt="Project Icon" class="option-icon" height="96px" width="96px">
            <div class="option-content">
                <span>Learn more about the project.</span>
</div></a>
    </div>
</div>


<div class="container mx-auto p-2">
<h2 class="index">Our Sustainable Fashion Initiative</h2>
<section class="row">
    <div class="col-md-4">
      <h3 class="index">Sustainability</h3>
      <p class="index">The core of our solution is rooted in sustainability, and the ability to maintain the current fashion market without causing significant negative impacts on the environment, society, and economy. We are looking to meet the needs of the present generation without compromising the ability of future generations to meet their needs.</p>
    </div>
    <div class="col-md-4">
      <h3 class="index">Circular Fashion Solution</h3>
      <p class="index">Our solution is designed to break free from the linear fashion system, and instead advocating for a circular fashion ecosystem where clothing waste is repurposed instead of ending up in landfills. Discover how we connect recycling companies with manufacturers to establish a sustainable fashion economy.</p>
    </div>
    <div class="col-md-4">
      <h3 class="index">Aligning Style with the Environment</h3>
      <p class="index">The heart of our project is addressing the critical gap between fashion demand and environmental responsibility. We hope to align the pulse of social trends with sustainability, to reduce the industry's environmental footprint and contribute to a more responsible future.</p>
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
  <div class="row align-items-end">
    <div class="col">
    <div>
      <h3 class="index">Textiles Recycled Timeline</h3>
      <p class="index">Track the evolving pattern of textile donations over time.</p>
      <canvas id="lineSpot" class="chart-container"></canvas>
    </div>
    </div>
    <div class="col">
      <div>
        <h3 class="index">Diverse Textile Recycling</h3>
        <p class="index">Dive into the bar chart showcasing the variety of textiles recycled.</p>
        <canvas id="materialSpot" class="chart-container"></canvas>
      </div>
    </div>
  </div>
</div>


<!-- Bootstrap, footer -->
<?php 
include('./includes/footer.php');
include('./includes/boot-script.php');
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
</body>
</html>`