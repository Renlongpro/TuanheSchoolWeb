<?php
    require($_SERVER['DOCUMENT_ROOT'].'/Data/PHP/Server.php');
    session_start();
    echo $_SESSION["UID"];
?>