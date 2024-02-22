<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charts</title>

    <!-- Bootstrap -->
    <?php include('./includes/boot-head.php');?>
    <!--CSS -->
    <link rel="stylesheet" href="css/styles.css">


</head>
<body>
<?php 
    include('includes/nav.php');
    include('./includes/chart-data.php');
?>


<div>
<div class="heading">
    <h1>Recycling Logistics Overview: Making an Impact on Sustainability</h1>
    <p>Welcome to our Recycling Logistics Overview, a visual representation of the impactful journey your textile donations take within our circular fashion ecosystem. At SustainaCycle, we are committed to transforming the fashion industry by bridging the gap between manufacturers, individual users, and recycling centers for textiles. Explore the insightful data visualizations below to witness the positive impact we've collectively made on sustainability.</p>
</div class="container-charts">

        <!-- Horizontal bar chart -->
        
                    <!--Manufacturer-->
                <div>
                    <h2>Manufacturer Contributions: A Stitch in Sustainable Fashion</h2>
                    <p>In the horizontal bar chart, we showcase the generous contributions from manufacturers who have embraced the circular fashion revolution. Discover the top contributors, ranked by the quantity of textiles donated. Each donation represents a commitment to sustainable practices and a step towards a greener, eco-friendly future.</p>
                    <div><canvas id="chart-space"></canvas></div>
                </div>

                    <!--Recycler-->
                    <div>
                    <h2>Recycler Acceptance: Weaving a Greener Tomorrow</h2>
                    <p>Delve into the Recycler Accepted Textiles chart to see the vital role recycling centers play in accepting and repurposing textiles. Recognize the recyclers who have embraced our mission, ranked by the quantity of textiles accepted. Together, we weave a tapestry of positive change, diverting textiles from landfills and contributing to a circular fashion economy.</p>
                    <div><canvas id="chart-space1"></canvas></div>
                    </div>
        
        <!--Line chart -->
        <div class="line-parent">
            <h2>Textiles Recycled Over Time: Tracing our Environmental Footprint</h2>
            <p>Our line chart illustrates the evolving pattern of textile donations over time. Witness the growth of our community's commitment to sustainability, as reflected in the quantities of textiles recycled. Each data point represents a step towards reducing environmental impact, making a lasting mark on the fashion industry's approach to responsible production and consumption.</p>
            <div class="chart-view">
                <canvas id="lineSpot" width="573" height="286"
                style="display: block; box-sizing: border-box; height: 191px; width: 382px;"></canvas>
            </div>
        </div>

        <!-- Materials chart -->
        <div>
            <h2>Types of Textiles Recycled: Diverse Contributions for a Colorful Impact</h2>
            <p>The pie chart reveals the diverse types of textiles recycled on our platform. Explore the proportions of each material recycled, measured in pounds. From cotton and polyester to innovative eco-friendly fabrics, our community's contributions paint a colorful picture of sustainability in fashion.</p>
            <div><canvas id="matCanv"></canvas></div>
        </div>



</div>
  
        <!-- Link to charts.js extension -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <!-- Link to js chart functions -->
        <script type="module" src="./js/charts.js"></script>


         <!-- Calling chart functions -->
<script type="module">
    //Horizontal bar manufacturers
    import { createHorizontalBarChart, createLine, vertBar } from './js/charts.js';
    var dataFromPHP = <?php echo $jsonResult; ?>;
    createHorizontalBarChart(dataFromPHP.map(entry => entry.manufacturer), dataFromPHP.map(entry => entry.quantity), 'chart-space');

    //Horizontal bar recyclers 
    var dataFromPHP1 = <?php echo $jsonResult1; ?>;
    createHorizontalBarChart(dataFromPHP1.map(entry => entry.recycler), dataFromPHP1.map(entry => entry.quantity), 'chart-space1');

    //Line chart
    var dataFromPHP2 = <?php echo $jsonResult2; ?>;
    createLine(dataFromPHP2.map(entry => entry.quantity), dataFromPHP2.map(entry => entry.transationDate), 'lineSpot');

    //material bar chart
    var dataFromPHP3 = <?php echo $jsonResult3; ?>;
    vertBar(dataFromPHP3.map(entry => entry.materialName), dataFromPHP3.map(entry => entry.quantity), 'matCanv');
</script>
</body>
</html>