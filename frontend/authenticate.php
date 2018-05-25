<?php

require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

//should not be possible to reach this w/o login
//still though
if(isset($_SESSION['valid'])){
    header('Location: searchproduct.php');
    //redirect to searchproduct
    exit();
}
elseif(!(isset($_POST))){
    header('Location: login.php');
    //echo "Redirect to Login";
    //redirect to Login
    exit();
}

$username=$_POST['username'];
$password=$_POST['password'];

//strip special characters once I get this working

try{
$pdo = Connect::get()->connect();
    
    $stml = $pdo->prepare('SELECT * FROM user_stuff WHERE username = :username');


    $stml->execute([':username'=>$username]);
    $match = $stml->fetch(PDO::FETCH_ASSOC);
    
    if (! $match){
        $result='no_user';
        //echo 'Username does not exist!';
        //redirect to Login
        exit();
    }
    else {
        $pass = $match['password'];
        if ($pass == $password){


            $result='logged_in';
            //prepare query and push timestamp
            var_dump($pdo);
            $stm2 = $pdo->prepare('update user_stuff set lastlogin=now() where username = :username');
            $stm2->execute(['username'=>$username]);


            //start session
            $_SESSION['valid'] = true;
            $_SESSION['last_used'] = time();
            $_SESSION['username'] = $username;
            header('Location: searchproduct.php');
         }
        else {
            $_SESSION['badPass']=true;
            header('Location: login.php');
        }

    }

}  catch (\PDOException $e){
    //var_dump($e);
    header('Location: login.php');
}
//authentication code for the website

?>

<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Should Cost: Login</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<!--Don't need this so I will not add links -->

</body>
</html>
