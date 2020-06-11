<?php
if(isset($_GET['location'])) {
    $location = trim($_GET['location']);
} else {
    $location = 'login.php';
}
session_start();
unset($_SESSION['username']);
unset($_SESSION['role']);
header("Location: {$location}");