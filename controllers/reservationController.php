<?php
include "../config.php";

$data = [];
if (empty($_POST['date'])) {
    $data['email'] = 'Date is required.';
}
if (empty($_POST['id'])) {
    $data['timestamp'] = 'Timestamp is required.';
}

//Check if id exists
$idCheck = "SELECT * FROM `standardDateOptions` WHERE id = " .  $_POST['id'] ;

$resultIdCheck = mysqli_query($mysqli, $idCheck);

if (mysqli_num_rows($resultIdCheck) > 0) {

    $newDate = date('Y-m-d', strtotime($_POST['date']));
    //Check if reservation with specified id already exists
    $reservationCheckQuery = "SELECT * FROM `reservations` WHERE date_id = " . $_POST['id'] . " " . "AND date = " . "'" . $newDate . "'" ;
    $resultReservationCheckQuery = mysqli_query($mysqli, $reservationCheckQuery);
    if (mysqli_num_rows($resultReservationCheckQuery) === 0) {
        session_start();
        $id = $_POST['id'];
        $userId = $_SESSION['UserId'];
        $remark = $_POST['remark'];

        $addReservation = "INSERT INTO `reservations` 
                VALUES (NULL,'$id','$userId','$newDate','$remark')";
        if (mysqli_query($mysqli, $addReservation)){
            $data['success'] = true;
        }
        else{
            $data['errors'] .= "Fout tijdens toevoegen van reservering!\n";
        }
    }else{
        $data['errors'] .= "Er is al een reservering met dit tijdvak gepland!\n";
    }
}else{
    $data['errors'] .= "Timestamp niet gevonden!\n";
}

if($data['errors']){
    $data['success'] = false;
}

echo json_encode($data);
?>