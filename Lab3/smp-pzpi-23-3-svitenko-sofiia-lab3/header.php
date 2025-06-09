<header class="main-header">
    <nav class="navigation-menu">
        <ul>
            <li><a href="index.php" class="nav-link"><i class="fas fa-home"></i> Головна</a></li>
            <li><a href="products.php" class="nav-link"><i class="fas fa-box-open"></i> Каталог</a></li>
            <li><a href="cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i> Кошик</a></li>
        </ul>
    </nav>
</header>

<style>
    .main-header {
        background-color: #f8f9fa;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        padding: 15px 0;
        width: 100%;
    }
    
    .navigation-menu ul {
        display: flex;
        justify-content: center;
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    
    .navigation-menu li {
        margin: 0 20px;
    }
    
    .nav-link {
        color: #333;
        text-decoration: none;
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        font-weight: 500;
        transition: color 0.3s;
        display: flex;
        align-items: center;
    }
    
    .nav-link:hover {
        color: #3498db;
    }
    
    .nav-link i {
        margin-right: 8px;
        font-size: 18px;
    }
</style>