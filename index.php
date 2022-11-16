<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/CalendarPicker.style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Kies tijdsvak || Reserveren</title>

    <style>
        .header{
            background-image: url("./assets/img/mazdaLogo.png");
            background-size: contain;
            background-repeat: no-repeat;
            height: 200px;
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0">
        <?php
        require_once "./components/navbar.php";
        ?>
        <div class=" row align-items-center align-middle main-div">
            <div class="col-md-6 main-div text-center">
                <h1 class="text-white">De Mazda CX-60</h1>
                <h2 class="text-white">Reserveer hieronder voor een proefrit met de nieuwste Mazda CX-60</h2>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Reserveer
                </button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="row justify-content-center">
                    <div class="col-md-5  header">
                    </div>
                    <hr class="col-md-12"/>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datum selecteren</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="showcase-wrapper">
                        <div id="myCalendarWrapper"></div>
                        <div id="example">
                            <h3>Beschikbare tijden:
                                <p id="current-datestring"></p>
                            </h3>
                        </div>
                    </div>
                    <script src="CalendarPicker.js"></script>
                    <div id="fault">
                    </div>
                </div>
                <div class="modal-footer">
                    <div id="logout">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var myModal = document.getElementById('myModal')
        var myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', function () {
            myInput.focus()
        })
    </script>

    <script src="CalendarPicker.js"></script>

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
            url: "/reserveringssysteem/controllers/getDateOptions.php",
            type: "get", //send it through get method
            data: {
                date: myCalender.value.toLocaleDateString()
            },
            success: function(data) {
                currentToDateString.innerHTML = "";

                data = JSON.parse(data);
                data.forEach((item, index)=>{
                    if(!Array.isArray(item)){
                            let newdiv = document.createElement("button");
                            newdiv.setAttribute("class", "btn btn-primary");
                            newdiv.setAttribute("type", "button");
                            newdiv.setAttribute('id', item.ID)
                            newdiv.setAttribute("style", "margin-left: 5px;");
                            newdiv.setAttribute('onclick','makeReservation();'); // for FF
                            newdiv.onclick = function() {makeReservation(item.ID, myCalender.value.toLocaleDateString());}; // for IE
                            newdiv.innerHTML = item.TimeStamp;
                            currentToDateString.appendChild(newdiv)
                    }
                })
            },
            error: function(xhr) {
                //Do Something to handle error
            }
        });
        myCalender.onValueChange((currentValue) => {
            $.ajax({
                url: "/reserveringssysteem/controllers/getDateOptions.php",
                type: "get", //send it through get method
                data: {
                    date: myCalender.value.toLocaleDateString()
                },
                success: function(data) {
                    currentToDateString.innerHTML = "";
                    document.getElementById('fault').innerHTML = "";
                    data = JSON.parse(data);
                    data.forEach((item, index)=>{
                        if(!Array.isArray(item)){
                                let newdiv = document.createElement("button");
                                newdiv.setAttribute("class", "btn btn-primary");
                                newdiv.setAttribute("type", "button");
                                newdiv.setAttribute('id', item.ID)
                                newdiv.setAttribute("style", "margin-left: 5px;");
                                newdiv.setAttribute('onclick','makeReservation();'); // for FF
                                newdiv.onclick = function() {makeReservation(item.ID, myCalender.value.toLocaleDateString());}; // for IE
                                newdiv.innerHTML = item.TimeStamp;
                                currentToDateString.appendChild(newdiv)
                        }
                    })

                },
                error: function(xhr) {
                    //Do Something to handle error
                }
            });

        });

        function makeReservation(id, date) {
            $.ajax({
                url: "/reserveringssysteem/controllers/userController.php",
                type: "get", //send it through get method
                data: {
                    data: "getSessionInfo"
                }

            }).done(function (data){
                document.getElementById('fault').innerHTML = "";
                document.getElementById('logout').innerHTML = "";

                data = JSON.parse(data);
                if(data.loggedIn){
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-success");
                    newdiv.setAttribute("id", "alert-div");
                    newdiv.innerHTML = "U bent al ingelogd, wilt u dit tijdsvak reserveren?";
                    newdiv.innerHTML += "</br>";
                    let ahref = document.createElement('a');
                    ahref.setAttribute('href', "/reserveringssysteem/reservation/?id=" + id + "&date=" + date);
                    ahref.setAttribute('class', "a-button");
                    ahref.innerHTML = "Dit tijdsvak reserveren"
                    document.getElementById('fault').appendChild(newdiv);
                    document.getElementById('alert-div').appendChild(ahref);

                    let LogoutButton = document.createElement("button");
                    LogoutButton.setAttribute('class', 'btn');
                    LogoutButton.setAttribute('type', 'button');
                    LogoutButton.setAttribute('onclick','logOut();'); // for FF
                    LogoutButton.onclick = function() {logOut()}; // for IE
                    LogoutButton.innerHTML = ('Uitloggen');
                    document.getElementById('logout').appendChild(LogoutButton);
                    data.loggedIn = false;

                }else{
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-danger");
                    newdiv.innerHTML = "U bent nog niet ingelogd, wilt u inloggen?";
                    newdiv.setAttribute("id", "alert-div");
                    newdiv.innerHTML += "</br>";
                    let ahref = document.createElement('a');
                    ahref.setAttribute('href', "/reserveringssysteem/login");
                    ahref.setAttribute('class', "a-button");
                    ahref.innerHTML = "Inloggen"
                    document.getElementById('fault').appendChild(newdiv)
                    document.getElementById('alert-div').appendChild(ahref);
                }
            });
        }

        function logOut () {
            $.ajax({
                url: '/reserveringssysteem/controllers/userController.php',
                type: 'get',
                data: {
                    data: 'logOut'
                }
            }).done(function (data){

                data = JSON.parse(data);
                document.getElementById('fault').innerHTML = "";
                document.getElementById('fault').innerHTML = "";

                if(data.success){
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-danger");
                    newdiv.innerHTML = "U bent nog niet ingelogd, wilt u inloggen?";
                    newdiv.setAttribute("id", "alert-div");
                    newdiv.innerHTML += "</br>";
                    let ahref = document.createElement('a');
                    ahref.setAttribute('href', "/reserveringssysteem/login");
                    ahref.setAttribute('class', "a-button");
                    ahref.innerHTML = "Inloggen"
                    document.getElementById('fault').appendChild(newdiv)
                    document.getElementById('alert-div').appendChild(ahref);
                }else{
                    let newdiv = document.createElement("div");
                    newdiv.setAttribute("class", "alert alert-danger");
                    newdiv.innerHTML = "Er is wat fout gegaan tijdens het uitloggen";
                    newdiv.setAttribute("id", "alert-div");
                    document.getElementById('fault').appendChild(newdiv)
                }
            })
        }
    </script>

</body>
</html>