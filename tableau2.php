<!DOCTYPE html>
<html>

<head>
    <title>Resizing</title>

    <script type="text/javascript"
        src="https://public.tableau.com/javascripts/api/tableau-2.min.js"></script>
    <script type="text/javascript">
        var viz;

        function initViz() {
            var containerDiv = document.getElementById("vizContainer"),
                url = "https://public.tableau.com/views/ManuDash/ManuDash",
                options = {
                    hideTabs: true
                };

            viz = new tableau.Viz(containerDiv, url, options);
        }

        function vizResize() {
            var width = document.getElementById("resizeWidth").value;
            var height = document.getElementById("resizeHeight").value;

			viz.setFrameSize(parseInt(width, 10), parseInt(height, 10));
        }
    </script>
</head>

<body onload="initViz();">
	<div id="vizContainer" style="width:800px; height:700px; overflow:auto;"></div>
    <div id="controls" style="padding:20px;">
        <form id="resizeForm">
            <input type="text" id="resizeWidth" placeholder="Width">
            <input type="text" id="resizeHeight" placeholder="Height">
            <button type="button" onClick="vizResize();">Resize</button>
        </form>
    </div>
</body>

</html>