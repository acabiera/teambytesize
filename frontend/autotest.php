<?php

require 'vendor/autoload.php';
//include 'app/search.php'; 
use scservice\SCConnect as Connect;


session_start();

//if (!(isset($_SESSION)) || !($_SESSION['valid'])){
//    header("Location: login.php");
//    exit;
//}

$dest = "autotest.php";

?>
<html>
    <head>
<!--
        <script src="app/typeahead.bundle.js"> </script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
-->
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">

        <title>Ajax test (Should-Cost)</title>
    </head>
    <body>
        <div class="sidebar">
            User Name
            <br>
            <?php include 'sidebar.php'; ?>        
         
      </div>
      

      <br>

      <div class="main">
            <h1>Test Search</h1>
    
            <br>Test text goes here for seeing how the page looks with it.
            <br>Need to make sure that it is displayed properly.
            <div class="noborder">
                <form>
                    <label for="typeahead">Search</label>
                    <input type="text" placeholder="Search Field" id="autocomplete" onkeyup="suggest(this.value)">
                    <button>Test Button</button>
                    <div class="ajaxdropcontainer" id="suggestions">
                    </div> 
                    
                </form>
            </div>
 <?php
//Code
?>

        </div>

    </body>

    <script>
        function suggest(str) {
            if (str==="") { //or use str.length == 0 maybe
              document.getElementById("suggestions").innerHTML="";
              return;
            }
            else {
                var destPage = '<?php echo $dest ?>';
                var searchRequest = new XMLHttpRequest();
                searchRequest.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("suggestions").innerHTML = this.responseText;
                    }
                };
            searchRequest.open("GET", "search.php?table=products&q=" + str + "&dest=" + destPage, true);
            searchRequest.send();
            }
        }
    </script>
</html>
