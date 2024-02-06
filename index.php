<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Landing Page</title>
    <script src="https://apis.google.com/js/platform.js" async defer></script> <!-- Google API Client -->
    <script src="js/login.js"></script> <!-- avascript file for Google Login -->
</head>
<body>

<?php include('includes/nav.php') ?>


<main role="main">

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
  <div class="container">
    <div class="headline-image">
    <h1 class="display-3">Sustainable Fashion</h1>
    <h4>Transforming fashion: bridging the gap between keeping up with fast moving trends and environmental responsibility through a circular fashion ecosystem.</h4>
    <p><a class="btn btn-primary btn-lg" href="project.php" role="button">Learn more &raquo;</a></p>
    </div>
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
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
  </div>


  <div>
    <div class="container">
    <h4>See what materials manufacturers have available to recycle right now!</h4>
    <p><a class="btn btn-primary btn-lg" href="waste.php" role="button">See Available Waste &raquo;</a></p>
    </div>
  </div>

  <hr>

</div> <!-- /container -->

</main>

<!-- Footer --> 
<footer class="container">
<p>&copy; Team 20, 2023-2024</p>
</footer>


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