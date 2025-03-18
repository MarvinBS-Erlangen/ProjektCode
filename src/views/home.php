<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen bei MacApple</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff; /* Weißer Hintergrund für ein sauberes Design */
            color: #2d3e1f;
            text-align: center;
        }
        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('https://source.unsplash.com/1600x900/?healthy-food,vegetables') no-repeat center center/cover;
            color: white;
            padding: 20px;
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.4);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%; /* Volle Breite, damit der Text in einer Reihe bleibt */
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            white-space: nowrap; /* Verhindert den Zeilenumbruch */
        }
        p {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background: #4CAF50; /* Grüner Button */
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 1.2rem;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn:hover {
            background: #45a049;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>Willkommen bei MacApple</h1>
            <p>Gesund, lecker &amp; immer frisch. Starte deine Reise zu einem gesünderen Leben noch heute.</p>
            <a href="./menus.php" class="btn">Speisekarte entdecken</a>
        </div>
    </section>
</body>
</html>

