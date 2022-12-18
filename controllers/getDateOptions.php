<?php
    include "../config.php";
    require "../classes/DateOptions.php";
    require "../classes/Reservation.php";
    $date = $_GET['date'];

    $newDate = date('Y-m-d', strtotime($date));

    $queryStandardTimeStamps = "SELECT * FROM `standardDateOptions`";

    $query = "SELECT * FROM `reservations` WHERE date = " . " ' " .  $newDate . " ' ";

    $resultStandardTimeStamps = $connection->query($queryStandardTimeStamps)->fetchAll(PDO::FETCH_CLASS, '\\Classes\\DateOptions');
    $resultReservations = $connection->query($query)->fetchAll();

    $resultsArray[] = [];

    $rowsStandardTimeStamps = array();
    $rowsReservedTimeStamps = array();
    foreach($resultReservations as $reservation){

        $rowsReservedTimeStamps[$reservation['date_id']] = $reservation;
    }
    foreach($resultStandardTimeStamps as $row)
    {
        if($resultReservations != null || $resultReservations != []){
            if(!array_key_exists($row->ID, $rowsReservedTimeStamps)){
                $resultsArray[] = $row;
            }
        }
        if(empty($rowsReservedTimeStamps)){
            $object = (object) [
                'id' => $row->id,
                'Timestamp' => $row->Timestamp,
            ];
            $resultsArray[] = $object;
        }

    }
    echo (json_encode($resultsArray));
?>