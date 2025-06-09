<?php
require_once("initializeApp.php");
require_once("classes.php");
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
    
    <style>
        .hero-section {
            text-align: center;
            padding: 50px 20px;
        }
        
        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 40px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .cta-button:hover {
            background-color: #2980b9;
        }
        
        .feature-section {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 60px;
        }
        
        .feature-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            max-width: 300px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 36px;
            color: #3498db;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php require("header.php"); ?>
    
    <div class="content">
        <section class="hero-section">
            <h1 class="hero-title">Вітаємо в нашому інтернет-магазині</h1>
            <p class="hero-subtitle">Знайдіть все необхідне для вашого комфорту</p>
            
            <a href="products.php" class="cta-button">
                <i class="fas fa-shopping-basket"></i> Перейти до покупок
            </a>
        </section>
        
        <section class="feature-section">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Швидка доставка</h3>
                <p>Отримайте ваше замовлення в найкоротші терміни</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3>Найкращі ціни</h3>
                <p>Ми пропонуємо конкурентні ціни на весь асортимент</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Підтримка клієнтів</h3>
                <p>Наша команда завжди готова допомогти вам</p>
            </div>
        </section>
    </div>
    
    <?php require("footer.php"); ?>
</body>
</html>