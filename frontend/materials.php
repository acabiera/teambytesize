<?php
    //materials.php
    require 'vendor/autoload.php';
    use scservice\SCConnect as Connect;
    //Start session and check for login
    session_start();
    if(!isset($_SESSION['valid'])){ //if session is not set return to login
        header("Location: login.php");
        exit();
    }
//Set up highlights
$GLOBAL['highlight'] = false;
include('app/var.php');
if(!isset($_GET['product'])){
    //return user to home page when there is no product parameter
    header("Location: searchproduct.php");
    exit();
}
//Attempt connection
try{
    $pdo = Connect::get()->connect();
}  catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
}
//Get product list
$prodName = $_GET["product"];
$term = strtolower(str_ireplace('_', ' ', $_GET["product"]));
$check = $pdo->prepare('SELECT commodities.name FROM composition, commodities, products WHERE composition.productid=(select idpro from products where name=:name) and commodities.idcomm=composition.commodityid ORDER BY commodities.name');
$check->execute([':name'=>$term]);
$checkReturn = $check->fetch(PDO::FETCH_ASSOC);
$check=null;
//IF result is empty, save incorrect term and return to searchproduct.php   
if (!$checkReturn) {
    $_SESSION['noterm']=true;
    $_SESSION['incorrectterm'] = $term;
    header("Location: searchproduct.php");
    exit();
}
//Here we check to see if this is an actual search or a history click
//If it is a typed search we will insert it into search history
else if (isset($_SESSION['issearch']) && $_SESSION['issearch']) {
    $addRecent = $pdo->prepare('INSERT INTO search_history (userid, searchterm,type,searchtime) VALUES ((SELECT iduser FROM user_stuff WHERE username=:username), :term, :type, now())');
    $addRecent->execute([':username'=>$_SESSION['username'], ':term'=>$term, ':type'=>'product']);
    $addRecent=null;
    //Reset valid search flag to prevent duplicate insertions
    $_SESSION['issearch'] = false;
}
?><!DOCTYPE HTML>
<html>
<head>
    <title>Should-Cost Analysis: Material Results</title>
    <link rel="stylesheet" type="text/css" href="scstyle_01.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head> 
<body>
<div class="sidebar">
<?php
    echo $_SESSION['username'];
    include 'sidebar.php';
?>
</div>
<div class="main">

    <div class="noborder"> 
		<h1>Material Results"</h1>
<?php

    echo "<p>Material Name: ".ucwords(str_ireplace('_', ' ', $prodName));
    //Create edit link to send user to editproduct page
    echo '<span class="buttonlink"><a href="editproduct.php?product='.$prodName.'">Edit</a></span>';
?>
    </div>
    <br> 
    <!-- The meta tag is to help scale it to other devices-->    
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Materials------------- -->
    <div class='table_back'>
	<div class="sidebyside">
	    <h2>Materials</h2>
<?php
//I really only need one try/catch block, edit that later
try{
	    //I suspect I will have to replace this with code that doesn't select distinct names in case we have different commodities w/ same name. Or else just disallow that and have the backend append something to a commodity name if it is the same as the one in the table, for review
    $result=$pdo->prepare("SELECT DISTINCT commodities.name FROM composition, commodities, products  WHERE composition.productid=(select idpro from products where name=:name) and composition.commodityid=commodities.idcomm ORDER BY commodities.name");
    $result->execute([':name'=>$term]);
    //$searchResult=$result->fetchAll(PDO::FETCH_ASSOC);
    while($row=$result->fetch(/*PDO::FETCH_ASSOC*/)){
        if(!contains($row[0])){ //red background if no result found
            //For now I'll keep the style change, this seems to be what it's good for.
            echo "<br><font style='background-color:red'>".$row[0]."</font>";
            $GLOBAL['highlight'] = true;
        }
        else{
            echo "<br>".$row[0];
        }
    }
    $result=null;
}catch(Exception $e){
    echo $e->getMessage();
}
?>
        </div>

<!-- Price--------- -->
        <div class="sidebyside">
            <h2>Price</h2>
<?php
    //For a later version, find out if I can do this in a single query
    //I know the guy who built this page tried it but couldn't do it
    //What I can't tell is why
    $arrayNames = [];
    $arrayPrice= [];
    $arrayUnit = [];
    $arrayWeight=[];
    $arrayUnitPrice=[];
    $chartData = [];
    try{
        $price=$pdo->prepare("SELECT DISTINCT commodities.price, commodities.name FROM commodities, composition, products WHERE composition.productid=(SELECT idpro FROM products WHERE name=:name) and composition.commodityid=commodities.idcomm ORDER BY commodities.name");
        $price->execute([':name'=>$term]);
        $unit=$pdo->prepare("SELECT DISTINCT commodities.unit, commodities.name from commodities, composition, products where composition.productid=(select idpro from products where name=:name) and composition.commodityid=commodities.idcomm ORDER BY commodities.name");
        $unit->execute([':name'=>$term]);
         while (($row = $price->fetch(/*PDO::FETCH_ASSOC*/)) && ($row2=$unit->fetch(/*PDO::FETCH_ASSOC*/))){
            array_push($arrayPrice, $row[0]);
            array_push($arrayNames, $row[1]);
            array_push($arrayUnit, $row2[0]);
            if(!contains($row[1])){
                echo "<br><font style='background-color:red'>$".round($row[0], 2)."/".$row2[0]."</font>";
            }
            else{
                echo "<br>$".round($row[0], 2)."/".$row2[0];
            }
        }
        $unit=null;
        $price=null;
    }catch(Exception $e){
        echo $e->getMessage();
    } 
?>
        </div>

<!-- Weight--------- -->
        <div class="sidebyside">
            <h2>Weight</h2>
<?php
    $red_weight=false;
    try{
       $weight=$pdo->prepare("SELECT DISTINCT composition.unit_weight, commodities.name from products, composition, commodities where composition.productid=(SELECT idpro from products where name=:name) and composition.commodityid=commodities.idcomm order by commodities.name");
        $weight->execute([':name'=>$term]);
        while($row=$weight->fetch(/*PDO::FETCH_ASSOC*/)){
            array_push($arrayWeight, $row[0]);
            if(!contains($row[1])){
                echo "<br><font style='background-color:red'>".round($row[0], 2)."</font>";
                $red_weight=true;
            }
            else{
                echo "<br>".round($row[0], 2);
            }
        }
        $weight=null;
    }catch(Exception $e){
        echo $e->getMessage();
    }          
?>
        </div>

<!-- -Unit Price--------- -->
        <div class="sidebyside">
            <h2>Unit Price</h2>
<?php
    
            /*I want to debug this, but I don't know where to start
             *The first Fetch statement is returning a bool true statement instead of values.
             *This identical code is returning proper values above, and the second statement works.
             *There are no questions about this online - I'm completely lost.
            $weight2=$pdo->prepare("SELECT composition.unit_weight, commodities.name from products, composition, commodities where composition.productid=(SELECT idpro from products where name=:name) and composition.commodityid=commodities.idcomm order by commodities.name");
            $weight2->execute([':name'=>$term]);
            $price=$pdo->prepare("SELECT commodities.price, commodities.name FROM commodities, composition, products WHERE composition.productid=(SELECT idpro FROM products WHERE name=:name) and composition.commodityid=commodities.idcomm ORDER BY commodities.name");
            $price->execute([':name'=>$term]);
            while($row1=$weight2->fetch() && $row2=$price->fetch()){
                if(!contains($row1[1])){
                    echo "<font style='background-color:red'>".round($row1[0]*$row2[0], 2)."</font>";
                    $sum += $row1[0]*$row2[0];
                    array_push($arrayUnit, round($row1[0]*$row2[0], 2));
                }
                else{
                    echo round($row1[0]*$row2[0], 2)."</br>";
                    $sum += $row1[0]*$row2[0];
                    array_push($arrayUnit, round($row1[0]*$row2[0],2));
                }
            }
            $weight=null;
            $price=null;
            *End problem code - going to try another tack.
            */

    //declaring array data for chart
    $chartdata=[];
    $sum=0;
        
    $weightToPrice = array_combine($arrayWeight, $arrayPrice);
    foreach($weightToPrice as $weight=>$price){
        $eachUnit=$weight*$price;
        if ($red_weight){
            echo "<br><font style='background-color:red'>".round($eachUnit, 2)."</font>";
        }
        else{
            echo "<br>".round($eachUnit, 2);
        }
    $sum += $eachUnit;
    array_push($arrayUnitPrice, round($eachUnit, 2));
    }
?>
        </div>
    </div>
<br><br><br><br>
    <br>

<!-- ---------Total--------- -->
    <div class="totals">
    <br><br><br>
<?php
    echo "Total:";
    //Why use echo here and not above? Consider changing
    if($sum == 0){
        echo " None of the commodities are known";
    }
    else if($sum !=0 and $GLOBAL['highlight']){
        echo "$".round($sum, 2). " (Highlighted materials are not automatically updated)";
    }
    else{ 
        echo "$".round($sum, 2);
        if($GLOBAL['highlight']){
            echo " (excluding highlighted materials)</div>";
        }
        else{
            echo " </div>";
        }
    }
    $pdo=null;

/* Assigning the pairs of names and prices to the chart - product/total, then commodities/(price/total)*/
    echo "<br>";
//    for($i=0; $i<count($arrayNames); $i++){
//        array_push($chartdata, [$arrayNames[$i][0],round($arrayUnit[$i]/round($sum, 2),5)]);
//    }
/*This part was for charts later, I'll preserve it for now
        $jsonChart = json_encode($chartdata);
        $_SESSION['chartdata']=$jsonChart;                
*/
    ?>
    <br>
</div>
</body>
</html>
