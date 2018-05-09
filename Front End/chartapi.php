<!-- Script for Charts using jscanvas -->

<?php
session_start();


$obj=($_SESSION['chartdata']);

?>
<html>
    <head>
       <script type="text/javascript" src="canvasjs.min.js">
       
      
         window.onload = function() {
     
         var datapoints ="<?php print $obj; ?>";

     
         var chart = new CanvasJS.Chart("chartContainer", {
        	animationEnabled: false,
        	theme: "light2",
                zoomEnabled: false,
        	title: {
                    text: "Price Breakdown"
    	        },
    	        axisY: {
    		    title: "Price in USD",
    		    titleFontSize: 24,
    		    prefix: "$"
    	        },
         	data: [{
    		    type: "line",
                    dataPoints: datapoints
          	}]
          });
 

    	chart.render();
    }
     

     

    </script>
    </head>
    <body>
        <div id="chartContainer" style="height:300px; width: 100%;"></div>
        <script src="canvasjs.min.js"></script>
        <p>Text</p>
    </body>
</html>
