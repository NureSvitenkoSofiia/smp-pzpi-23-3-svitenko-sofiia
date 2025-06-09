<?php
require_once("initializeApp.php");
require_once("classes.php");

function getCartItems()
{
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

function hasCartItems()
{
    if (!isset($_SESSION['cart'])) {
        return false;
    }

    foreach ($_SESSION['cart'] as $productId => $quantity) {
        if ($quantity > 0) {
            return true;
        }
    }

    return false;
}

if (isset($_POST['remove_item']) && isset($_POST['product_id'])) {
    $productToRemove = intval($_POST['product_id']);

    if (array_key_exists($productToRemove, $_SESSION['cart'])) {
        unset($_SESSION['cart'][$productToRemove]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_POST['clear_cart']) || isset($_POST['checkout'])) {
    unset($_SESSION['cart']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shopping Cart - Online Store">
    <title>Ваш Кошик | Онлайн Магазин</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/style.css">

    <style>
        .cart-table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .remove-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .empty-cart-message {
            text-align: center;
            padding: 20px;
        }

        .shop-link {
            color: #3498db;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php require("header.php"); ?>

    <div class="content">
        <h1>Кошик Покупок</h1>

        <?php if (hasCartItems()): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>ID Товару</th>
                        <th>Найменування</th>
                        <th>Ціна за одиницю</th>
                        <th>Кількість</th>
                        <th>Загальна вартість</th>
                        <th>Управління</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cartTotal = 0;
                    foreach (getCartItems() as $productId => $quantity):
                        if ($quantity <= 0 || !isset($program->products[$productId])) {
                            continue;
                        }

                        $product = $program->products[$productId];
                        $itemTotal = $product->price * $quantity;
                        $cartTotal += $itemTotal;
                    ?>
                        <tr>
                            <td><?= $productId ?></td>
                            <td><?= htmlspecialchars($product->name) ?></td>
                            <td>$<?= number_format($product->price, 2) ?></td>
                            <td><?= $quantity ?></td>
                            <td>$<?= number_format($itemTotal, 2) ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="product_id" value="<?= $productId ?>">
                                    <button type="submit" name="remove_item" class="remove-btn">
                                        <i class="fas fa-trash-alt"></i> Видалити
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Загальна сума:</strong></td>
                        <td><strong>$<?= number_format($cartTotal, 2) ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" style="text-align: center; margin-top: 20px;">
                <button type="submit" name="clear_cart" class="remove-btn" style="margin-right: 10px;">
                    <i class="fas fa-times-circle"></i> Скасувати
                </button>
                <button type="submit" name="checkout" class="remove-btn" style="background-color: #2ecc71;">
                    <i class="fas fa-shopping-cart"></i> Купити
                </button>
            </form>
        <?php else: ?>
            <div class="empty-cart-message">
                <p>Ваш кошик порожній.</p>
                <p><a href="products.php" class="shop-link">Перейти до каталогу товарів</a></p>
            </div>
        <?php endif; ?>
    </div>

    <?php require("footer.php"); ?>
</body>

</html>