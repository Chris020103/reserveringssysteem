<?php
    session_start();


?>
<style>
    .navbar-buttons{
        text-decoration: none;
        color: white !important;
        cursor: pointer;
    }
</style>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<nav class="navbar navbar-expand ">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end" id="navbarText">
            <div id="messages"></div>
            <span class="navbar-text " id="navbar-div">
                <?php
                if($_SESSION['UserId']){
                    ?>
                    <a href="./overview.php" class="navbar-buttons">Overzicht |</a>
                    <a onclick="logOut()" class="navbar-buttons">Uitloggen</a>
                    <?php
                }else{
                    ?>
                    <a href="./login" class="navbar-buttons">Inloggen</a>
                    <?php
                }
                ?>
            </span>
        </div>
    </div>
</nav>

<script>
        function logOut () {
            $.ajax({
                url: '/reserveringssysteem/controllers/userController.php',
                type: 'get',
                data: {
                    data: 'logOut'
                }
            })
        }
</script>