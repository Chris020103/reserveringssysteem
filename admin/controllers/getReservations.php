<?php
use Classes\Reservation;
include "../../config.php";
require_once "../../classes/Reservation.php";
include "../../classes/User.php";
include "../../classes/DateOptions.php";
try{
    session_start();
    $date = $_GET['date'];

    $newDate = date('Y-m-d', strtotime($date));
    $query = "SELECT * FROM `reservations` WHERE date = " . " ' " .  $newDate . " ' ";
    $reservations = $connection->query($query)->fetchAll(PDO::FETCH_CLASS, '\\Classes\\Reservation');

    $rowsStandardTimeStamps = [];
    $formattedReservations = [];
    $reservationsFormatted = [];

    foreach($reservations as $reservation){
        if($reservation->date === $newDate){
            $userquery =  "SELECT * FROM `user` WHERE id =" . $reservation->user_id;

            $userInfo = $connection->prepare($userquery);
            $userInfo->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\User');
            $userInfo->execute();
            $user = $userInfo->fetch();

            $timestampQuery =  "SELECT * FROM `standardDateOptions` WHERE id =" . $reservation->date_id;

            $timeStampInfo = $connection->prepare($timestampQuery);
            $timeStampInfo->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\DateOptions');
            $timeStampInfo->execute();
            $timeStamp = $timeStampInfo->fetch();

            $formattedReservation = new Reservation();
            $formattedReservation->setId($reservation->id);
            $formattedReservation->setDate($reservation->date);
            $formattedReservation->setUserId($user);
            $formattedReservation->setRemarks($reservation->remarks);
            $formattedReservation->setDateId($timeStamp);

            $reservationsFormatted[] = $formattedReservation;
        }
    }


    echo (json_encode($reservationsFormatted));
}
catch (Exception $e){
    $error = 'Oops, something went wrong!:' .
        $e->getMessage() . ' on line ' . $e->getLine() . 'Of' . $e->getFile();
}

?>