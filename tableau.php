<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Logistics</title>
    <?php 
        include('./includes/boot-head.php');
        include('./includes/google-fonts.php');
    ?>

    <link rel="stylesheet" href="./css/styles.css" type="text/css">
    
    <!-- Tableau script -->
    <script type="module" src="https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.min.js"></script>

</head>
<body>
<?php include('./includes/nav.php'); ?>

<div class="container px-4 mx-auto p-1 container-charts">
<div class="heading">
    <h1 class="log">Recycling Logistics Overview: Making an Impact</h1>
    <p class="log-lead">Welcome to our Recycling Logistics Overview, a visual representation of the impactful journey your textile donations take within our circular fashion ecosystem. At SustainaCycle, we are committed to transforming the fashion industry by bridging the gap between manufacturers, individual users, and recycling centers for textiles. Explore the insightful data visualizations below to witness the positive impact we've collectively made on sustainability.</p>
</div>

<!-- recycler manufacturer row -->
<div>
      <tableau-viz id="tableauViz" style="width: 100%; height:500px;"      
      src='https://public.tableau.com/views/ManuDash/RecyDash' hide-tabs>
      </tableau-viz>
</div>

<div>
  <tableau-viz id="tableauViz" style="width: 100%; height:500px;"      
      src='https://public.tableau.com/views/ManuDash/ManuDash' hide-tabs>
      </tableau-viz>
</div>
  







<div class="container">
  <h2 class="log">Textile Waste Donation and Recycling Insights</h2>
  <p class="log-lead">Explore the impact of textile waste donations by manufacturers and the recycling efforts of partnered recyclers. This dashboard provides a comprehensive overview, showcasing manufacturers ranked by the quantity of textile waste donated, and recyclers recognized for accepting the most waste. Gain insights into the sustainability efforts within the textile industry and understand the positive environmental contributions made by manufacturers and recyclers alike. Discover the leaders driving positive change and contributing to a more sustainable future through responsible waste management practices. Use the filters at the top of the dashboard to filter down by month and year.</p>


    <!-- Recycler + manufacturer textile donations/accepted -->


        
<!--Quantity over time -->
<h2 class="log">Textiles Recycled Over Time: Tracing our Environmental Footprint</h2>
  <p class="log-lead">Our line chart illustrates the evolving pattern of textile donations over time. Witness the growth of our community's commitment to sustainability, as reflected in the quantities of textiles recycled. Each data point represents a step towards reducing environmental impact, making a lasting mark on the fashion industry's approach to responsible production and consumption.</p>


  <div class='tableauPlaceholder' id='viz1709095188558' style='position: relative'><noscript><a href='#'><img alt='TextOverTime ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20OverTime&#47;TextOverTime&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='Team20OverTime&#47;TextOverTime' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20OverTime&#47;TextOverTime&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /><param name='filter' value='publish=yes' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1709095188558');                    var vizElement = divElement.getElementsByTagName('object')[0];                    if ( divElement.offsetWidth > 800 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else if ( divElement.offsetWidth > 500 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else { vizElement.style.width='100%';vizElement.style.height='727px';}                     var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>



  <!--Materials -->
  <h2 class="log">Types of Textiles Recycled: Diverse Contributions for a Colorful Impact</h2>
    <p class="log-lead">The bar chart reveals the diverse types of textiles recycled on our platform. Explore the proportions of each material recycled, measured in pounds. From cotton and polyester to innovative eco-friendly fabrics, our community's contributions paint a colorful picture of sustainability in fashion.</p>

    <div class='tableauPlaceholder' id='viz1709094993791' style='position: relative'><noscript><a href='#'><img alt='MaterialDash ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20Materials&#47;MaterialDash&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='Team20Materials&#47;MaterialDash' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20Materials&#47;MaterialDash&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /><param name='filter' value='publish=yes' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1709094993791');                    var vizElement = divElement.getElementsByTagName('object')[0];                    if ( divElement.offsetWidth > 800 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else if ( divElement.offsetWidth > 500 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else { vizElement.style.width='100%';vizElement.style.height='727px';}                     var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>


<!--Users over time -->
<h2 class="log">User Growth Over Time</h2>
  <p class="log-lead">Explore the dynamic growth of our user community over time with this insightful line chart. The chart visualizes the number of users who have joined our platform during different time periods. Gain valuable insights into the growth patterns, identify key milestones, and understand the trajectory of user engagement. Whether you're tracking the success of a marketing campaign or monitoring organic growth, this chart provides a clear representation of how our user base has evolved, helping you make informed decisions for the future.</p>
    <div class='tableauPlaceholder' id='viz1709095253971' style='position: relative'><noscript><a href='#'><img alt='JoinedSince ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20UserOverTime&#47;JoinedSince&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='Team20UserOverTime&#47;JoinedSince' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Te&#47;Team20UserOverTime&#47;JoinedSince&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /><param name='filter' value='publish=yes' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1709095253971');                    var vizElement = divElement.getElementsByTagName('object')[0];                    if ( divElement.offsetWidth > 800 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else if ( divElement.offsetWidth > 500 ) { vizElement.style.width='1000px';vizElement.style.height='827px';} else { vizElement.style.width='100%';vizElement.style.height='727px';}                     var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>
</div>


<?php include('./includes/boot-script.php'); ?>
</body>
</html>