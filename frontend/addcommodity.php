<?php
//addcommodity.php
//add libraries and autoloads
require 'vendor/autoload.php';
use scservice\SCConnect as Connect;
session_start();
if (!isset($_SESSION['valid'])){
    header("Location: login.php");
    exit();
}
?><DOCTYPE html>
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
    <title>Add Commodity</title>
</head>
<body style="background_color:silver">
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
    <!-- </div> -->
    </nav>

    <br></br>
    <center>
    <div class="card bg-primary" style="width: 50rem;">
        <br/>
        <div class="h1 card-title">Add Commodity</div>
            <form name="newproduct" action="addcommodity.php" autocomplete="off" method="POST" class="card-body">
                <div id="productDetails" class="form-group">
                    <input type="text" class="form-control" name="commodity" style="width:50%;float:left;" placeholder="Commodity Name"required/>
                    <input type="number" min="0" step="0.01" class="form-control" name="price" style="width:24%;float:left; margin-left:1%;" placeholder="Price in USD"required/>	
                    <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" class="form-control" name="unit" style="width:24%;float:left; margin-left:1%;" placeholder="Weight Unit"required/>
                    <br>
                </div>
                <br>
                <div id="buttonContainer">
                    <button type="submit" class="border btn btn-primary border-dark text-dark">Submit</button>
                </div>
            </form>
            <?php
            //Confirm that a product name was given in form submission
            if(isset($_POST["commodity"])) {
                $commodity = $_POST["commodity"];
                $price = $_POST["price"];
                $unit = $_POST["unit"];
                //Attempt database connection
                try{
                    $pdo=Connect::get()->connect();
//See if commodity exists
                    $commStm=$pdo->prepare('SELECT * FROM commodities WHERE LOWER(name)=LOWER(:comm)');
                    $commStm->execute(['comm'=>$commodity]);
                    $commReturn=$commStm->fetch();
                    //If not found create a new entry
                    if (!$commReturn){
                        $commInsert=$pdo->prepare('INSERT INTO commodities(name,unit,price) VALUES (:name, :unit, :price)');
                        $commInsert->execute([':name'=>$commodity,':unit'=>$unit,':price'=>$price]);
                        //Free insert mem
                        $commInsert=null;						
                        //Alert user to completed commodity addition
			echo "<script type='text/javascript'>alert('commodity succesfully added');</script>";
                    }
                    else {
                        //Alert to existing commodity
                        echo "<script type='text/javascript'>alert('commodity already exists');</script>";
                    }
                    //Free statement and connection memory
                    $commStm=null;
                    $pdo=null;
                }catch(Exception $e){
                    echo 'Message: '.$e->getMessage();
                }
            }
            ?>        		
        </div>

</center>
<!--
Think this was left by mistake but I'll make sure later that it can't be used for something else
<script language="javascript">
	if(cUnchanged.length !== 0) {
		alert("The following commodity prices and weights were not changed as they already exist in the database:\n" + cUnchanged);
	}
</script>
-->
</body>
</html>
