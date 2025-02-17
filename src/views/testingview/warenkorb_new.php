<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/warenkorb_new.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Order Summary</title>
</head>

<body>

    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="container">

            <!-- Bestellübersicht -->
            <div class="section">
                <h2>Bestellübersicht</h2>
                <div class="order-list">
                    <!-- Product 1 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://assets-au-01.kc-usercontent.com/ab37095e-a9cb-025f-8a0d-c6d89400e446/17d49270-1b2a-4511-80a8-1c5dbd41e8c8/article-cat-vet-visit-guide.jpg" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Nachos Snackers</p>
                            <p class="item-price"><span class="old-price">15.99 €</span> <span class="new-price">12.99 €</span></p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Cheeseburger Menü</p>
                            <p class="item-price">8.49 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Pizza Margherita</p>
                            <p class="item-price">10.99 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Currywurst Menü</p>
                            <p class="item-price">7.99 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 5 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Veggie Wrap</p>
                            <p class="item-price">5.49 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 6 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Chicken Nuggets</p>
                            <p class="item-price">6.99 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 7 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">French Fries</p>
                            <p class="item-price">3.49 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                    <!-- Product 8 -->
                    <div class="item">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/100" alt="Produktbild">
                        </div>
                        <div class="item-details">
                            <p class="item-name">Fried Chicken Wings</p>
                            <p class="item-price">9.99 €</p>
                        </div>
                        <div class="quantity">
                            <button class="minus">-</button>
                            <span class="quantity-value">1</span>
                            <button class="plus">+</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Gesamtpreis -->
            <div class="total">
                <span class="total-label">Gesamt:</span>
                <span class="total-price">66.94 €</span>
            </div>

            <!-- Lieferadresse -->
            <div class="section">
                <h2>Lieferadresse</h2>
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Straße & Hausnummer">
                <input type="text" placeholder="PLZ & Stadt">
            </div>

            <!-- Zahlungsmethode -->
            <div class="section">
                <h2>Zahlungsmethode</h2>
                <select>
                    <option>Kreditkarte</option>
                    <option>PayPal</option>
                    <option>Rechnung</option>
                </select>
            </div>

            <!-- Bestellung abschließen -->
            <button class="checkout-button">Bestellung abschließen</button>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>

</body>

</html>
