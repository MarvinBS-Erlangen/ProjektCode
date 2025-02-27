<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';

function getCartCount()
{
    return array_sum($_SESSION['warenkorb_Produkt']) + array_sum($_SESSION['warenkorb_Menue']);
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
        </ul>
    </div>

    <?php if (isset($_SESSION['UserID'])): ?>
        <!-- Show User Icon and Logout Button if User is Logged In -->
        <div class="user-actions">
            <ul class="user-list">
                <li class="btn-profile">
                    <a href="./user_profile.php">
                        <i class="fa-solid fa-user user-icon"></i>
                    </a>
                </li>
                <li class="btn-logout"><a href="logout.php" class="logout-button">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Show Login and Signup if User is Not Logged In -->
        <div class="guest-actions">
            <ul class="guest-list">
                <li class="btn-login"><a href="./login.php">Login</a></li>
                <li class="btn-signup"><a href="./register.php">Sign Up</a></li>
            </ul>
        </div>
    <?php endif; ?>


    <div class="cart-container">
        <a href="./warenkorb.php"><i class="fa-solid fa-cart-shopping cart-icon"></i></a>
        <span id="cart-count"><?php echo getCartCount(); ?></span>
    </div>
</header>
