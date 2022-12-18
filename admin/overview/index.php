<?php
session_start();

if($_SESSION['Level'] !== '1'){
    header ("location: /reserveringssysteem");
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../assets/css/index.css">
    <link rel="stylesheet" href="../../assets/css/CalendarPicker.style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/pop    per.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Admin overview || Reserveren</title>

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
<div class="container-fluid">
    <div class=" row h-100 align-items-center main-div">
    </div>
</div>
<!-- Modal -->
<div class="modal fade"  id="exampleModal" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Overzicht afspraken per dag</h5>
            </div>
            <div class="modal-body">
                <div id="showcase-wrapper">
                    <div id="myCalendarWrapper"></div>
                    <div id="example">
                        <h3>Afspraken vandaag:
                            <p id="current-datestring"></p>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#exampleModal").modal('show');
    });
</script>
<script>
    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
    })
</script>

<script src="../../CalendarPicker.js"></script>

<script>
    const nextYear = new Date().getFullYear() + 1;
    const myCalender = new CalendarPicker('#myCalendarWrapper', {
        // If max < min or min > max then the only available day will be today.
        min: new Date(),
        max: new Date(nextYear, 10), // NOTE: new Date(nextYear, 10) is "Nov 01 <nextYear>"
        locale: 'en-US', // Can be any locale or language code supported by Intl.DateTimeFormat, defaults to 'en-US'
        showShortWeekdays: true // Can be used to fit calendar onto smaller (mobile) screens, defaults to false
    });

    const currentToDateString = document.getElementById('current-datestring');

    $.ajax({
        url: "/reserveringssysteem/admin/controllers/getReservations.php",
        type: "get", //send it through get method
        data: {
            date: myCalender.value.toLocaleDateString()
        },
        success: function(data) {
            currentToDateString.innerHTML = "";
            data = JSON.parse(data);
            data.forEach((item, index)=>{
                if(!Array.isArray(item)){
                    let newdiv = document.createElement("h4");
                    newdiv.setAttribute("class", "col-md-12");
                    newdiv.innerHTML = item.date_id.Timestamp + " " + item.user_id.firstName + " " + item.user_id.middleName + " " + item.user_id.lastName;
                    let ahref = document.createElement('a');
                    ahref.setAttribute('href', "/reserveringssysteem/admin/reservation/?id=" + item.id);
                    ahref.setAttribute('class', "a-button");
                    ahref.setAttribute("style", "font-size: 1rem;");
                    ahref.innerHTML = "Bekijk afspraak"
                    currentToDateString.appendChild(newdiv)
                    document.getElementById('current-datestring').appendChild(ahref);
                }
            })
        },
        error: function(xhr) {
            //Do Something to handle error
        }
    });
    myCalender.onValueChange((currentValue) => {
        $.ajax({
            url: "/reserveringssysteem/admin/controllers/getReservations.php",
            type: "get", //send it through get method
            data: {
                date: myCalender.value.toLocaleDateString()
            },
            success: function(data) {
                currentToDateString.innerHTML = "";
                data = JSON.parse(data);
                if(data.length === 0){
                    let newdiv = document.createElement("h4");
                    newdiv.setAttribute("class", "col-md-12");
                    newdiv.setAttribute("style", "margin-left: 5px; margin-left: 0px;");
                    newdiv.innerHTML = 'Geen afspraken gepland vandaag!';
                    currentToDateString.appendChild(newdiv)
                }else{
                    data.forEach((item, index)=>{
                        if(!Array.isArray(item)){
                            let newdiv = document.createElement("h4");
                            newdiv.setAttribute("class", "col-md-12");
                            newdiv.setAttribute("style", "margin-left: 5px; margin-left: 0px;");
                            newdiv.innerHTML = item.date_id.Timestamp + " " + item.user_id.firstName + " " + item.user_id.middleName + " " + item.user_id.lastName;
                            let ahref = document.createElement('a');
                            ahref.setAttribute('href', "/reserveringssysteem/admin/reservation/?id=" + item.id);
                            ahref.setAttribute('class', "a-button");
                            ahref.setAttribute("style", "font-size: 1rem;")
                            ahref.innerHTML = "Bekijk afspraak"
                            currentToDateString.appendChild(newdiv)
                            document.getElementById('current-datestring').appendChild(ahref);
                        }
                    })
                }
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });

    });
</script>

</body>
</html>
