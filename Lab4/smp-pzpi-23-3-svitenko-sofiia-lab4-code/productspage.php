<?php
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
        header("Location: ./index.php?page=productspage");
        exit();
    }

    foreach ($touched as $id => $value) {
        if ($value > 0) {
            $_SESSION['cart'][$id] = $value;
        }
    }

    unset($_SESSION['form_error'], $_SESSION['form_data']);
    header("Location: ./index.php?page=cartpage");
    exit();
}
?>

<?php
    if(!isset($_SESSION['username'])){
        header("Location: ./index.php?page=loginpage");
    }
?>

<link rel="stylesheet" href="./styles/products.css">

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



<?php
unset($_SESSION['form_error'], $_SESSION['form_data']);
?>