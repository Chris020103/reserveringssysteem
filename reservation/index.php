<?php
    include "../config.php";
    session_start();

    if(!$_SESSION['Email']){
        header( "Location: /reserveringssysteem/login" );
    }
    $getTimestamp = "SELECT * FROM `standardDateOptions` WHERE ID =" . $_GET['id'];

    $getUserInfo = "SELECT * FROM `user` WHERE id =" . $_SESSION['UserId'];

    $userInfoResult = mysqli_query($mysqli, $getUserInfo);
    $getTimeStampInfo = mysqli_query($mysqli, $getTimestamp);

    if (mysqli_num_rows($getTimeStampInfo) > 0) {
        $timeStamp = mysqli_fetch_array($getTimeStampInfo);
    }

    if (mysqli_num_rows($userInfoResult) > 0) {
        $user = mysqli_fetch_array($userInfoResult);
    }
    $date = $_GET['date'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Date: <?php echo $_GET['date'] ?> || Maak reservering</title>

    <!--Jquery-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .header{
            background-image: url("../assets/img/mazdaLogo.png");
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
            <div class="modal-header">
                <h1>Maak reservering voor:</h1>
            </div>
            <hr class="col-md-12">
            <div class="row">
                <h3 class="col-md-3">Datum:</h3><p class="col-md-8"><?php echo $_GET['date'] ?></p>
            </div>
            <div class="row">
                <h4 class="col-md-3">Tijdsvak:</h4><p class="col-md-8"> <?php echo $timeStamp['Timestamp'] ?></p>
            </div>
            <div class="row">
                <h4 class="col-md-3">Naam:</h4><p class="col-md-8"> <?php echo $user['firstName'] . " " .  $user['middleName'] . " " . $user['lastName']?></p>
            </div>
            <div class="row">
                <h4 class="col-md-3">Email:</h4><p class="col-md-8"><?php echo $user['email']?></p>
            </div>
            <div style="position: relative" class="col-md-12" id="message">
            </div>
            <div class="row justify-content-center">
                <hr class="col-md-12"/>
            </div>
            <form method="post">
                <input type="hidden" value="<?php echo $date ?>" id="date">

                <div class="form-group">
                    <label for="remark">Voeg hier een opmerking toe:</label>
                    <textarea class="form-control col-md-8 col-md-offset-1" maxlength="255" name="remark" id="remark"></textarea>
                    <button type="submit" style="float: right" class="btn btn-primary  my-4">Bevestig reservering</button>
                    <button type="button" onclick="backToOverview()" style="float: right" class="btn  my-4">Terug naar overzicht</button>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
</html>

<script>
    $('form').submit(function (event) {
        event.preventDefault();
        let formData = {
            remark: document.getElementById('remark').value ?? "",
            id: <?php echo $_GET['id'] ?>,
            date: document.getElementById('date').value
        };
        $.ajax({
            type: 'post',
            url: '/reserveringssysteem/controllers/reservationController.php',
            data: formData,
            dataType: "json",
            encode: true
        }).done(function (data) {
            console.log(data.errors);
                if(!data.success){
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-danger");
                    newdiv.innerHTML = data.errors;
                    document.getElementById('message').appendChild(newdiv)
                }else{
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-success");
                    newdiv.innerHTML = "De reservering is succesvol aangemaakt, u ontvangt binnen 2 uur een bevestigingsmail!";
                    document.getElementById('message').appendChild(newdiv);
                }

        })
    })

    function backToOverview(){
        window.location.href = '/reserveringssysteem/';
    }


</script>