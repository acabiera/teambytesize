<?php
session_start();
	//if session is not set return to login
    if(!isset($_SESSION['valid'])){ 
        header("Location: login.php");
        exit();
    }

	//Set flag so database info doesn't update on first load
	$firstLoad = true;

	//Store the product name as it appears in the database
	if(isset($_GET["product"]))
	{
		$product = strtolower($_GET["product"]);
	}

	//Attempt database connection
	try {
		$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');
	}
	 catch(Exception $e)
    {
            echo 'Message: ' .$e->getMessage();
    }

	//Query to return all commodity info from corresponding product
	$productQuery = "select composition.commodity, commodities.price, commodities.unit, composition.unit_weight from composition, commodities where composition.commodity = commodities.name and composition.product = '".$product."'";

	//Run product query
	$result = pg_query($productQuery);

	//Store query results into array
	$commodityArr = pg_fetch_all($result);

	//Free memory
	pg_free_result($result);

	if(isset($_POST["deleteproduct"]))
	{

		//Delete product from database when delete button pressed
		$compositionDelete = pg_query($db_connect, "DELETE FROM composition WHERE product='".$product."'");
		pg_free_result($compositionDelete);
		
		$productsDelete = pg_query($db_connect, "DELETE FROM products WHERE name='".$product."'");
		pg_free_result($productsDelete);

		//Delete from recent searches to avoid dead links
		$productsDelete = pg_query($db_connect, "DELETE FROM search_history WHERE search='".$product."'");
		pg_free_result($productsDelete);

		//Return to product search page
		header("Location: searchproduct.php");
		exit;

	}
	else if(isset($_POST["commodities"])){
		//Delete product info from the tables so it can be added back
		$compositionDelete = pg_query($db_connect, "DELETE FROM composition WHERE product='".$product."'");
		pg_free_result($compositionDelete);
		
		$productsDelete = pg_query($db_connect, "DELETE FROM products WHERE name='".$product."'");
		pg_free_result($productsDelete);

		//Create new product entry in products table
		$productsInsert = pg_query($db_connect, "INSERT INTO Products VALUES (uuid_generate_v4(), '{$product}')");
		
		//Free Memory from insertion
		pg_free_result($productsInsert);
			
		//Delete product info from product and composition tables  so it can be added back
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
			
			$insertValues = pg_query($db_connect, "INSERT INTO composition VALUES (uuid_generate_v4(), '{$product}','{$commodity}', '{$_POST["weights"][$i]}');");

			//Free memory
			pg_free_result($insertValues);
			$i++;
		}

		//Refresh to update page
		header("Refresh:0");

		//Alert user to completed product addition
		echo "<script type='text/javascript'>alert('product succesfully updated');</script>";
	}
?>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script language="javascript">
		var commodityCount = 0;

		//Adds a new commodity field to the form
		function addCommodity(name, price, unit, weight) {
			commodityCount++; //increment counter for new id

			//Add an input field for the commodity name
			var html = '<input value="'+name+'" type="text" class="form-control" name="commodities[]" style="width:25%;float:left;" placeholder="Commodity Name"required/>'

			//Add an input field for the commodity price
			html += '<input value="'+price+'" type="number" min="0" step="0.01" class="form-control" name="prices[]" style="width:20%;float:left; margin-left:1%;" placeholder="Price in USD"required/>';

			//Add an input field for the commodity unit
			html += '<input value="'+unit+'" type="text" class="form-control" name="units[]" style="width:20%;float:left; margin-left:1%;" placeholder="Weight Unit"required/>';

			//Add an input field for the commodity weight
			html += '<input value="'+weight+'" type="number" min="0" step="0.01" class="form-control" name="weights[]" style="width:20%;float:left; margin-left:1%;" placeholder="Weight"required/>';

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

		//Remove element from its parent node as long as not the last element
		function removeElement(element){
			if(element.parentNode.childElementCount > 2)
				element.parentNode.removeChild(element);
			else
				alert("A product is not allowed to have no commodities, please delete it instead.");
		}

		//Set flag to delete product from database
		function deleteProduct() {
			document.getElementById('hiddenDelete').value = true;
		}

		//Variable for storing commodities that aren't updated in commodity table
		var cUnchanged = "";
	</script>
</head>
<title>Edit Product</title>
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
		<div class="h1 card-title">Edit Item: 
			<?php 
				echo ucwords($product);
			?>
		</div>
		<form name="editProduct" action="editproduct.php?product=<?php echo $product ?>" autocomplete="off" method="POST" class="card-body">
			<div id="productDetails" class="form-group">
				<?php
					foreach($commodityArr as $commodity) {
						//This section encodes the field values to json and stores them in the input boxes for each commodity
						echo '	<script language="javascript">
									name = '.json_encode($commodity["commodity"]).';
									price = '.json_encode($commodity["price"]).';
									unit = '.json_encode($commodity["unit"]).';
									weight = '.json_encode($commodity["unit_weight"]).';
									addCommodity(name, price, unit, weight);
								</script>';
					}

					
					//Close Database connection
					pg_close($db_connect);
				?> 
			</div>
			<div id="buttonContainer">
				<button type="button" class="border btn btn-primary border-dark text-dark" onclick="addCommodity('','','','')">Add Commodity</button>
	  			<button type="submit" class="border btn btn-primary border-dark text-dark">Update</button>
			</div>
		</form>
		<form style="margin: 0; height: 0;" id="deleteForm" action="editproduct.php?product=<?php echo $product ?>" autocomplete="off" method="POST"">
			<script language="javascript">		
				//Add a simple confirmation before product deletion
				document.getElementById("deleteForm").onsubmit = function(){
		   			if (confirm('Are you sure you want to delete this product? This action can not be undone.'))
						return true;
					else
						return false;
				}
			</script>
			<input type="hidden" style="height: 0px; id="hiddenDelete" name="deleteproduct"/>
			<button style="position:absolute; top: 0; left: 0; margin: 1%;" type="submit" class="border btn btn-primary border-dark text-dark" onclick="deleteProduct()">Delete Product</button>
		</form>
	</div>
</center>
</body>
</html>

