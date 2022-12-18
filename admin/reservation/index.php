<?php
//require_once "../controllers/reservation.php";
session_start();

if($_SESSION['Level'] !== '1'){
    header("location: /reserveringssysteem");
}
//include "../../config.php";

include "../controllers/reservation.php";

?>
<?php if (isset($formattedReservation)) {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Date: <?= date('d-m-Y', strtotime($formattedReservation->date)) ?>|| Maak reservering</title>

    <!--Jquery-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .header{
            background-image: url("../../assets/img/mazdaLogo.png");
            background-size: contain;
            background-repeat: no-repeat;
            height: 200px;
        }
    </style>
</head>
<body>
<div class="container" >
    <div class="row h-100 align-items-center main-div">
        <div class="col-md-6 main-div" style="background-color: white; border-radius: 10px;">
            <div class="row justify-content-center">
                <div class="col-md-5  header">
                </div>
            </div>
            <form style="padding: 10px" method="post">
                <div class="modal-header">
                    <h1>Overzicht afspraak:</h1>
                </div>
                <hr class="col-md-12">
                <div class="row" style="padding: 10px" >
                    <h4 class="col-md-6">Datum:</h4><input style="border: none"  name="date" value="<?= date('d-m-Y', strtotime($formattedReservation->date)) ?>" class="col-md-6"/>
                </div>
                <div class="row" style="padding: 10px" >
                    <h4 class="col-md-6">Tijdsvak:</h4><select style="border: none" name="timestamp" class="col-md-6" id="timestamp"></select>
                </div>
                <div class="row " style="padding: 10px" >
                    <h4 class="col-md-6">Gebruiker:</h4><select style="border: none" class="col-md-6" name="user" id="user"></select>
                </div>
                <div class="row " style="padding: 10px" >
                    <h4 class="col-md-6">Opmerking:</h4><textarea style="border: none" name="remark" id="remark" class="col-md-6"><?= $formattedReservation->remarks ?></textarea>
                </div>
                <div style="position: relative" class="col-md-12" id="message">
                </div>
                <div class="row justify-content-center">
                    <hr class="col-md-12"/>
                </div>
                <div class="form-group">
                    <button type="submit" style="float: right" class="btn btn-primary  my-4">Bevestig reservering</button>
                    <a class="btn my-4" style="color: black; float: right" href="/reserveringssysteem/admin/overview">Terug naar overzicht</a>
                </div>
                <input type="hidden" id="date" name="date" value="<?= $formattedReservation->date ?>">
            </form>
        </div>
    </div>
</div>
</body>
</html>
    <script>
        $.ajax({
            url: "/reserveringssysteem/admin/controllers/userController.php",
            type: "get", //send it through get method
            success: function(data) {
                data = JSON.parse(data);
                data.forEach((item, index)=>{
                    if(!Array.isArray(item)){
                        let selectRow = document.createElement("option");
                        selectRow.setAttribute("value", item.id);
                        if(<?= $formattedReservation->getUserId()->id ?> == item.id){
                            selectRow.setAttribute('selected', 'selected');
                        }
                        selectRow.innerHTML = item.firstName + " " + item.middleName + " " + item.lastName;
                        document.getElementById('user').appendChild(selectRow);
                    }
                })
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });
        $.ajax({
            url: "/reserveringssysteem/admin/controllers/reservationController.php?getDateOptions=1",
            type: "get", //send it through get method
            success: function(data) {
                data = JSON.parse(data);
                data.forEach((item, index)=>{
                    if(!Array.isArray(item)){
                        let selectRow = document.createElement("option");
                        selectRow.setAttribute("value", item.id);
                        if(<?= $formattedReservation->getDateId()->id ?> == item.id){
                            selectRow.setAttribute('selected', 'selected');
                        }
                        selectRow.innerHTML = item.Timestamp;
                        document.getElementById('timestamp').appendChild(selectRow);
                    }
                })
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });

        $('form').submit(function (event) {
            event.preventDefault();
            document.getElementById('message').innerHTML = "";
            let formData = {
                remark: document.getElementById('remark').value ?? "",
                id: <?= $formattedReservation->id ?>,
                date: document.getElementById('date').value,
                user: document.getElementById('user').value,
                timeStamp: document.getElementById('timestamp').value,
                encode: true,
                type: 'patch'
            };
            $.ajax({
                type: 'post',
                url: '/reserveringssysteem/admin/controllers/reservationController.php?',
                data: formData,
                dataType: "json",
                encode: true
            }).done(function (data) {
                if(!data.success){
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-danger");
                    newdiv.innerHTML = data.errors;
                    document.getElementById('message').appendChild(newdiv)
                }else{
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-success");
                    newdiv.innerHTML = "De reservering is succesvol geupdate!";
                    document.getElementById('message').appendChild(newdiv);
                }

            })
        })
    </script>
<?php }else{
    header('Location /admin');
    exit();
} ?>