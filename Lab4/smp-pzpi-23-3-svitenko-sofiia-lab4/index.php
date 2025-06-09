<?php
require_once("./db/dbaccess.php");
require_once("initializeApp.php");
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to our online store">
    <title>Інтернет Магазин - Головна</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
    <?php require("header.php"); ?>

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    switch ($page) {
        case "loginpage":
            require_once("loginpage.php");
            break;
        case "homepage":
            require_once("homepage.php");
            break;
        case "cartpage":
            require_once("cartpage.php");
            break;
        case "profilepage":
            require_once("profilepage.php");
            break;
        case "productspage":
            require_once("productspage.php");
            break;
        default:
            require_once("page404.php");
            break;
    }
    ?>
    </div>

    <?php require("footer.php"); ?>
</body>

</html>