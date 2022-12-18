<?php

$errors = [];
$data = [];
if (empty($_POST['email'])) {
    $errors['email'] = 'Email is required.';

}else{
    $email = $_POST['email'];
}

if (empty($_POST['password'])) {
    $errors['password'] = 'Password is required.';
}else{
    $password = sha1($_POST['password']);
}
include "../config.php";
require_once '../classes/User.php';
if(empty($errors)){
    $opdracht = "SELECT * FROM `user` WHERE email = '$email' AND password = '$password'";
    $userQuery = $connection->prepare($opdracht);
    $userQuery->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\User');
    $userQuery->execute();
    $user = $userQuery->fetch();
    if ($user) {
        $data['success'] = true;
        session_start();
        $_SESSION['Email'] = $user->email;
        $_SESSION['UserId'] = $user->id;
        $_SESSION['Level'] = $user->level;
        echo json_encode($data);
    } else {
        $data['success'] = false;
        echo json_encode($data);
    }
}

?>