<?php
    //recentsearches.php
    require 'vendor/autoload.php';
    use scservice\SCConnect as Connect;
    session_start();

    //Set flag to disable following link from counting as searches
    $_SESSION['issearch'] = false;

    $results = false;

    if (!(isset($_SESSION['valid']))){
        header("Location: login.php");
        exit();
    }


    try{
        $pdo=Connect::get()->connect();


        //insert code to delete all but ten latest searches.
        //$deleteOld=$pdo->prepare('DELETE from search_history where searchtime <= (select searchtime from (select searchtime from search_history order by searchtime desc limit 1 offset 10)));
        //Giving me trouble, will figure it out later

        //store list of searches in a variable
        $searchReturn=$pdo->prepare('SELECT searchterm, searchtime, type FROM search_history WHERE userid=(SELECT iduser FROM user_stuff WHERE username=:username)');
        $searchReturn->execute([':username'=>$_SESSION['username']]);
        $searchHistory=$searchReturn->fetchAll(PDO::FETCH_ASSOC);
        $searchReturn=null;
    }catch(Exception $e){
        echo 'Message: '.$e->getMessage();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="scstyle_01.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <title>Should-Cost: Recent Searches</title>
    </head>

    <body>
        <div class="sidebar">
<?php
    echo $_SESSION['username'];
    include 'sidebar.php';    
    //Done through here, will need work.
    //Right now the three divs are beside each other
    //I need to figure out how to preserve that

?>
        </div>
        <div class="main">
            <h1>Recent Searches</h1>
            <p>These are your most recent searches.</p>
            </div>
            <div class="noborder">
<!-- Search Time -->
                <div class="sidebyside">
                    <h3>Search Time</h3>
<?php 
    if(!empty($searchHistory)) {			
        //Print out search times
        foreach($searchHistory as $time) {
            echo date("n/j, g:i a", strtotime($time["searchtime"]));	
            echo "<br>";
        } 	
    }
    else {
        echo "no data";
    }		
?>
                </div>

<!-- Type -->
                <div class="sidebyside">
                   <h3>Type</h3>
                   <?php
                        if(!empty($searchHistory)) {
                            //Print out item names as links
                            foreach($searchHistory as $type) {
                                echo $type['type'];
                                echo "<br>";
                            }
                        }
                        else{
                            echo "no data";
                        }
                   ?>
                </div>

<!-- Searched -->
                <div class="sidebyside">
                    <h3>Searched</h3>
                    <?php 
                        if(!empty($searchHistory)) {
                            //Print out item names as links
                            foreach($searchHistory as $name) {
                                $param = str_replace(' ', '%20', $name['searchterm']); //Had to encode spaces here to allow passing to url
                                //Set separate links for product and commodity types
                                if($name['type'] == 'product') {
                                    $link = "materials.php?product={$param}";
                                }
                                else{
                                    $link = "commodityInfo.php?commoditysearch={$param}";
                                }
                                echo "<a style='width:fit-content' href = $link>{$name['searchterm']}</a><br>";
                            }
                        }
                        else {
                            echo "no data";
                        }
                    ?>
                </div>

            </div>
            <br>
        </center>
    </body>
</html>


