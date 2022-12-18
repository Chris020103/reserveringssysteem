<?php
include "../config.php";
require_once "../classes/DateOptions.php";
$data = ['errors' => '', 'success' => ''];
if (empty($_POST['date'])) {
    $data['email'] = 'Date is required.';
}
if (empty($_POST['id'])) {
    $data['timestamp'] = 'Timestamp is required.';
}

//Check if id exists
$idCheck = "SELECT * FROM `standardDateOptions` WHERE id = " .  $_POST['id'] ;
$dateOption = $connection->prepare($idCheck);
$dateOption->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\DateOptions');
$dateOption->execute();
$dateOptionInfo = $dateOption->fetch();


if ($dateOptionInfo) {

    $newDate = date('Y-m-d', strtotime($_POST['date']));
    //Check if reservation with specified id already exists
    $reservationCheckQuery = "SELECT * FROM `reservations` WHERE date_id = " . $_POST['id'] . " " . "AND date = " . "'" . $newDate . "'" ;
    $reservationCheck = $connection->query($reservationCheckQuery);
    $reservationCheck->execute();
    $reservation = $reservationCheck->fetch();

    if (!$reservation) {
        session_start();
        $id = $_POST['id'];
        $userId = $_SESSION['UserId'];
        $remark = $_POST['remark'];

        $addReservation= $connection->prepare("INSERT INTO reservations (date_id, user_id, date, remarks) VALUES (?,?,?,?)");
        if($addReservation->execute([$id, $userId, $newDate, $remark])){
            $data['success'] = true;
        }else{
            $data['errors'] .= "Fout tijdens toevoegen van reservering!\n";
        }

    }else{
        $data['errors'] .= "Er is al een reservering met dit tijdvak gepland!\n";
    }
}else{
    $data['errors'] .= "Timestamp niet gevonden!\n";
}

echo json_encode($data);
?>