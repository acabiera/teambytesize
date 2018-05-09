<?php

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

//this is to create a new user
//if user is logged in, throw up a window, redirect to home
if (isset($_SESSION['valid'])){
    header('Location: home.php');
    //window
    exit();
}

?>

<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Should Cost: New User</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<?php
	echo "Create a New User";
?>

<body style='background-color:silver'>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
<div class="navbar-nav">

</div>
</div>
</nav>
<br></br>
<center>
<div class="card bg-primary" style="width: 50rem;">
<div class="h1 card-title">Should-Cost: New User</div>

<div class = "card bg-primary" style="width:30rem;margin: 0 auto;">
<!--
<form action='login.php' method='post'>
-->
<br>
<form action='userdata.php' method='post'>
	<div style="width: 65%;">
		<label style="float:left" for="username"><b>Username</b></label>
		<input style="float:right" type="text" placeholder="Your new username" name="username" required>
	</div>
	<div style="width: 65%; clear:both;">
		<label style="float:left" for="password"><b>Password</b></label>
		<input style="float:right" type="password" placeholder="Your new password" name="password" required>
	</div>
	<div style="width: 65%; clear: both;">
		<label style="float:left" for="repeatpass"><b>Retype Password</b></label>
		<input style="float:right" type="password" placeholder="Confirm password" name="repeat" required>
	</div>
	<br style="clear: both">
	<?php
		if (isset($_SESSION['passMatch'])){
			echo '<script> window.alert("Your passwords do not match! Please retry.")</script>';
		   unset($_SESSION['passMatch']);
		}
		if (isset($_SESSION['exception'])){
			echo '<script> window.alert("There was an error accessing the table. Please retry.")</script>';
			unset($_SESSION['newUserMade']);
		}
	?>
	<br>
	<button class="border btn btn-primary border-dark text-dark" type="submit"> Create Account</button>
	<a class="nav-item nav-link text-dark" href="login.php">Cancel</a>
</form>
<?php
//var_dump($_SESSION);
?>
</div>

<br>

</div>
</center>
</body>
</html>



