<?php

session_start();

if (!isset($_SESSION['valid'])){
    header("Location: login.php");
    exit();
}

?>
<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title>Capstone Template (Should-Cost)</title>
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
<br></br>
<center>
	<body style='background-color:silver'>
		<div class="card bg-primary" style="width: 50rem;">
		<br/>
		<div class="h1 card-title">Add Commodity</div>
		<form name="newproduct" action="addproduct.php" autocomplete="off" method="POST" class="card-body">
			<div id="productDetails" class="form-group">
			<input type="text" class="form-control" name="commodity" style="width:50%;float:left;" placeholder="Commodity Name"required/>
			<input type="number" min="0" step="0.01" class="form-control" name="price" style="width:24%;float:left; margin-left:1%;" placeholder="Price in USD"required/>	
			<input type="text" class="form-control" name="unit" style="width:24%;float:left; margin-left:1%;" placeholder="Weight Unit"required/>
				<br>
	 		 </div>
			<br>
			<div id="buttonContainer">
	  			<button type="submit" class="border btn btn-primary border-dark text-dark">Submit</button>
			</div>
		</form>
		<?php
			//Confirm that a product name was given in form submission
			if(isset($_POST["productname"])) {
				$commodity = $_POST["commodity"];
				$price = $_POST["price"];
				$unit = $_POST["unit"];
				//Attempt database connection
				try{
	    			$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');
 					if($db_connect){
						//Perform query to see if product already exists
	   					$productReturn = pg_query($db_connect, "SELECT * FROM commodities WHERE LOWER(name) = LOWER('{$commodity}')");
						
						//If the product doesn't exist, create a new one
						if(pg_num_rows($productReturn) == 0) {

							//Create new product entry in products table
							$productsInsert = pg_query($db_connect, "INSERT INTO commodities VALUES (uuid_generate_v4(), '{$commodity}', '{$unit}', '{$price}')");
							
							//Free Memory from insertion
							pg_free_result($productsInsert);
					
							//Alert user to completed product addition
							echo "<script type='text/javascript'>alert('product succesfully added');</script>";
						}
						else {
							//Alert user to attempts to duplicate already existing product
							echo "<script type='text/javascript'>alert('product already exists');</script>";
						
							//Free memory from initial query
							pg_free_result($productReturn);
						}

						//Close database connection
						pg_close($db_connect);
					}
   				} 
				catch(Exception $e) {
        			echo 'Message: ' .$e->getMessage();
				}
			}
		?>
		</div>
	</body>
</center>
<script language="javascript">
	if(cUnchanged.length !== 0) {
		alert("The following commodity prices and weights were not changed as they already exist in the database:\n" + cUnchanged);
	}
</script>
</html>
