<?php
require_once("initializeApp.php");
require_once("classes.php");

function isValidQuantity($value)
{
    return is_numeric($value) && intval($value) > 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    $quantities = $_POST['quantities'];
    $touched = [];
    $isInvalid = false;
    foreach ($quantities as $productId => $qty) {
        $qty = trim($qty);

        if ($qty == 0) {
            continue;
        }
        if (!isValidQuantity($qty)) {
            $isInvalid = true;
        }

        $touched[intval($productId)] = $qty;
    }

    if ($isInvalid) {
        $_SESSION['form_error'] = "Перевірте будь ласка введені дані";
        $_SESSION['form_data'] = $touched;
        header("Location: products.php");
        exit();
    }

    foreach ($touched as $id => $value) {
        if ($value > 0) {
            $_SESSION['cart'][$id] = $value;
        }
    }

    unset($_SESSION['form_error'], $_SESSION['form_data']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse our product catalog">
    <title>Каталог Товарів | Інтернет Магазин</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">
    
    <style>
        .product-catalog {
            width: 80%;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .product-catalog-title {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        
        .product-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .error-message {
            background-color: #ffdddd;
            color: #cc0000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .product-item {
            display: grid;
            grid-template-columns: 3fr 1fr 1fr;
            align-items: center;
            padding: 15px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .product-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .product-name {
            font-size: 18px;
            font-weight: 500;
        }
        
        .product-quantity {
            width: 70px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
        }
        
        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            text-align: right;
        }
        
        .add-to-cart-btn {
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-end;
        }
        
        .add-to-cart-btn:hover {
            background-color: #2980b9;
        }
        
        .add-to-cart-btn i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <?php require("header.php"); ?>
    
    <div class="content">
        <div class="product-catalog">
            <h1 class="product-catalog-title">Каталог Товарів</h1>
            
            <form method="POST" class="product-form">
                <?php if (isset($_SESSION['form_error'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['form_error'] ?>
                    </div>

                    <?php foreach ($_SESSION['form_data'] as $id => $badValue): ?>
                        <?php if (isset($program->products[$id])): ?>
                            <div class="product-item">
                                <div class="product-name"><?= htmlspecialchars($program->products[$id]->name) ?></div>
                                <input 
                                    type="number"
                                    name="quantities[<?= $id ?>]"
                                    value="<?= htmlspecialchars($badValue) ?>"
                                    min="-10"
                                    class="product-quantity">
                                <div class="product-price">$<?= number_format($program->products[$id]->price, 2) ?></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                <?php else: ?>
                    <?php foreach ($program->products as $id => $product): ?>
                        <div class="product-item">
                            <div class="product-name"><?= htmlspecialchars($product->name) ?></div>
                            <input 
                                type="number"
                                name="quantities[<?= $id ?>]"
                                value="0"
                                min="-10"
                                class="product-quantity">
                            <div class="product-price">$<?= number_format($product->price, 2) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-cart-plus"></i> Додати до кошика
                </button>
            </form>
        </div>
    </div>
    
    <?php require("footer.php"); ?>
</body>

<?php
unset($_SESSION['form_error'], $_SESSION['form_data']);
?>
</html>