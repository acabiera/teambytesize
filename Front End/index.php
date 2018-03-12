<?php
require 'vendor/autoload.php';
 
use scservice\Connection as Connection;
use scservice\SCServiceDisplay as Display;
 
try {
    // connect to the PostgreSQL database
    $pdo = Connection::get()->connect();
    // 
    $data = new Display($pdo);
    // get all stocks data
    $datalist = $data->allRows();
} catch (\PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SCService: Retrieving Data Test</title>
        <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
    </head>
    <body>
        <div class="container">
           <h1> Sample List</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Company</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datalist as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']) ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['company']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>>

