<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Charts</title>
    <!-- Google fonts, bootstrap -->
    <?php 
        include('./includes/boot-head.php');
        // include('./includes/google-fonts.php');
    ?>

    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.ico">

</head>
<body>
<?php 
    include('includes/nav.php');
    include('./includes/chart-data.php');
?>

<div class="container px-4 mx-auto p-1 container-charts">
<div class="heading">
    <h1 class="log">Recycling Logistics Overview: Making an Impact on Sustainability</h1>
    <p class="log-lead">Welcome to our Recycling Logistics Overview, a visual representation of the impactful journey your textile donations take within our circular fashion ecosystem. At SustainaCycle, we are committed to transforming the fashion industry by bridging the gap between manufacturers, individual users, and recycling centers for textiles. Explore the insightful data visualizations below to witness the positive impact we've collectively made on sustainability.</p>
</div>

        <div class="container">
            <!--Manufacturer-->
            <h2 class="log">Manufacturer Contributions: A Stitch in Sustainable Fashion</h2>
            <p class="log-lead">In the horizontal bar chart, we showcase the generous contributions from manufacturers who have embraced the circular fashion revolution. Discover the top contributors, ranked by the quantity of textiles donated. Each donation represents a commitment to sustainable practices and a step towards a greener, eco-friendly future.</p>
            <div><canvas id="chart-space"></canvas></div>

            <!--Recycler-->
            <h2 class="log">Recycler Acceptance: Weaving a Greener Tomorrow</h2>
            <p class="log-lead">Delve into the Recycler Accepted Textiles chart to see the vital role recycling centers play in accepting and repurposing textiles. Recognize the recyclers who have embraced our mission, ranked by the quantity of textiles accepted. Together, we weave a tapestry of positive change, diverting textiles from landfills and contributing to a circular fashion economy.</p>
            <div><canvas id="chart-space1"></canvas></div>

            <!--Line chart -->
            <h2 class="log">Textiles Recycled Over Time: Tracing our Environmental Footprint</h2>
            <p class="log-lead">Our line chart illustrates the evolving pattern of textile donations over time. Witness the growth of our community's commitment to sustainability, as reflected in the quantities of textiles recycled. Each data point represents a step towards reducing environmental impact, making a lasting mark on the fashion industry's approach to responsible production and consumption.</p>
            <canvas id="lineSpot" width="573" height="286" style="display: block; box-sizing: border-box; height: 191px; width: 382px;"></canvas>

            <!--Materials chart -->
            <h2 class="log">Types of Textiles Recycled: Diverse Contributions for a Colorful Impact</h2>
            <p class="log-lead">The pie chart reveals the diverse types of textiles recycled on our platform. Explore the proportions of each material recycled, measured in pounds. From cotton and polyester to innovative eco-friendly fabrics, our community's contributions paint a colorful picture of sustainability in fashion.</p>
            <div style="width: 800px;"><canvas id="matCanv"></canvas></div>

            <!-- -->
            <h2 class="log">Monthly User Transaction Overview</h2>
            <p class="log-lead">Discover the monthly overview of user transactions, highlighting the count of unique users involved and the total quantity of items processed each month. The bubble chart visually represents the dynamics and patterns in user transaction activities over time.</p>
            <canvas id="bubble-chart"></canvas>
        </div>

        <!-- Link to charts.js extension -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Link to js chart functions -->
        <script type="module" src="./js/charts.js"></script>

        <!-- Date adaptor -->
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

         <!-- Calling chart functions -->
<script type="module">
    //Horizontal bar manufacturers
    import { createHorizontalBarChart, createLine, vertBar, createBubble } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.manufacturer), dataFromPHP.map(entry => entry.quantity), 'chart-space', 'rgba(72, 143, 132, 0.2)', 'rgba(72, 143, 132, 1)');

    //Horizontal bar recyclers 
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.recycler), dataFromPHP1.map(entry => entry.quantity), 'chart-space1', 'rgba(65, 135, 0, 0.2)', 'rgba(65, 135, 0, 1)');

    //Line chart
    var dataFromPHP2 = <?php echo $jsonResult2; ?>;
    createLine(dataFromPHP2.map(entry => entry.quantity), dataFromPHP2.map(entry => entry.transationDate), 'lineSpot');

    //material bar chart
    var dataFromPHP3 = <?php echo $jsonResult3; ?>;
    vertBar(dataFromPHP3.map(entry => entry.materialName), dataFromPHP3.map(entry => entry.quantity), 'matCanv', 'rgba(65, 135, 0, 0.2)', 'rgba(65, 135, 0, 1)');

    //bubble chart
    var dataBubble = <?php echo $jsonBubble; ?>;
    createBubble(dataBubble, 'bubble-chart');



</script>

<?php 
    include('./includes/footer.php');
    include('./includes/boot-script.php');
?>
</body>
</html>