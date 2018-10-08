<?php

//editproduct.php


//9-14-18: I know for a fact I'm going to need to rework some of the SQL queries for the new table designs. 
//But the PDO logic is there and that'll make this much easier

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();
	//if session is not set return to login
    if(!isset($_SESSION['valid'])){ 
        header("Location: login.php");
        exit();
    }

    //Set flag so database info doesn't update on first load
    $firstLoad = true;

    //Set $product to an empty string if there isn't one

    $product="";

    //Store the product name as it appears in the database
    if(isset($_GET["product"])){
        $product = strtolower($_GET["product"]);
    }

    //Attempt database connection
    try {
        $pdo = Connect::get()->connect(); 

//fetch product query
//this statement works in the postgres shell

    $productQuery=$pdo->prepare("SELECT commodities.name, commodities.price, commodities.unit, composition.unit_weight FROM commodities, composition WHERE composition.commodityid=commodities.idcomm AND composition.productid=(SELECT products.idpro FROM products WHERE products.name=:product)");
    $productQuery->execute([':product'=>$product]);
//save in array
    $commodityArr=$productQuery->fetchAll(PDO::FETCH_ASSOC);
//free query memory
    $productQuery=null;
    //I need logic if this comes back null

    if(isset($_POST["deleteproduct"])){

        //Delete product from database when delete button pressed
        $compositionDelete = $pdo->prepare('DELETE FROM composition WHERE productid=(SELECT idpro FROM products where name=:prod');
        $compositionDelete->execute([':prod'=>$product]);
        $compositionDelete=null;
	
        $productsDelete=$pdo->prepare('DELETE FROM products WHERE name=:prod');
        $productDelete->execute([':prod'=>$product]);
        $productDelete=null;

        //Delete from recent searches to avoid dead links
        $historyDelete=$pdo->prepare('DELETE FROM search_history WHERE searchterm=:product');
        $historyDelete->execute([':product'=>$product]);
        $historyDelete=null;

        //Return to product search page
        header("Location: searchproduct.php");
        exit;
        }
    else if(isset($_POST["commodities"])){
        
        //Delete product info from the tables so it can be added back
        $compositionDelete = $pdo->prepare('DELETE FROM composition WHERE productid=(SELECT idpro FROM products where name=:prod');
        $compositionDelete->execute([':prod'=>$product]);
        $compositionDelete=null;
		
        $productsDelete=$pdo->prepare('DELETE FROM products WHERE name=:prod');
        $productDelete->execute([':prod'=>$product]);
        $productDelete=null;

        //Create new product entry in products table
        $productsInsert=$pdo->prepare('INSERT INTO products (name) VALUES (:prod)');
        $productsInsert->execute([':prod'=>$product]);
        $productsInsert=null;
			
        $i = 0;	
       
        //Insert commodity values into composition
        $commodityArr=$_POST["commodities"];
        //foreach($_POST["commodities"] as $commodity){
	//uncomment above if it fails
        foreach($commodityArr as $commodity){
        
            //Check to see if commodity exists
            $commodityReturn=$pdo->prepare('SELECT * FROM commodities WHERE LOWER(name) = LOWER(:commodity)');
            $commodityReturn->execute([':commodity'=>$commodity]);
            $commodityResults=$commodityReturn->fetchAll(PDO::FETCH_ASSOC);
            $commodityReturn=null;

            if(!$commodityReturn){
                
                //if nothing is returned, insert commodity into table
                
                $insertCommodity=$pdo->prepare("INSERT INTO commodities (name, unit, price) VALUES (:comm, :unit, :price))");
                $insertCommodity->execute([':comm'=>$commodity, ':unit'=>$_POST["units"][i], ':price'=> $_POST["prices"][$i]]);

                //Free memory
                $insertCommodity=null;
            }

            else {
                //Store unchanged commodites in string variable
		
                echo "<script language='javascript'> cUnchanged+= ' ' + " . json_encode($commodity) . "; </script>";
            }
			
            $insertValues = $pdo->prepare("INSERT INTO composition (unit_weight, productid, commodityid) VALUES (:weight, (SELECT idpro FROM products WHERE name=:product), (SELECT idpcomm FROM commodities WHERE name=:comm))");
            $insertValues->execute([':weight'=>$_POST["weights"][$i], ':product'=>$product, ':comm'=>$commodity]);
            //Free memory
            $insertValues=null;
            //increment counter
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
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script language="javascript">
            var commodityCount = 0;

            //Adds a new commodity field to the form
            function addCommodity(name, price, unit, weight) {
                commodityCount++; //increment counter for new id

                //Add an input field for the commodity name
                var html = '<input value="'+name+'" type="text" name="commodities[]" placeholder="Commodity Name"required/>'

                //Add an input field for the commodity price
                html += '<input value="'+price+'" type="number" min="0" step="0.01" name="prices[]" placeholder="Price in USD"required/>';

                //Add an input field for the commodity unit
                html += '<input value="'+unit+'" type="text" name="units[]" placeholder="Weight Unit"required/>';

                //Add an input field for the commodity weight
                html += '<input value="'+weight+'" type="number" min="0" step="0.01" name="weights[]" placeholder="Weight"required/>';

                //Add a button to remove the commodity info 
                html += '<button type="button" onclick="removeElement(this.parentNode)">Remove</button>'

                //Add a div to create space below each new commodity 
                html += '<div class="noborder"<br></div>';
	
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
        <title>Should-Cost: Edit Product</title>
        </head>
        <body>
            <div class="sidebar">
<?php
    echo $_SESSION['username'];
    include 'sidebar.php';
?>
            </div>

<br>

<div class="main">
    <h1>Edit Product</h1>
<?php
    if ($product==""){
        echo "Please enter a valid product to edit.";
        //Eventually will add a form.
    }
?>
    <div class="noborder">
<br>        Editing information for:   
<?php 
    echo ucwords($product);
?>
    <br>

    <form name="editProduct" action="editproduct.php?product=<?php echo $product ?>" autocomplete="off" method="POST">
        <div id="productDetails">
<?php
    foreach($commodityArr as $commodity) {
        //This section encodes the field values to json and stores them in the input boxes for each commodity
        echo '<script language="javascript">
        name = '.json_encode($commodity["name"]).';
        price = '.json_encode($commodity["price"]).';
        unit = '.json_encode($commodity["unit"]).';
        weight = '.json_encode($commodity["unit_weight"]).';
        addCommodity(name, price, unit, weight);
        </script>';
    }

    //Close Database connection
    $pdo=null;
    }catch(Exception $e){
        echo 'Message: ' .$e->getMessage();
    }
?> 
        </div>
        <div class="noborder">
            <button type="button" onclick="addCommodity('','','','')">Add Commodity</button>
            <button type="submit">Update</button>
        </div>
    </form>
    <!-- Delete Form -->
    <form style="margin: 0; height: 0;" id="deleteForm" action="editproduct.php?product=<?php echo $product ?>" autocomplete="off" method="POST">
        <script language="javascript">
        //Add a simple confirmation before product deletion
        document.getElementById("deleteForm").onsubmit = function(){
            if (confirm('Are you sure you want to delete this product? This action can not be undone.'))
                return true;
            else
                return false;
        }
        </script>
    <input type="hidden" id="hiddenDelete" name="deleteproduct"/>
        <button type="submit" onclick="deleteProduct()">Delete Product</button>
    </form>
</div>
</center>
</body>
</html>

