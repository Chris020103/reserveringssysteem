<?php
require "../../config.php";
require "../../classes/DateOptions.php";

$data = ['errors' => " ", "success" => false];
if(isset($_GET['getDateOptions'])){
    try{
        $timeStampsArray = [];
        $timestampResults = [];
        $reservationQuery = "SELECT * FROM `standardDateOptions`";
        $dateOptions = $connection->query($reservationQuery)->fetchAll(PDO::FETCH_CLASS, "\\Classes\\DateOptions");

        echo json_encode($dateOptions);
    }catch (Exception $e){
        return $e->getMessage();
    }
}
if($_POST){
    if($_POST['type'] === 'patch'){
        try{
            $id = $_POST['id'];
            $dateId = $_POST['timeStamp'];
            $user = $_POST['user'];
            $date = $_POST['date'];
            $remark = $_POST['remark'];

            $sql = "UPDATE reservations SET date_id=?, user_id=?, date=?, remarks=? WHERE id=?";
            $stmt= $connection->prepare($sql);

            if ($stmt->execute([$dateId, $user, $date, $remark, $id])) {
                $data['success'] = true;
            }
        }catch (Exception $e){
            $data['errors'] = "Er ging iets fout bij het updaten";
        }

        echo json_encode($data);
    }
}


?>