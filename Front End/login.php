<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Should Cost: Login</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<!-- <a class="navbar-brand" href="#">User's Name</a>
Change this from a static User's Name thing to a php file that will change as people log in. 
-->
<?php

require 'vendor/autoload.php';

use scservice\SCConnect as Connect;

if(isset($_COOKIE['SCServiceUser'])) {
    $loggedIn = true;
    echo $_COOKIE['SCServiceUser'];
}
else {
    echo 'User Name';
}
?>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
<div class="navbar-nav">
<a class="nav-item nav-link" href="#">Recent Searches</a>
<a class="nav-item nav-link" href="#">Add Product</a>
<a class="nav-item nav-link" href="#">Logout</a>
</div>
</div>
</nav>
<br></br>
<center>
<div class="card bg-primary" style="width: 50rem;">
<div class="h1 card-title">Should-Cost Login</div>
<!--
THIS is the point at which I should be able to hide the login and show another message instead of cookie is set,
but I haven't figured out how yet.
-->
<div class = "card bg-primary" style="width:20rem;margin: 0 auto;">
<form action='login.php' method='post'>
<label for="username"><b>Username</b></label>
<input type="text" placeholder="Your username" name="username" required>
<label for="password"><b>Password</b></label>
<input type="password" placeholder="Your password" name=password required>

<button class="border btn btn-primary border-dark text-dark" type="submit"> Log in</button>

</form>
</div>

<br> <?php
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
            setcookie('SCServiceUser', $username, time() + 86400, "/");
         }
         else { //error
            echo 'Passwords do not match<br>';
         }
     }
} catch (\PDOException $e){
    echo $e->getMessage();

}
?>
</div>
</center>

</body>
</html>


