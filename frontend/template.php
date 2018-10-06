<?php
session_start();

//if (!(isset($_SESSION)) || !($_SESSION['valid'])){
//    header("Location: login.php");
//    exit;
//}

?>
<html>
    <head>
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
-->

        <link rel="stylesheet" type="text/css" href="scstyle_01.css">

        <title>Capstone Template (Should-Cost)</title>
    </head>
    <body>
        <div class="sidebar">
            User Name
          
            <br>
<!-- Dropdown Products -->
<!-- Do I need the list? Let's try w/o it -->
                
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
      

      <br></br>

      <div class="main">
            <h1>Template</h1>
    
            <br>Test text goes here for seeing how the page looks with it.
            <br>Need to make sure that it is displayed properly.
            <div class="noborder">
                <form>
                    <label for="test1">Test Field 1</label>
                    <input type="text" placeholder="Input 1">
                    <br>
                    <label for="test2">Test Field 2</label>
                    <input type="text" placeholder="Input 2">
                    <br><button>Test button</button>
                </form>
            </div>
 <?php
//Code
?>

        </div>


    </body> 
</html>


