<?php
    require 'vendor/autoload.php';
    use scservice\SCConnect as Connect;
//    print_r($_REQUEST);
    $query = $_REQUEST['q'];
    $table = $_REQUEST['table'];
    $dest = $_REQUEST['dest'];
//  Could I send a variable for the destination page and use that to create URL?
//    var_dump($query);
//    echo '\n';
//    var_dump($table);
    try{
        $pdo=Connect::get()->connect();
        $querypart1 = "SELECT name FROM {$table} WHERE name LIKE :name";
        $search=$pdo->prepare($querypart1);
        $search->execute([':name'=>$query.'%']);
//        var_dump($search->debugDumpParams());
        $results=$search->fetchAll(PDO::FETCH_BOTH);
        $search=null;
//        var_dump($results);
        if ($results){

            foreach ($results as $item){
                echo  '<div class="ajaxdrop"><a href="'.$dest.'">'.$item["name"].'</a></div>';
            }

        }             
    }catch(Exception $e){
        echo 'Message: '.$e->getMessage();
    }
?>
