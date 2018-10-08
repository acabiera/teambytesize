<?php
//createuser.php
//Future ideas:
// Different levels of user IDs
// (Only certain levels can edit products/commodities, etc)

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
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">
        <title>Should-Cost: Create New User</title>
    </head>

<?php
    //echo "Create a New User";
    //Gonna try this without the sidebar and see how it looks
?>
    <body>

        <div class="main">
            <h1>Create User</h1>

            <br>
            <form action='userdata.php' method='post'>
                <div class="noborder">
                    <label for="username"><b>Username</b></label>
                    <input type="text" placeholder="Your new username" name="username" required>
                </div>
                <div class="noborder">
                    <label  for="password"><b>Password</b></label>
                    <input type="password" placeholder="Your new password" name="password" required>
                </div>
                <div class="noborder">
                    <label for="repeatpass"><b>Confirm:</b></label>
                    <input type="password" placeholder="Confirm Password" name="repeat" required>
                </div>
                <br>
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
                <div class="noborder">
                    <button type="submit"> Create Account</button>
                    <br>
                    <a  href="login.php">Cancel</a>
                </div>
            </form>
        </div>
    </body>
</html>

