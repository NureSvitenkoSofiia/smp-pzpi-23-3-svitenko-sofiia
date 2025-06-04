<footer class="site-footer">
    <div class="footer-links">
        <a href="index.php" class="footer-link">Головна</a>
        <span class="divider">|</span>
        <a href="products.php" class="footer-link">Товари</a>
        <span class="divider">|</span>
        <a href="cart.php" class="footer-link">Кошик</a>
    </div>
    <div class="copyright">
        &copy; <?= date('Y') ?> Online Store
    </div>
</footer>

<style>
    .site-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e7e7e7;
        padding: 20px 0;
        margin-top: auto;
        width: 100%;
        text-align: center;
    }
    
    .footer-links {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .footer-link {
        color: #333;
        text-decoration: none;
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        transition: color 0.3s;
    }
    
    .footer-link:hover {
        color: #3498db;
    }
    
    .divider {
        margin: 0 10px;
        color: #ccc;
    }
    
    .copyright {
        font-size: 12px;
        color: #777;
    }
</style>