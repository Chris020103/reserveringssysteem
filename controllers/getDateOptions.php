<?php
    include "../config.php";

    $date = $_GET['date'];

    $newDate = date('Y-m-d', strtotime($date));

    $queryStandardTimeStamps = "SELECT * FROM `standardDateOptions`";

    $query = "SELECT * FROM `reservations` WHERE date = " . " ' " .  $newDate . " ' ";

    $resultStandardTimeStamps = mysqli_query($mysqli, $queryStandardTimeStamps);

    $resultReservations = mysqli_query($mysqli, $query);

    $resultsArray[] = [];

    $rowsStandardTimeStamps = array();
    $rowsReservedTimeStamps = array();

    while ($row = mysqli_fetch_array($resultStandardTimeStamps)) {
            $rowsStandardTimeStamps[] = $row;

    }
    while ($reservation = mysqli_fetch_array($resultReservations)) {
        $rowsReservedTimeStamps[] = $reservation['date_id'];
    }
    foreach($rowsStandardTimeStamps as $row)
    {
        if($rowsReservedTimeStamps != null || $rowsReservedTimeStamps != [] || !empty($rowsReservedTimeStamps)){
                if(!in_array($row['ID'] ,$rowsReservedTimeStamps) ){
                        $object = (object) [
                            'ID' => $row['ID'],
                            'TimeStamp' => $row['Timestamp'],
                        ];
                        $resultsArray[] = $object;
                }
        }
        if(empty($rowsReservedTimeStamps)){
            $object = (object) [
                'ID' => $row['ID'],
                'TimeStamp' => $row['Timestamp'],
            ];
            $resultsArray[] = $object;
        }

    }
    echo (json_encode($resultsArray));
?>