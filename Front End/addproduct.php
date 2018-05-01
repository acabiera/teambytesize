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
<title>Add Product</title>
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
		<div class="h1 card-title">Add Product</div>
		<form name="newproduct" action="addproduct.php" autocomplete="off" method="POST" class="card-body">
			<div id="productDetails" class="form-group">
	    		<input type="text" class="form-control" name="productname" placeholder="Enter Product Name" required/>
				<br>
				<script language="javascript">

					var commodityCount = 0;

					//Adds a new commodity field to the form
					function addCommodity() {
						commodityCount++; //increment counter for new id
						
						//Add an input field for the commodity name
						var html = '<input type="text" class="form-control" name="commodities[]" style="width:25%;float:left;" placeholder="Commodity Name"required/>'

						//Add an input field for the commodity price
						html += '<input type="number" min="0" step="0.01" class="form-control" name="prices[]" style="width:20%;float:left; margin-left:1%;" placeholder="Price in USD"required/>';

						//Add an input field for the commodity unit
						html += '<input type="text" class="form-control" name="units[]" style="width:20%;float:left; margin-left:1%;" placeholder="Weight Unit"required/>';

						//Add an input field for the commodity weight
						html += '<input type="number" min="0" step="0.01" class="form-control" name="weights[]" style="width:20%;float:left; margin-left:1%;" placeholder="Weight"required/>';
			
						//Add a button to remove the commodity info 
						html += '<button type="button" class="border btn btn-primary border-dark text-dark" onclick="removeElement(this.parentNode)" style="float:right">Remove</button>'

						//Add a div to create space below each new commodity 
						html += '<div style="clear:both;"><br></div>';
						
						addElement("productDetails", "div", "commodity-" + commodityCount, html);
                    }

					//function to add a new html element
					function addElement(parent, tag, id, html) {
						var setParent = document.getElementById(parent);
						var newElement = document.createElement(tag);
						newElement.setAttribute("id", id);
						newElement.innerHTML = html;
						setParent.appendChild(newElement);
					}

					//Remove element from its parent node
					function removeElement(element){
						element.parentNode.removeChild(element);
					}

					//Variable for storing commodities that aren't updated in commodity table
					var cUnchanged = "";
				</script>
	 		 </div>
			<div id="buttonContainer">
				<button type="button" class="border btn btn-primary border-dark text-dark" onclick="addCommodity()">Add Commodity</button>
	  			<button type="submit" class="border btn btn-primary border-dark text-dark">Submit</button>
			</div>
		</form>
		<?php
			//Confirm that a product name was given in form submission
			if(isset($_POST["productname"])) {
				$name = strtolower($_POST["productname"]);
				//Attempt database connection
				try{
	    			$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');
 					if($db_connect){
						//Perform query to see if product already exists
	   					$productReturn = pg_query($db_connect, "SELECT * FROM Products WHERE LOWER(name) = LOWER('{$name}')");
						
						//If the product doesn't exist, create a new one
						if(pg_num_rows($productReturn) == 0) {

							//Create new product entry in products table
							$productsInsert = pg_query($db_connect, "INSERT INTO Products VALUES (uuid_generate_v4(), '{$name}')");
							
							//Free Memory from insertion
							pg_free_result($productsInsert);
					
							//Confirm that a commodity name was given in form submission
							if(isset($_POST["commodities"])){
								
								$i = 0;	
								//Insert commodity values into composition
								foreach($_POST["commodities"] as $commodity){
									
									$commodityReturn = pg_query($db_connect, "SELECT * FROM commodities WHERE LOWER(name) = LOWER('{$commodity}')");
									if(pg_num_rows($commodityReturn) == 0){
										$insertCommodity = pg_query($db_connect, "INSERT INTO commodities VALUES (uuid_generate_v4(), '{$commodity}','{$_POST["units"][$i]}', '{$_POST["prices"][$i]}');");

									//Free memory
									pg_free_result($insertCommodity);
									}
									else {
										//Store unchanged commodites in string variable
										echo "<script language='javascript'> cUnchanged+= ' ' + " . json_encode($commodity) . "; </script>";
									}
									
									$insertValues = pg_query($db_connect, "INSERT INTO composition VALUES (uuid_generate_v4(), '{$name}','{$commodity}', '{$_POST["weights"][$i]}');");

									//Free memory
									pg_free_result($insertValues);
									$i++;
								}
							}
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


