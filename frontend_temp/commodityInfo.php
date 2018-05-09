<?php

session_start();

if (!isset($_SESSION['valid'])){
    header("Location: login.php");
    exit();
}

?>
<html>
<body>
<script>
function preventNumberInput(e){
    var keyCode = (e.keyCode ? e.keyCode : e.which);
    if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107 ){
        e.preventDefault();
    }
}

$(document).ready(function(){
    $('#text_field').keypress(function(e) {
        preventNumberInput(e);
    });
})
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title>Commodity Information</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<?php
echo $_SESSION['username'];

        //Query database and store product names in an array
        $db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

        //Continue if connection established    
        if($db_connect){
                //Return product query results
				$commodity = $_GET['commoditysearch'];
                $priceQuery = pg_query($db_connect, "SELECT price, unit FROM commodities WHERE name = '$commodity';");

				if (pg_num_rows($priceQuery) == 0) {
				$_SESSION['noterm']=true;
                                $_SESSION['incorrectterm'] = $term;
				header("Location: searchcommodity.php");
				exit();
                        }
			else if (isset($_SESSION['issearch']) && $_SESSION['issearch']) {
				$addRecent = pg_query("INSERT INTO search_history VALUES (uuid_generate_v4(), '"  .  $_SESSION["username"] . "', '" . $commodity . "','commodity', now());"); 
				pg_free_result($addRecent);

				//Reset valid search flag to prevent duplicate insertions
				$_SESSION['issearch'] = false;
			}

                //Store query results in array
                $price = pg_fetch_array($priceQuery);

                //Free memory
                pg_free_result($priceQuery);
        }
?>



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
<br>
<center>
	<body style='background-color:silver'>
		<div class="card bg-primary" style="width: 50rem;">        	
		   	<br>
			<!--display edit button inline with the header-->
			<div style="position:relative;">
				<h1 style="display:inline; width:fit-content;">Commodity: 
					<?php 
						echo ucwords($commodity); 
					?>
				</h1>
				<?php
					//Create edit button to send user to editcommodity page
					//echo '<a class="text-dark" style="position:absolute; margin-left: 1%; bottom: 2; display:inline; width:fit-content;href="editcommodity.php?commodity='.$commodity.'">Edit</a>';
				?>
			</div>
			<br>
			<div class="card" style="background-color: silver; width: 90%; margin:auto; font-size: 20px;">
				<h3>Market Price</h3> 
				<?php 
					//If a price is available, print it to the screen
					if(!empty($price[0]))
					{
						echo "$".$price[0].'/'.$price[1];
					}
					else 
					{
						echo "Pricing Unavailable";
					}
				?>
			</div>  
			<br>
			<div class="card" style="background-color: silver; width: 90%; margin:auto; font-size: 20px;">
				<h3>Product's Using This Commodity</h3>
				<?php
					//Return products that contain the given commodity
		    		$result = pg_query("SELECT product FROM composition WHERE commodity = '" .  $commodity . "' ORDER BY commodity;");

					//Print product names
					$row = pg_fetch_all($result);
					if(!empty($row))
					{
						foreach($row as $prodName)
						{
							$print = $prodName['product'];
							echo "<a style='width:fit-content' href='materials.php?product={$print}'>$print</a>";
						}
					}
					else
					{
						echo "This commodity has no products";
					}
				?>
		 	
			</div>
			<br>
		</div>
	</body>
</center>
</html>
