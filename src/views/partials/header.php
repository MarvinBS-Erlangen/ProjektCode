<?php
// Datenbankverbindung herstellen
include '../database/connection.php';
// Start der Session / Sessions initialisieren, falls noch nicht gemacht
include '../comps/sessioncheck.php';

function getCartCount()
{
    return array_sum($_SESSION['warenkorb_Produkt']) + array_sum($_SESSION['warenkorb_Menue']);
}
?>

<header class="header">
    <div class="header-title">
        <span id="title" class="title"><a href="./home.php">MacApple</a></span>
    </div>
    <div class="nav-links">
        <ul class="nav-list">
            <li class="btn-menus"><a href="./menus.php">Menüs</a></li>
            <li class="btn-products"><a href="./products.php">Produkte</a></li>
            <li class="btn-contest"><a href="./contest.php">Wettbewerb</a></li>
        </ul>
    </div>

    <?php if (isset($_SESSION['UserID'])): ?>
        <!-- Zeige User Icon und Logout Button, wenn User eingeloggt ist -->
        <div class="user-actions">
            <ul class="user-list">
                <li class="btn-profile">
                    <a href="./user_profile.php">
                        <i class="fa-solid fa-user user-icon"></i>
                    </a>
                </li>
                <li class="btn-logout"><a href="logout.php" class="logout-button">Abmelden</a></li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Zeige Login und Sign Up, wenn User nicht eingeloggt ist -->
        <div class="guest-actions">
            <ul class="guest-list">
                <li class="btn-login">
                    <a href="./login.php" class="auth-button">Anmelden</a>
                </li>
                <li class="btn-signup">
                    <a href="./register.php" class="auth-button">Konto erstellen</a>
                </li>
            </ul>
        </div>
    <?php endif; ?>

    <div class="cart-container">
        <a href="./warenkorb.php"><i class="fa-solid fa-cart-shopping cart-icon"></i></a>
        <span id="cart-count"><?php echo getCartCount(); ?></span>
    </div>
</header>

<style>
.auth-button, .logout-button {
    display: inline-flex !important; /* Flexbox für bessere Button-Ausrichtung */
    align-items: center !important;
    justify-content: center !important;
    padding: 10px 22px !important; /* Noch größere Buttons */
    min-width: 130px !important; /* Mindestbreite für größere Buttons */
    background-color: rgba(255, 255, 255, 0.3) !important;
    color: #fff !important;
    border: 2px solid transparent !important;
    border-radius: 25px !important; /* Etwas rundere Ecken */
    text-decoration: none !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important; /* Noch größere Schrift */
    text-align: center !important;
    transition: all 0.3s ease !important;
}

.auth-button:hover, .logout-button:hover {
    background-color: #fff !important;
    color: #4CAF50 !important;
    border-color: #fff !important;
}


</style>

