<?php
    include_once("./credentials.php"); 
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        if($credentials['username'] != $_POST['username'] || $credentials['password'] != $_POST['password'])
        {
            $_SESSION['login_error'] = true;
            header("Location: ./index.php?page=loginpage");
            exit();
        }
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['authorized_at'] = time();

        header("Location: ./index.php?page=profilepage");
        exit();
    }
?>


<?php
    if(isset($_SESSION['login_error'])){
        echo "<p style='color:red'>Неправильні дані</p>";
    }

    unset($_SESSION['login_error']);
?>
<link rel="stylesheet" href="./styles/login.css">
<div style="margin: 20px auto;">
    <h1>Увійдіть в акаунт</h1>
</div>
<form method="POST" action="loginpage.php" id="login-form">
    <label for="username" id="username-label">Ім'я користувача</label>
    <input id="username" type="text" name="username" required>

    <label for="password" id="password-label">Пароль</label>
    <input id="password" type="password" name="password" required>

    <button type="submit" id="submit-button">Увійти в акаунт</button>
</form>
