<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <title>SUstainaCycle</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
<?php include('includes/nav.php'); ?>
<body>
<div class="container mx-auto p-2">
    <h1 class="landing">Welcome to SustainaCycle!</h1>
    <div class="options">
        <a href="waste.php" class="option-button"> See waste that is available now!</a>
        <a href="project.php" class="option-button">Learn more about the project.</a>
    </div>
</div>

<!-- Bootstrap, footer -->
<?php 
include('../includes/footer.php');
include('../includes/boot-script.php');
?>

</body>
</html>