<?php
session_start();
if (isset($_SESSION['valid'])){
    header('Location: searchproduct.php');
    exit;
}
 ?>

<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Login</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">


<?php

require 'vendor/autoload.php';

use scservice\SCConnect as Connect;
echo 'Please Log In';
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
<div class="h1 card-title">Should-Cost Login</div>




<div class = "card bg-primary" style="width:20rem;margin: 0 auto;">
<!--
<form action='login.php' method='post'>
-->
<form action='authenticate.php' method='post'>
	<br>
	<div style="width: 85%;">
		<label style="float: left" for="username"><b>Username</b></label>
		<input style="float: right" type="text" placeholder="Your username" name="username" required>
	</div>
	<div style="width: 85%; clear: both;">
		<label style="float: left" for="password"><b>Password</b></label>
		<input style="float: right" type="password" placeholder="Your password" name="password" required>
	</div>

	<?php
	if (isset($_SESSION['badPass'])){
		echo '<script> window.alert("Your password was incorrect! Please retry.")</script>';
	   unset($_SESSION['badPass']);
	}

	if (isset($_SESSION['userExists'])){
		echo '<script> window.alert("This username always exists. Either go back and create with a new username, or log in!")</script>';
	   unset($_SESSION['userExists']);
	}
	if (isset($_SESSION['newUserMade'])){
		echo '<script> window.alert("User account created successfully!")</script>';
		unset($_SESSION['newUserMade']);
	}
	?>
	<br style="clear: both">
	<br>
	<div style="width: 85%; margin-bottom: 0px;">
		<button style="clear: both;" class="border btn btn-primary border-dark text-dark" type="submit"> Log in</button>
	</div>
	<a class="nav-item nav-link text-dark" href="createuser.php">Create User</a>
</form>
</div>

<br>


<?php
/*
if (! isset($_POST) or sizeof($_POST)<2) {
        $username = 'No_entry';
        $password = 'No_entry';
}
else {
    //var_dump($_POST);
    $username = $_POST['username'];
    $password = $_POST['password'];
}
try{
        
    $pdo = Connect::get()->connect();
    $stm1 = $pdo->prepare('SELECT * FROM user_stuff WHERE username = :username');
    $stm1->execute([':username'=>$username]);
    $match = $stm1->fetch(PDO::FETCH_ASSOC);
    //var_dump($match);
    if ($username=="No_entry"){
         echo ' ';
    }
    elseif (! $match){
        echo 'Username does not exist, please create an account.<br>';
    }
    else {
        $pass = $match['password'];
        if ($pass == $password){
            //prepare query and push a timestamp
            $stm2 = $pdo->prepare('update user_stuff set last_login=now() where username = :username');
            $stm2->execute([':username'=>$username]);
            
            //set a cookie
            //setcookie('SCServiceUser', $username, time() + 86400, "/");
            //start a session?
            $_SESSION['valid'] = true;
            $_SESSION['last_used'] = time();
            $_SESSION['username'] = $username;
         }
         else { //error
            echo 'Passwords do not match<br>';
         }
     }
} catch (\PDOException $e){
    echo $e->getMessage();

}

*/
//?>

</div>
</center>

</body>
</html>


