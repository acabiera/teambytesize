<?php
    session_start();
    if(!isset($_SESSION['valid'])){ //if session is not set return to login
        header("Location: login.php");
        exit();
    }

	$GLOBAL['highlight'] = false;
	include('var.php');
	if(!isset($_GET['product'])){
				//return user to home page when there is no product parameter
                header("Location: searchproduct.php");
                exit();

//echo "<meta http-equiv='refresh' content='0;URL=searchproduct.php' />";
        }
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<!-- Script for Charts using jscanvas -->



<title>Capstone Template (Should-Cost)</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<?php
	echo $_SESSION['username'];
?>

<body style='background-color:silver'>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
     <ul class="navbar-nav">

<!-- Dropdown Products -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Products
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="searchproduct.php">Product Search</a>
          <a class="dropdown-item" href="addproduct.php">Add Product</a>
        </div>
      </li>

<!-- Dropdown Commodities -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Commodities
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="searchcommodity.php">Commodity Search</a>
          <a class="dropdown-item" href="addcommodity.php">Add Commodity</a>
        </div>
      </li>

<!-- Hyperlinks -->
      <a class="nav-item nav-link text-white" href="recentsearches.php">Recent Searches</a>
     <a class="nav-item nav-link text-white" href="logout.php">Logout</a>
    </ul>
    </div>
  </div>
</nav>
<br></br>
<center>
<div class="card bg-primary" style="width: 50rem;">
<br>
<div class="h1 card-title">Item: <?php echo ucwords(str_ireplace('_', ' ', $_GET["product"]));?></div>

<br> 

<!DOCTYPE html>
<!-- <html>
<head> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        *{
                box-sizing: border-box;
        }

        /* Create three equal columns that floats next to each other */
        .column
        {
                float: left;
                width: 33.33%;
                padding: 10px;
              /*  height: 300px; Should be removed. Only for demonstration */ -->
        }

        /* Clear floats after the columns */
        .row:after
        {
                content: "";
                display: table;
                clear: both;
        }

        .checkmark {
                position: absolute;
                top: 200;
                left: 0;
                height: 15px;
                width: 15px;
                }	
        </style>

<?php
	 try
                        {
                                $db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

                        }

                        catch(Exception $e)
                        {
                                echo 'Message: ' .$e->getMessage();
                        }
?>
<!-- -----------Delete------------- -->
        <label class="container">
        <input type="checkbox"
        <span class="checkmark"></span>
        </label>

<!-- -----------Materials------------- -->
<div class='card-deck' style='width: 95%'>
        <div class="card" style="background-color:silver;">
                <h2>Materials</h2>
      		<?php
			$result = pg_query("SELECT commodity FROM composition WHERE product = '" . $_GET["product"] . "' ORDER BY commodity;");
			
        		while ($row = pg_fetch_array($result))
        		{
				if(!contains($row[0]))
				{
					echo "<font style='background-color:red'>".$row[0]."</font>";
                			$GLOBAL['highlight'] = true;
				}
				else
				{	
					echo $row[0]."</br>";
				}
			}
		?>
                </div>

<!-- -----------Price------------- -->
	<div class="card" style="background-color:silver;">
                <h2>Price</h2>
                <?php
			$priceName = pg_query("SELECT commodities.price, commodities.name FROM commodities, composition WHERE composition.product = '" . $_GET["product"] . "' and commodities.name = composition.commodity ORDER BY commodities.name;");
			$unit = pg_query("SELECT commodities.unit FROM commodities, composition WHERE composition.product = '" . $_GET["product"] . "' and commodities.name = composition.commodity ORDER BY commodities.name;");
			$arrayNames = [];
			$arrayUnit = [];
			$chartData = [];
                        while (($row = pg_fetch_array($priceName)) && ($row2 = pg_fetch_array($unit)))
                        {
                                if(!contains($row[1]))
				{
					echo "<font style='background-color:red'>$".round($row[0], 2)."/".$row2[0]."</font>";
				}
				else
				{

					echo "$".round($row[0], 2)."/".$row2[0]."</br>";
					array_push($arrayNames, [$row[1]]);
       				}
			}
                ?>
                </div>

<!-- -----------Weight------------- -->
        <div class="card" style="background-color:silver;">
                <h2>Weight</h2>
                <?php
                        $weight = pg_query("SELECT unit_weight, commodity FROM composition WHERE product = '" . $_GET["product"] . "' ORDER BY commodity;");

                        while ($row = pg_fetch_array($weight))
                        {
				if(!contains($row[1])){
					echo "<font style='background-color:red'>".round($row[0], 2)."</font>";
				}
				else{
                                	echo round($row[0], 2)."</br>";
                        	}
			}
                ?>

                </div>

<!-- -----------Unit Price------------- -->
	<div class="card" style="background-color:silver;">
                <h2>Unit Price</h2>
                <?php
                        $weight = pg_query("SELECT unit_weight, commodity FROM composition WHERE product = '" . $_GET["product"] . "' ORDER BY composition.commodity;");
			$price = pg_query("SELECT commodities.price FROM commodities, composition WHERE composition.product = '" . $_GET["product"] . "' and commodities.name = composition.commodity ORDER BY composition.commodity;");
			//Declaring array for the data for the chart
			$chartdata=[];
			$sum = 0;
                        while (($row = pg_fetch_array($weight)) && ($row2 = pg_fetch_array($price)))
			{
                                if(!contains($row[1])){
                                        echo "<font style='background-color:red'>".round($row[0]*$row2[0], 2)."</font>";
				}
                                else{
					echo round($row[0]*$row2[0], 2)."</br>";
					$sum += $row[0]*$row2[0];
                                        array_push($arrayUnit, round($row[0]*$row2[0],2));
                                }
                        }
              	 ?>
                </div>
</div>
<br>

<!-- -----------Total------------- -->
        <h2>Total</h2>
	<?php
		echo "<div>";
		if($sum == 0 and $GLOBAL['highlight']){
			echo "None of the commodities are known";
		}
		else{ 
			echo "$".round($sum, 2);
			if($GLOBAL['highlight']){
				echo " (excluding highlighted materials)</div>";
			}
			else{
				echo "</div>";
			}
		}
                pg_close($db_connect);

/* Assigning the pairs of names and prices to the chart - product/total, then commodities/(price/total)*/
//               var_dump ($arrayNames);
//		echo "<br>";
//		var_dump($arrayUnit);
		 array_push($chartdata, [$_GET['product'],round($sum, 2)]);
                for($i=0; $i<count($arrayNames); $i++){
			array_push($chartdata, [$arrayNames[$i][0],round($arrayUnit[$i]/round($sum, 2),5)]);
		}
		//var_dump($chartdata);

		$jsonChart = json_encode($chartdata);
                echo $jsonChart;

	?>
<br>
</div>
</body>
</html>

