<?php
//commodityinfo.php
   
require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();
//send back to login if needed
if (!isset($_SESSION['valid'])){
    header("Location: login.php");
    exit();
} //else send back to the search page if they get here without the get somehow
elseif (!isset($_GET['commoditysearch'])){
    header("Location: commoditysearch.php");
    exit();
}//Otherwise we need to save the get as a variable for below
else{
    $term=$_GET['commoditysearch'];
}
?><!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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



<title>Commodity Information</title>
</head>
<body>
<?php 
    $price=[];
    //query database and find data on commodity
    try{
        $pdo=Connect::get()->connect();
        $commStmt=$pdo->prepare('SELECT price, unit FROM commodities WHERE name = :name');
        $commStmt->execute([':name'=>$term]);
        $price=$commStmt->fetchAll(PDO::FETCH_BOTH);
        $commStmt=null;
        if (!$price){ 
            $_SESSION['noterm']=true;
            $_SESSION['incorrectterm'] = $term;
            header("Location: searchcommodity.php");
            exit();
        }
        //Insert search history if it is a valid search
        else if (isset($_SESSION['issearch']) && $_SESSION['issearch']) {
            $addRecent=$pdo->prepare('INSERT INTO search_history (userid, searchterm, type, searchtime) VALUES ((SELECT iduser FROM user_stuff WHERE username=:username), :term, :type, now())');
            $addRecent->execute([':username'=>$_SESSION['username'], ':term'=>$term, ':type'=>'commodity']);
            $addRecent=null;
            //Reset valid search flag to prevent duplicate insertions
            $_SESSION['issearch'] = false;
        }
        //query should already be stored but add it here if necessary
        $commStmt=null; 

    }catch(Exception $e){
        echo 'Message: '.$e->getMessage();
    }
//done through this, i have to sleep
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <?php echo $_SESSION['username']; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav">

<!-- Dropdown Products -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#"  id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true " aria-expanded="false">Products</a>
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
 </nav>
<br>
<center>
<style='background-color:silver'>
<div class="card bg-primary" style="width: 50rem;">        	
    <br>
    <div style="position:relative;">
        <h1 style="display:inline; width:fit-content;">Commodity: 
        <?php  echo ucwords($term); ?>
        </h1>
        <?php
            //Create edit button to send user to editcommodity page
            //echo '<a class="text-dark" style="position:absolute; margin-left: 1%; bottom: 2; display:inline; width:fit-content;href="editcommodity.php?commodity='.$commodity.'">Edit</a>';
            //We were having trouble with this page, I'll get it later
        ?>
    </div>
    <br>
    <div class="card" style="background-color: silver; width: 90%; margin:auto; font-size: 20px;">
        <h3>Market Price</h3> 
        <?php 
           

             //If a price is available, print it to the screen
            if(!empty($price[0][0])){
                echo "$".$price[0][0].'/'.$price[0][1];
            }
            else{
                echo "Pricing Unavailable";
            }
        ?>
    </div>  
    <br>
    <div class="card" style="background-color: silver; width: 90%; margin:auto; font-size: 20px;">
        <h3>Products Using This Commodity</h3>
        <?php
            //Return products that contain the given commodity
	
            try{
                $productStmt=$pdo->prepare("SELECT products.name FROM products, commodities, composition WHERE commodities.name=:name AND composition.commodityid=commodities.idcomm AND products.idpro = composition.productid");
                $productStmt->execute([':name'=>$term]);
                $products=$productStmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($products)){
                    foreach($products as $prodName){
                        $output=$prodName['name'];
                        echo "<a style='width:fit-content' href='materials.php?product={$output}'>$output</a>";
                    }
                }
                else{
                    echo "This commodity has no products listing it as a component.";
                }
                $productStmt=null;
            }catch(Exception $e){
		echo "Message: ".$e->getMessage();
            }
        ?>
		 	
        </div>
        <br>
    </div>
</center>
</body>
</html>
