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

<nav>
  <a href="#">User Name</a>
  <button>
    <span></span>
  </button>
  <div>
    <ul>
	
<!-- Dropdown Products -->
      <li>
        <a>Products</a>
        <div>
          <a href="searchproduct.php">Product Search</a>
          <a href="addproduct.php">Add Product</a>
        </div>
      </li>

<!-- Dropdown Commodities -->
      <li>
        <a href="#">
          Commodities
        </a>
        <div>
          <a href="searchcommodity.php">Commodity Search</a>
          <a href="addcommodity.php">Add Commodity</a>
        </div>
      </li>

<!-- Hyperlinks -->
      <a href="recentsearches.php">Recent Searches</a>
     <a href="logout.php">Logout</a>
    </ul>

  </div>
</nav>

<br></br>

<div>
<div><h1>Template</h1></div>

<br> <?php

?>




</div>


</body>
</html>


