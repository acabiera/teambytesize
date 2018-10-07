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
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">
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
    <body>
        <div class="sidebar">
        <?php echo $_SESSION['username']; ?>

<!-- Dropdown Products -->
            <div class="dropdown">
                <button class="dropbutton">Products</button>
                <div class="dropcontent">
                    <a href="searchproduct.php">Product Search</a>
                    <a href="addproduct.php">Add Product</a>
                </div>
            </div>

<!-- Dropdown Commodities -->
            <div class="dropdown">
                <button class="dropbutton">Commodities</button>
                <div class="dropcontent">
                    <a href="searchcommodity.php">Commodity Search</a>
                    <a href="addcommodity.php">Add Commodity</a>
                </div>
            </div>

<!-- Hyperlinks -->
            <div class="dropdown">
                <a href="recentsearches.php"><button class="dropbutton">Recent Searches</button></a>
            </div>
            <div class="dropdown">
                <a href="logout.php"><button class="dropbutton">Logout</button></a>
            </div>

        </div>
        <br>

        <div class="main">
            <h1>Should-Cost: Add Commodity</h1>

            <br>Please enter the new commodity information. 
            <br> Note that this will be unverified until it can be found in a verified index.
            <div class="noborder"> 

                <form name="newcommodity" action="addcommodity.php" autocomplete="off" method="POST">
                    <br>
                    <input type="text" name="commodity" placeholder="Commodity Name"required/>
                    <input type="number" min="0" step="0.01" name="price" placeholder="Price in USD"required/>	
                    <input type="text" onkeydown="preventNumberInput(event)" onkeyup="preventNumberInput(event)" name="unit" placeholder="Weight Unit"required/>
                    <br>
               
                    <button type="submit">Submit</button>
                </form>
            </div>
           
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
