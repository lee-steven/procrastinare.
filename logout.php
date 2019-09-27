<?php
    //Logout current user
    session_start();
    session_destroy();
    header('Location: home.php');
?>