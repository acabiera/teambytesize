<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Capstone Template (Should-Cost)</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">

<?php
        if(isset($_COOKIE['SCServiceUser']))
        {
                echo $_COOKIE['SCServiceUser'];
        }
        else
        {
                echo 'User Name';
        }
?>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
<!--
      <a class="nav-item nav-link" href="recentsearches.php">Recent Searches</a>
      <a class="nav-item nav-link" href="addproduct.php">Add Product</a>
      <a class="nav-item nav-link" href="">Logout</a>
-->
    </div>
  </div>
</nav>
<br></br>
<center>

<body style='background-color:silver'>
<div class="card bg-primary" style="width: 50rem;">
<div class="h1 card-title">Confirm Logout</div>
<button class="border btn btn-primary border-dark text-dark" type="submit"> Log Out</button>

<br> <?php
echo "Are you sure you want to log out?";


?>

</div>
</center>

</body>
</html>


