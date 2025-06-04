<?php
include_once("classes.php");
$program = new GroceryStore();

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    
        foreach ($program->products as $id => $item) {
            $_SESSION['cart'][$id] = 0;
        }
    }
}
?>