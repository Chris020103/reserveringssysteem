<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Reserveren</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


</head>
<body>
<div class="container-fluid">
    <div class=" row h-100 align-items-center main-div">
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Inloggen</h5>
            </div>
            <div class="modal-body">
                <div id="showcase-wrapper">
                    <form method="POST">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example1">Email address</label>
                            <input type="email" name="email" id="email" class="form-control" />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form2Example2">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>

                        <button type="submit" class="btn btn-primary btn-block col-md-12">Sign in</button>

                        <!-- Register buttons -->
                        <div class="text-center">
                            <p>Not a member? <a href="#!">Register</a></p>
                        </div>
                        <div id="fault">
                        </div>
                    </form>
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

     $('form').submit(function (event)  {
         event.preventDefault();
         let formData = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };
        $.ajax({
            type: 'POST',
            url: '/reserveringssysteem/controllers/inlogController.php',
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            document.getElementById('fault').innerHTML = "";

            if(!data.success){
                let newdiv = document.createElement("div");
                newdiv.setAttribute("class", "alert alert-danger");
                newdiv.innerHTML = "Gebruikersnaam en/of wachtwoord verkeerd!";
                document.getElementById('fault').appendChild(newdiv)
            }else{
                let newdiv = document.createElement("div");
                newdiv.setAttribute("class", "alert alert-success");
                newdiv.innerHTML = "U bent succesvol ingelogd! U wordt over 3 seconden doorverwezen.";
                document.getElementById('fault').appendChild(newdiv);
                setTimeout(function(){
                    window.location.href = '/reserveringssysteem/';
                }, 3000);
            }
        })

     });
</script>

</body>
</html>