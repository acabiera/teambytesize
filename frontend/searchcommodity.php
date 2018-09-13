<?php

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

if(!(isset($_SESSION)) ||!($_SESSION['valid'])){
    header("Location: login.php");
   exit();
}
?><!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Commodity Search</title>
</head>
<body>
<?php

    //Query database and store product names in an array
    //(design NEEDS to be changed to only load AFTER typing in a letter or two)
    //(Finishing first task first though)
        try{
            $pdo=Connect::get()->connect();
            $commStm=$pdo->prepare("SELECT name from commodities");
            $commStm->execute();
            $commodities = $commStm->fetchAll(PDO::FETCH_ASSOC);
            //Pass products array to javascript
            echo "<script language='javascript'> var commodityArray =" . json_encode($commodities) . "; </script>";
            //Free memory
            $commStm=null;
        }catch(\PDOException $e){
    echo "<script> window.alert('There was an exception found while attempting the autocomplete script.') </script>";
}
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
<br>
<center>
<div class="card bg-primary" style="width: 50rem;">
    <br>
    <div class="h1 card-title">Commodity Search</div>

        <div class="card-body">
            <p>Search for the commodity below to view its information.
            <br>
            <?php
            //Set flag to enable searches to be stored in the database
            $_SESSION['issearch'] = true;

            if (isset($_SESSION['noterm'])){
                if ($_SESSION['noterm']){
                   echo "<script type='text/javascript'>alert('Your search commodity is not in the database. Please add, or try a different term.');</script>";
                   //Reset flag to false after it returns the message
                   unset($_SESSION['noterm']);
                   unset($_SESSION['incorrectterm']);
                }
            }
            ?>
            </p>
            <form action="commodityinfo.php"  autocomplete="off" method="GET">
                <input type="text" class="form-control" style="width:85%;float:left;" id ="commoditysearch" name="commoditysearch" onChange="createList()" placeholder="Enter Commodity to Search">
                <button type="submit" class="border btn btn-primary border-dark text-dark">Search</button>
                <div style="width:85%; background-color:white; clear:both; float:left;" id="completeContainer"/> 
           </form>
        </div>
        <br>


<script language="javascript">
    //shorthand variables for html elements
    var input = document.getElementById("commoditysearch");
    var cParent = document.getElementById("completeContainer");

    //Create a list of product suggestions when user types in search bar            
    input.addEventListener("input", function(e) {
    //Close all suggestions prior to creating new ones
    removeSuggest();
        if(input.value.length > 0) {
            //Check if value in input matches any product names
            for(var i = 0; i < commodityArray.length; i++) {
                //Convert current product name to string
                var name = JSON.stringify(commodityArray[i]["name"]);
                name = name.replace(/^"(.*)"$/, '$1'); //strip double quotes from value

                //Check for matches
                if(input.value.toLowerCase() ===  name.substr(0, input.value.length).toLowerCase()) {
                    //Create suggestion on screen
                    var suggestion = document.createElement("div");
                    //Bold matching letters
                    suggestion.innerHTML = "<strong>" +  name.substr(0, input.value.length) + "</strong>";
                    suggestion.innerHTML += name.substr(input.value.length);
                    //Hide input field for value retrieval later
                    suggestion.innerHTML += "<input type='hidden' value='" + name + "'>";
                    //Add a border to separate one suggestion from the next
                    suggestion.style.border = "thin solid #000000";
                    suggestion.style.borderTop = "thin solid #FFFFFF";

                    //Change cursor to show item is clickable
                    suggestion.style.cursor = "pointer";

                    //Change input value to what ever user clicks
                    suggestion.addEventListener("click", function(e) {
                        //Insert suggestion within input field
                        input.value = this.getElementsByTagName("input")[0].value;
                        //Stop showing suggestions after a selection
                        removeSuggest();
                    });
                cParent.appendChild(suggestion);
                }
            }
        }
    });
    //Remove suggestions currently displayed on screen
    function removeSuggest(){
        while(cParent.hasChildNodes())
        cParent.removeChild(cParent.lastChild);
    }

     //Remove suggestions when user clicks
     document.addEventListener("click", function(e){
         removeSuggest();
     });
</script>
    </center>

</body>
</html>

