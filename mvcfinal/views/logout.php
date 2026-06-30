<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

unset($_SESSION["logged_in"]);
unset($_SESSION["site_id"]);
unset($_SESSION["username"]);

header('Location: index.php');
exit;
?>