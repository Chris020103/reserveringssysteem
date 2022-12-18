<?php
include "../../config.php";
include "../../classes/DateOptions.php";
include "../../classes/Reservation.php";
include "../../classes/User.php";

$id = $_GET['id'];

$query = "SELECT * FROM `reservations` WHERE id = " . $id;
$reservationInfo = $connection->prepare($query);
$reservationInfo->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\Reservation');
$reservationInfo->execute();
$reservation = $reservationInfo->fetch();

$dateOptionsQuery = "SELECT * FROM `standardDateOptions` WHERE id = " . $reservation->date_id;
$dateOptionInfo = $connection->prepare($dateOptionsQuery);
$dateOptionInfo->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\DateOptions');
$dateOptionInfo->execute();
$dateOption = $dateOptionInfo->fetch();

$userQuery =  "SELECT * FROM `user` WHERE id = " . $reservation->user_id;
$userInfo = $connection->prepare($userQuery);
$userInfo->setFetchMode(PDO::FETCH_CLASS, '\\Classes\\User');
$userInfo->execute();
$user = $userInfo->fetch();

$formattedReservation = new \Classes\Reservation();
$formattedReservation->setId($reservation->id);
$formattedReservation->setUserId($user);
$formattedReservation->setDateId($dateOption);
$formattedReservation->setRemarks($reservation->remarks);
$formattedReservation->setDate($reservation->date);

?>