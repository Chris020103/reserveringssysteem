<?php
require "../config.php";
$data = ['errors' => "", "success" => false];

if($_POST){
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $licensePlate = $_POST['licensePlate'];

    try{
        $carQuery = "INSERT INTO car (id, brand, model, licensePlate)
                        VALUES (null, '$brand', '$model', '$licensePlate')";
        if(mysqli_query($mysqli, $userQuery)){
            $data['success'] = true;
        }else{
            $data['errors'] = "Er is iets fout gegaan tijdens het toevoegen van de car";
        }

        $singleCarQuery = "SELECT * FROM car WHERE licensePlate = " . $licensePlate;
        $resultSingleCarQuery = mysqli_query($mysqli, $singleCarQuery);
        $car = mysqli_fetch_array($resultSingleCarQuery);
        $carId = $car['id'];

        $userQuery = "INSERT INTO user (id, firstName, middleName, lastName, password, email, level, car_id)
                VALUES  (null,'$firstName','$middleName','$lastName','$password', '$email', 0, '$carId')";

        if(mysqli_query($mysqli, $userQuery)){
            $data['success'] = true;
        }else{
            $data['errors'] = "Er is iets fout gegaan tijdens het toevoegen van de gebruiker";
        }
    }catch (Exception $e){
        $data['errors'] = $e->getMessage();
    }
}
?>