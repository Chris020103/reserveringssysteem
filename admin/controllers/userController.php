<?php
    require "../../config.php";
    require "../../classes/User.php";
try{
    $userQuery = "SELECT * FROM `user`";

    $users = $connection->query($userQuery)->fetchAll(PDO::FETCH_CLASS, '\\Classes\\User');

    echo json_encode($users);
}catch (Exception $e){
    return $e->getMessage();
}

    ?>