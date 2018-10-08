<?php
session_start();
if (isset($_SESSION['valid'])){
    header('Location: searchproduct.php');
    exit;
}
?><!DOCTYPE HTML>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">
        <title>Login</title>
    </head>
    <body>
<?php
    require 'vendor/autoload.php';
    use scservice\SCConnect as Connect;
?>
    <br>
        <div class="main">
            <h1>Should-Cost Login</h1>
            <div class="noborder"> 
                <form action='authenticate.php' method='post'>
                    <br>
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Your username" name="username" required>
                    <br>
                    <label for="password"><b>Password</b></label>
                    <input type="password" placeholder="Your password" name="password" required>
                

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
    if (isset($_SESSION['error'])){
        echo '<script> window.alert("connection error") </script>';
        unset($_SESSION['error']);
    }

?>
                    <br>
                    <button type="submit"> Log in</button>
                </form>
                <div class="noborder">
                    <br> 
	            <a href="createuser.php">Create User</a>
                </div>
            </div>
    </body>
</html>

