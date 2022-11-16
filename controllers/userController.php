<?php
session_start();
    if($_GET['data'] === 'getSessionInfo'){
        $data = [];
        $data['success'] = true;
        if($_SESSION['Email']){
            $data['loggedIn'] = true;
        }else{
            $data['loggedIn'] = false;
        }
        echo json_encode($data);
    }
    if($_GET['data'] === 'logOut'){
        $data = [];
        $_SESSION['Email'] = null;
        $_SESSION['Level'] = null;
        session_destroy();
        $data['success'] = true;
        echo json_encode($data);
    }

?>