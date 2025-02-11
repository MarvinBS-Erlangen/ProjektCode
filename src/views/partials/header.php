<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

function getCartCount()
{
    return array_sum($_SESSION['warenkorb_Produkt']);
}
?>

<header class="header">
    <div class="header-title">
        <span id="title" class="title"><a href="./home.php">MACaPPLE</a></span>
    </div>
    <div class="nav-links">
        <ul class="nav-list">
            <li class="btn-menus"><a href="./menus.php">Menus</a></li>
            <li class="btn-products"><a href="./products.php">Products</a></li>
            <li class="btn-contest"><a href="./contest.php">Contest</a></li>
            <li class="btn-login"><a href="./login.php">Login</a></li>
            <li class="btn-signup"><a href="./register.php">Sign Up</a></li>
        </ul>
    </div>
    <div class="cart-container">
        <i class="fa-solid fa-cart-shopping cart-icon"></i>
        <span id="cart-count"><?php echo getCartCount(); ?></span>
    </div>
</header>
