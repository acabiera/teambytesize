<?php
	if(!isset($_GET['product'])){
                echo "<meta http-equiv='refresh' content='0;URL=product.php' />";
        }
?>
<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Capstone Template (Should-Cost)</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">

<?php
	if(isset($_COOKIE['SCServiceUser'])) 
	{
	   echo $_COOKIE['SCServiceUser'];
	}
	else 
	{
    		echo 'User Name';
	}
?>

<body style='background-color:silver'>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="recentsearches.php">Recent Searches</a>
      <a class="nav-item nav-link" href="addproduct.php">Add Product</a>
      <a class="nav-item nav-link" href="product.php">Products</a>
     <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
<br></br>
<center>
<div class="card bg-primary" style="width: 50rem;">
<br>
<div class="h1 card-title">Item: <?php echo $_GET["product"];?></div>

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
                height: 300px; /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after
        {
                content: "";
                display: table;
                clear: both;
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

<div class='card-deck' style='width: 95%'>
        <div class="card" style="background-color:silver;">
                <h2>Materials</h2>
      		<?php
			$result = pg_query("SELECT materialstable FROM products WHERE name = '" . $_GET["product"] . "';");
			$materialtable = pg_fetch_array($result);

			$result = pg_query("SELECT name FROM " . $materialtable[0] . ";");

        		while ($row = pg_fetch_array($result))
        		{
                		echo $row[0]."</br>";
        		}
		?>
                </div>
	<div class="card" style="background-color:silver;">
                <h2>Price</h2>
                $/lb<br>
                $/mt<br>
                $/lb<br>
                $/lb<br>
                </div>
        <div class="card" style="background-color:silver;">
                <h2>Weight</h2>
                <?php
                        $result = pg_query("SELECT unitweight FROM " . $materialtable[0] . ";");

                        while ($row = pg_fetch_array($result))
                        {
                                echo $row[0]."</br>";
                        }
                ?>

                </div>
	<div class="card" style="background-color:silver;">
                <h2>Unit Price</h2>
                3483.37<br>
                2397.39<br>
                3638.28<br>
                3823.38<br>
                </div>
</div>
<br>
        <h2>Total</h2>
	<?php
		$total = pg_query("SELECT SUM(unitprice) FROM mtire;");

                 while ($row = pg_fetch_array($total))
                 {
	                 echo $row[0]."</br>";
                 }

                 pg_close($db_connect);

	?>
<br>
</div>
</body>
</html>

