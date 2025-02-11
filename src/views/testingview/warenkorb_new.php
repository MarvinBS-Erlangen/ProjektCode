<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/styles/reset.css">
    <link rel="stylesheet" href="../../public/styles/index.css">
    <link rel="stylesheet" href="../../public/styles/testingstyles/warenkorb_new.css">
    <link rel="stylesheet" href="../../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Order Summary</title>
</head>

<body>
    <main class="main">
        <?php include '../partials/header.php'; ?>

        <div class="container">
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Menu Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Menu Name</div>
                    <div class="item-price old-price">12.99 €</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>

            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">3</span>
                    <button class="plus">+</button>
                </div>
            </div>

            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>
            <div class="item">
                <div class="item-image">
                    <img src="../../public/assets/test1.png" alt="Product Image">
                </div>
                <div class="item-details">
                    <div class="item-name">Product Name</div>
                    <div class="item-price new-price">10.99 €</div>
                </div>
                <div class="quantity">
                    <button class="minus">-</button>
                    <span class="quantity-value">1</span>
                    <button class="plus">+</button>
                </div>
            </div>

            <div class="total">
                <div class="total-label">GESAMT (inkl. Steuern)</div>
                <div class="total-price">32,97 €</div>
            </div>

            <button class="checkout-button">ZUR KASSE (5)</button>
        </div>

        <?php include '../partials/footer.php'; ?>
    </main>
</body>

</html>
