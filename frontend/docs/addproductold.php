<?php
//addproduct.php

//Converted to PDO, currently working
//Consider moving all Javascript to its own file and then using an include statement
//Also may need to set all PDO statements to null after completion
//Which would be true for all files so I'll research first, then do all at once

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

if (!isset($_SESSION['valid'])){
    header("Location: login.php");
    exit();
}

?><!DOCTYPE HTML>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body style="background-color:silver">  
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <?php echo $_SESSION['username']; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <ul class="navbar-nav">

<!-- Dropdown Products -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="searchproduct.php">Product Search</a>
                <a class="dropdown-item" href="addproduct.php">Add Product</a>
            </div>
        </li>

<!-- Dropdown Commodities -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Commodities</a>
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
<!-- Delete this closing div tag later and see if it works -->
</div>
</nav>

<br>
<center>
<!-- Delete later and move to CSS file -->
<style='background-color:silver'>


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
    //Variable for storing commodities that are not updated in commodities
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
            //Attempt database connection (may move to top)
            try{
                $pdo = Connect::get()->connect();
                //Perform query to see if product already exists
	        $stm1 = $pdo->prepare("SELECT * FROM products WHERE LOWER(name) = :name");
                $stm1->execute([':name'=>$name]);
                $productReturn = $stm1->fetch(PDO::FETCH_ASSOC);               
                //free statement memory
                $stm1=null;
                //If the product doesn't exist, create a new one
                if(! $productReturn) {
                    //Create new product entry in products table
                    $productsInsert = $pdo->prepare('INSERT INTO products (name) VALUES (:name)');
                    $productsInsert->execute(['name'=>$name]);			
                    //free statement memory by setting to null
                    $productsInsert=null;
                    //Confirm that a commodity name was given in form submission
                    if(isset($_POST["commodities"])){
                        $i = 0;
                        //Insert commodity values into composition
                        foreach($_POST["commodities"] as $commodity){
                            $stm_com = $pdo->prepare('SELECT * FROM commodities WHERE name = :commodity');
                            $stm_com->execute([':commodity'=>$commodity]);
                            $commodityReturn = $stm_com->fetch(PDO::FETCH_ASSOC);		
                            $stm_con=null;
                            //see if commodity exists and if not insert
                            if(!($commodityReturn)){
                                $newcom = $pdo->prepare('INSERT INTO commodities (name, unit, price) VALUES (:commodity, :unit, :price)');
                                $newcom->execute([':commodity'=>$commodity, ':unit'=>$_POST["units"][$i], ':price'=>$_POST["prices"][$i]]);
                                $newcom=null;
                            }
                            else {
                                //Store unchanged commodites in string variable
                                echo "<script language='javascript'> cUnchanged+= ' ' + " . json_encode($commodity) . "; </script>";
                            }
                            $stm_comp = $pdo->prepare('INSERT INTO composition (unit_weight, productid, commodityid) VALUES (:weight, (select idpro from products where name=:name), (select idcomm from commodities where name=:commodity))');
                            $stm_comp->execute([':weight'=>$_POST["weights"][$i], ':name'=>$name, ':commodity'=>$commodity]);
                            $stm_comp=null;
                            $i++;
                        }
                    }
                    //Alert user to completed product addition
                    echo "<script type='text/javascript'>alert('product succesfully added');</script>";
                }
                else {
                    //Alert user to attempts to duplicate already existing product
                    echo "<script type='text/javascript'>alert('product already exists');</script>";
                } 
                //Close database connection
                $pdo=null;
                
            }catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    ?>
    </div>
    </center>
</body>
<script language="javascript">
    if(cUnchanged.length !== 0) {
        alert("The following commodity prices and weights were not changed as they already exist in the database:\n" + cUnchanged);
    }
</script>
</html>

