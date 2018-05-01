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
<title>Edit Commodity</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">

<?php
	echo $_SESSION['username'];

    //Query database and store product names in an array
    $db_connect = pg_connect('host=localhost dbname=scservice user=scservice password=Uark1234');

    //Continue if connection established
    if($db_connect)
	{
		//Return product query results
  	    $commodity = $_GET['commodity'];
		$priceQuery = pg_query($db_connect, "SELECT price, unit FROM commodities WHERE name = '$commodity';");

		//Store query results in array
     	$price = pg_fetch_array($priceQuery);

       	pg_free_result($priceQuery);
   	}

 if(isset($_POST["deletecommodity"]))
        {

        echo "hello"; 
	       //Delete commodity from database when delete button pressed
                $compositionDelete = pg_query($db_connect, "DELETE FROM composition WHERE commodity='".$commodity."'");
                pg_free_result($compositionDelete);
                
                $commoditiesDelete = pg_query($db_connect, "DELETE FROM commodities WHERE name='".$commodity."'");
                pg_free_result($commoditiesDelete);

                //Delete from recent searches to avoid dead links
                $searchDelete = pg_query($db_connect, "DELETE FROM search_history WHERE search='".$commodity."'");
                pg_free_result($searchDelete);

                //Return to commodity search page
                header("Location: searchcommodity.php");
                exit;
        }

else if(isset($_POST["commodities"])){
                //Delete commodity info from the tables so it can be added back
                $compositionDelete = pg_query($db_connect, "DELETE FROM composition WHERE commodity='".$commodity."'");
                pg_free_result($compositionDelete);
                
                $commoditiesDelete = pg_query($db_connect, "DELETE FROM commodities WHERE name='".$commodity."'");
                pg_free_result($commoditiesDelete);

		//Delete commodity info from commodity and composition tables  so it can be added back
                $i = 0;

                //Create new commodity entry in products table
                $commodityInsert = pg_query($db_connect, "INSERT INTO commodities VALUES (uuid_generate_v4(), '{$commodity}', '{$_POST["units"][$i]}', '{$_POST["prices"][$i]}');");
		pg_free_result($commodityInsert);
		
		$i++;              

		//Refresh to update page
                header("Refresh:0");

                //Alert user to completed product addition
                echo "<script type='text/javascript'>alert('commodity succesfully updated');</script>";
  
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
<br></br>
	<script language="javascript">
	var commodityCount = 0;

                //Adds a new commodity field to the form
                function addCommodity(price, unit) {
                        commodityCount++; //increment counter for new id

                        //Add an input field for the commodity name
                        var html = '<input value="'+unit+'" type="text" class="form-control" name="units[]" style="width:20%;float:left; margin-left:1%;"  placeholder="Weight Unit"required/>';

                        //Add an input field for the commodity price
                        html += '<input value="'+price+'" type="number" min="0" step="0.01" class="form-control" name="prices[]" style="width:20%;float:left; margin-left:1%;" placeholder="Price in USD"required/>';

			//Add a button to remove the commodity info 
                        html += '<button type="button" class="border btn btn-primary border-dark text-dark" onclick="removeElement(this.parentNode)" style="float:right">Remove</button>';

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
                                element.parentNode.removeChild(element);                        
                 }

                //Set flag to delete product from database
                function deleteCommodity() {
                        document.getElementById('hiddenDelete').value = true;
                }

		//Variable for storing commodities that aren't updated in commodity table
                var cUnchanged = "";


		function insertItem(a,b){
		var updating = ("UPDATE commodities SET price = " a ",unit = " b "WHERE name ="<?php $commodity ?>";");
		dbname.Execute(updating,a,b);
		}
	</script>

  <center>		
		<body style='background-color:silver'>
                <div class="card bg-primary" style="width: 50rem;">             
                        <br>
                        <!--display edit button inline with the header-->
                                <div class="h1 card-title">Edit Commodity: 
                                        <?php 
                                                echo ucwords($commodity); 
                                        ?>
                                </div>
                       
                        <br>
                        <div class="card" style="background-color: silver; width: 90%; font-size: 20px;">
                                <h3>Market Price</h3>
 
                
                                <?php
                              		 //If a price is available, print it to the screen
                                        if(!empty($price[0]))
                                        {?>
                                                
						<form action = insertItem(price,unit)>
						$ <input type="text" name="price" size="7"value="<?php echo $price[0]; ?>">	
                                   		/ <input type="txt"  name="unit"  size="3" value="<?php echo $price[1]; ?>">
						<input type="submit" value="Submit">
						</form>
					<?php   
					  }
                                        else 
                                        {
                                                echo "Pricing Unavailable";
                                        }

                                ?>
                        </div>  
                        <br>
                        <div class="card" style="background-color: silver; width: 90%; font-size: 20px;">
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
							echo $print;
					?>
                                             
						<input type ="checkbox" name="deletecommodity" value=""<?php $print ?>"/>
						
					<?php	
						}
					?>
							<input type ="submit" name="deletecommodity"  value= "Delete" style=" width: 100px"/>		
                                    <?php
			                }
                                        else
                                        {
                                                echo "This commodity has no products";
                                        }

                                ?>
				<br>

			
                                  <?php      pg_close($db_connect);

				?>
	
				</div>

				<br>
				<div id="buttonContainer" href="commodityInfo.php?commodity=<?php $commodity ?>"
				<button type="submit" class="border btn btn-primary border-dark text-dark" style="width 100px" >Update</button>
                        
				</div>
				<br>
			</div>
                <form style="margin: 0; height: 0;" id="deleteForm" action="editcommodity.php?commodity=<?php echo $commodity ?>" autocomplete="off" method="POST"">
                        <input type="hidden" style="height: 0px; id="hiddenDelete" name="deletecommodity"/>
                        <button style="position:absolute; top: 0; left: 70; margin: 11%;" type="submit" class="border btn btn-primary border-dark text-dark" onclick="deleteCommodity()">Delete Commodity</button>
                </form>        
</body>
</center>
</html>

