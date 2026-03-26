<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /questionnaire/modules/auth/login.php");
    exit();
}
?>