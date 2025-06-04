<?php
session_start();

include_once('./profile.php');
include_once('./credentials.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['username']);
    unset($_SESSION['authorized_at']);
    unset($credentials);
    unset($_SESSION['cart']);
    unset($_SESSION['profile']);
    unset($profile);

    header("Location: ../index.php?page=loginpage");
}
