<?php

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

//Set flag to disable following link from counting as searches
$_SESSION['issearch'] = false;

$results = false;

if (!(isset($_SESSION['valid']))){
    header("Location: login.php");
}

try{
    //Attempt Database connection
	$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

 	if($db_connect){
		//Run query to return search information
		$searchReturn = pg_query($db_connect, "SELECT search, search_time, type FROM search_history WHERE username = '{$_SESSION['username']}' ORDER BY search_time DESC LIMIT 5");

		//Store array of query values
		$searchHistory = pg_fetch_all($searchReturn);
		
		//Free memory
		pg_free_result($searchReturn);
	}
    
} 
catch (Exception $e){
    echo $e->getMessage();
}
?>

<html>
<body style='background-color:silver'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title>Recent Searches</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">

<?php
echo $_SESSION['username'];
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

<div class="card bg-primary" style="width: 50rem;">
<br>
<div class="h1 card-title">Recent Searches</div>
<p>These are your last five searches:</p>
<div id="headerContainer" style="width:70%; margin:auto;">
	
<!-- Search Time -->
       <div class="card" style="background-color:silver; width:30%; margin-left:3%; margin-right: 2%; float:left;">
		<h3>Search Time</h3>
		<?php 
			if(!empty($searchHistory)) {			
				//Print out search times
				foreach($searchHistory as $time) {
					echo date("n/j, g:i a", strtotime($time["search_time"]));				
					echo "<br>";
				} 	
			}
			else {
				echo "no data";
			}		
		?>
	</div>

<!-- Type -->
        <div class="card" style="background-color:silver; width:30%; float:left;">
                <h3>Type</h3>
                <?php
                        if(!empty($searchHistory)) {
                                //Print out item names as links
                                foreach($searchHistory as $type) {
                                        echo $type['type'];
                                        echo "<br>";
                                }
                        }
                        else {
                                echo "no data";
                        }
                ?>
        </div>

<!-- Searched -->
	<div class="card" style="background-color:silver; width:30%; margin-left: 2%; margin-right:3%; float:left;">
		<h3>Searched</h3>
		<?php 
			if(!empty($searchHistory)) {
				//Print out item names as links
				foreach($searchHistory as $name) {
					$param = str_replace(' ', '%20', $name['search']); //Had to encode spaces here to allow passing to url
					//Set separate links for product and commodity types
					if($name['type'] == 'product') {
						$link = "materials.php?product={$param}";
					}
					else
					{
						$link = "commodityInfo.php?commoditysearch={$param}";
					}
					echo "<a style='width:fit-content' href = $link>{$name['search']}</a>";
				} 
			}
			else {
				echo "no data";
			}
		?>
	</div>


</div>
<br>
</center>
</body>
</html>


