<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: AdminLogin.php");
    exit;

}

session_destroy();

session_regenerate_id();

header("Location:../../Admin.php");
exit;