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

<div class="h1 card-title">Item: Tire</div>

<br> 

<!DOCTYPE html>
<html>
<head>
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
</head>
<body>

<div class="row">
        <div class="column" style="background-color:#fff;">
                <h2>Materials</h2>
      		<?php
		        //Attempt database connection
        		try
        		{
                		$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

        		}

        		catch(Exception $e)
        		{
                		echo 'Message: ' .$e->getMessage();
        		}

        		$result = pg_query("SELECT name FROM mtire;");

        		while ($row = pg_fetch_array($result))
        		{
                		echo $row[0]."</br>";
        		}

        		pg_close($db_connect);

		?>
                </div>
        <div class="column" style="background-color:#fff;">
                <h2>Price/Unit</h2>
                <p>Some text..</p>
                </div>
        <div class="column" style="background-color:#fff;">
                <h2>Weight</h2>
                <?php
               		//Attempt database connection
                	try
                      	{
                        	$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

                        }

                        catch(Exception $e)
                        {
                                echo 'Message: ' .$e->getMessage();
                        }

                        $result = pg_query("SELECT unitweight FROM mtire;");

                        while ($row = pg_fetch_array($result))
                        {
                                echo $row[0]."</br>";
                        }

                        pg_close($db_connect);

                ?>

                </div>
</div>

        <h2>Total</h2>
	<?php

	        //Attempt database connection
                try
                {
        	        $db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');
                }

                catch(Exception $e)
                {
                	echo 'Message: ' .$e->getMessage();
            	}

		$total = pg_query("SELECT SUM(unitprice) FROM mtire;");
		
		while ($total2 = pg_fetch_array($total))
		{
			echo $total2[0]."</br>";
		}
        	pg_close($db_connect);

	?>


</body>
</html>


</div>
</center>

</body>
</html>
