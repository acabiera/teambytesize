<?php
session_start();

if (isset($_SESSION)){
    $_SESSION = array();

     $params = session_get_cookie_params();
     setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

     session_destroy();
     header("Location: login.php");
}     
?>

<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Capstone Template (Should-Cost)</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">

<?php
        if(isset($_SESSION['username']))
        {
                echo $_SESSION['username'];
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
<div class="h1 card-title">Logging Out</div>
Thank you. You are now logged out.</div>
</center>

</body>
</html>


