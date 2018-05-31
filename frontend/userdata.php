<?php
//userinfo.php
require 'vendor/autoload.php';
use scservice\SCConnect as Connect;

session_start();

//should not be possible to reach this w/o login
//still though
if(isset($_SESSION['valid'])){
    header('Location: home.php');
    //redirect to Home
    exit();
}
elseif(!(isset($_POST))){
    header('Location: createuser.php');
    //echo "Redirect to Login";
    //redirect to Login
    exit();
}
//now that we've done everything we need to check for session
session_unset();

$username=$_POST['username'];
$password=$_POST['password'];
$repeat=$_POST['repeat'];
//strip special characters once I get this working

if ($password != $repeat){
    $_SESSION['passMatch']=false;
    header('Location: createuser.php');
    exit();
}
try{
$pdo = Connect::get()->connect();
    $stml = $pdo->prepare('SELECT * FROM user_stuff WHERE username = :username');
    $stml->execute([':username'=>$username]);
    $match = $stml->fetch(PDO::FETCH_ASSOC);
    
    if ($match != false){
        $_SESSION['userExists']=true;
        header('Location: login.php');
        //Pop-up window on login - please log in
        //redirect to Login
        exit();
    }
    else {
   
            $result='logged_in';
            //prepare query and push timestamp
            $stm2 = $pdo->prepare('INSERT INTO user_stuff(username, lastlogin, password) VALUES (:username, now(), :password)');
           
            $stm2->execute(['username'=>$username, 'password'=>$password]);
            //I need to make sure this is inserting
            $_SESSION['newUserMade']=true;
             header('Location: login.php');
             exit();
         }
//On exception, print exception instead of redirect

}  catch (\PDOException $e){
       // $_SESSION['exception']=true;
       // header('Location: createuser.php'); 
          echo $e;
          exit();
}
//Handles SQL for the new user field for the website
?>

<html>
<body>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<title>Should Cost: Login</title>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
<!--Don't need this so I will not add links -->
<?php
//var_dump($_SESSION);
?>
</body>
</html>
