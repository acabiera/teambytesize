<html>
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


  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="recentsearches.php">Recent Searches</a>
      <a class="nav-item nav-link" href="addproduct.php">Add Product</a>
      <a class="nav-item nav-link" href="product.php">Product</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
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
						var html = '<input type="text" class="form-control" name="commodities[]" style="width:87%;float:left" placeholder="Add a Commodity"required/>' + '<button type="button" class="border btn btn-primary border-dark text-dark" onclick="removeElement(this.parentNode)" style="float:right">Remove</button>' + '<div style="clear:both;"><br></div>';
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
				</script>
	 		 </div>
			<div id="buttonContainer">
				<button type="button" class="border btn btn-primary border-dark text-dark" onclick="addCommodity()">Add Commodity</button>
	  			<button type="submit" class="border btn btn-primary border-dark text-dark">Submit</button>
			</div>
		</form>
		<br> 
		<?php
			//Confirm that a product name was given in form submission
			if(isset($_POST["productname"])) {
				$name = $_POST["productname"];
				//Attempt database connection
				try{
	    			$db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');
 					if($db_connect){
						//Perform query to see if product already exists
	   					$productReturn = pg_query($db_connect, "SELECT * FROM Products WHERE LOWER(name) = LOWER('{$name}')");
						
						//If the product doesn't exist, create a new one
						if(pg_num_rows($productReturn) == 0) {

							//Return the count of the rows to get next lookup code
							$productCount = pg_query($db_connect, "SELECT COUNT(*) FROM Products;");
							
							//Store result in count variable
							$row = pg_fetch_row($productCount, 0);
							$count = $row[0] + 1;

							//Free memory from count
							pg_free_result($productCount);

							//Create new product entry in products table
							$productsInsert = pg_query($db_connect, "INSERT INTO Products VALUES (uuid_generate_v4(), 'lookupcode{$count}', '{$name}', 'm{$name}')");
							
							//Free Memory from insertion
							pg_free_result($productsInsert);

							//Create new table for the product
							$createTable = pg_query($db_connect, "CREATE TABLE m{$name} (id uuid NOT NULL, name varchar(100) NOT NULL, unitprice double precision, unitweight double precision);");
						
							//Free memory from table creation
							pg_free_result($createTable);
					
							//Confirm that a commodity name was given in form submission
							if(isset($_POST["commodities"])){

								//Insert commodity values into new table
								foreach($_POST["commodities"] as $commodity){
									$insertValues = pg_query($db_connect, "INSERT INTO m{$name} VALUES (uuid_generate_v4(), '{$commodity}', 10.0, 10.0);");

									//Free memory
									pg_free_result($insertValues);
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
</html>


