<link rel="stylesheet" href="./styles/header.css">
<header class="main-header">
    <nav class="navigation-menu">
        <ul>
            <li>
                <a href="./index.php?page=homepage" class="nav-link">
                    <i class="fas fa-home"></i> Головна
                </a>
            </li>
            <li>
                <a href="./index.php?page=productspage" class="nav-link">
                    <i class="fas fa-box-open"></i> Каталог
                </a>
            </li>

            <?php if (isset($_SESSION['username'])): ?>
                <li>
                    <a href="./index.php?page=cartpage" class="nav-link">
                        <i class="fas fa-shopping-cart" style="font-size:24px"></i> Кошик
                    </a>
                </li>
                <li>
                    <a href="./index.php?page=profilepage" class="nav-link">
                        <i class="fas fa-user" style="font-size:24px"></i> Профіль
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="./logout.php" method="POST" style="display:inline;">
                        <button type="submit" style="background:none; border:none; padding:0; cursor:pointer; font: inherit; color: inherit;">
                            <i class="fas fa-sign-out-alt" style="font-size:24px"></i> Вийти
                        </button>
                    </form>
                </li>
            <?php else: ?>
                <li>
                    <a href="./index.php?page=loginpage" class="nav-link">
                        <i class="fas fa-sign-in-alt" style="font-size:24px"></i> Логін
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>