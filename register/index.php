<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Register</title>

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
                    <h1>Register</h1>
                </div>
                <hr class="col-md-12">
                <h3 class="col-md-12">Gegevens</h3>
                <form method="post">
                    <div class="row">
                        <label for="firstName" class="col-md-6">Voornaam:</label><input type="text" name="firstName" id="firstName" class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <label for="middleName" class="col-md-6">Tussenvoegsel:</label><input type="text" name="middleName" id="middleName" class="col-md-6">
                    </div>
                    <div class="row">
                        <label for="lastName" class="col-md-6">Achternaam:</label><input type="text" name="lastName" id="lastName" class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <label for="email" class="col-md-6">Email:</label><input name="email" id="email" type="email" class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <label for="password" class="col-md-6">Password:</label><input autocomplete="true" name="password" id="password" type="password" class="col-md-6" required/>
                    </div>
                    <div class="row" >
                        <h3 class="col-md-12">Auto gegevens</h3>
                    </div>
                    <div class="row">
                        <label for="brand" class="col-md-6">Merk:</label><input type="text" name="brand" id="brand" class="col-md-6" required/>
                    </div>
                    <div class="row">
                        <label for="model" class="col-md-6">Model:</label><input type="text" name="model" id="model" class="col-md-6" required>
                    </div>
                    <div class="row">
                        <label for="licensePlate" class="col-md-6">Kenteken:</label><input type="text" name="licensePlate" id="licensePlate" class="col-md-6" required/>
                    </div>

                    <div style="position: relative" class="col-md-12" id="message">
                    </div>
                    <div class="row justify-content-center">
                        <hr class="col-md-12"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" style="float: right" class="btn btn-primary  my-4">Maak account aan</button>
                    </div>
                </form>

        </div>
    </div>
</div>

<script>
    $('form').submit(function (event) {
        event.preventDefault();
        let formData = {
            firstName: document.getElementById('firstName').value,
            middleName: document.getElementById('middleName').value ?? "",
            lastName: document.getElementById('lastName').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            brand: document.getElementById('brand').value,
            model: document.getElementById('model').value,
            licensePlate: document.getElementById('licensePlate').value,
            type: 'register'
        };
        $.ajax({
            type: 'post',
            url: '/reserveringssysteem/controllers/registerController.php?',
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
                newdiv.innerHTML = "De reservering is succesvol aangemaakt, u ontvangt binnen 2 uur een bevestigingsmail!";
                document.getElementById('message').appendChild(newdiv);
            }

        })
    })


</script>
</body>
</html>
