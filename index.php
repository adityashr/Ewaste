<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>♻ E-Waste Management Portal</title>

    <style>
        /* =========================================
   CLEAN RESPONSIVE CSS FOR E-WASTE PORTAL
   KEEPING SAME DESIGN
   Replace old responsive CSS with this only
========================================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

html,
body {
    width: 100%;
    min-height: 100%;
    overflow-x: hidden;
}

/* BODY */
body {
    min-height: 100vh;
    background: #18191a;
    position: relative;
    overflow-x: hidden;
    overflow-y: auto;
}

/* HERO */
.hero {
    position: relative;
    z-index: 2;
    min-height: 40vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
    text-align: center;
    color: white;
    opacity: 0;
    animation: heroAppear 1s forwards 0.3s;
}

.hero h1 {
    font-size: clamp(2.5rem, 7vw, 4rem);
    margin-bottom: 15px;
    line-height: 1.2;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
}

.hero p {
    font-size: clamp(1rem, 3vw, 1.4rem);
    color: #eee;
    max-width: 800px;
    line-height: 1.5;
}

/* DIAGONAL BG */
.diagonal-bg {
    position: absolute;
    top: 0;
    left: -120%;
    width: 200%;
    height: 200%;
    background: #26ac24;
    transform: rotate(-45deg);
    animation: diagonalMove 1s ease forwards 0.8s;
    z-index: 1;
}

/* FLIP CARD */
.flip-card {
    perspective: 1200px;
    width: min(500px, 90%);
    height: 350px;
    margin: 0 auto 50px;
    position: relative;
    top: -20px;
    z-index: 2;
    opacity: 0;
    animation: formAppear 1s forwards 1.6s;
}

.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s;
    transform-style: preserve-3d;
}

.flip-card.flipped .flip-card-inner {
    transform: rotateY(180deg);
}

.flip-card-front,
.flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 20px;
    padding: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
}

/* FRONT */
.flip-card-front {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

/* BACK */
.flip-card-back {
    background: #000;
    color: white;
    transform: rotateY(180deg);
}

.flip-card h3 {
    margin-bottom: 25px;
    font-size: clamp(1.8rem, 4vw, 2.5rem);
}

/* BUTTONS */
.flip-card a {
    display: inline-block;
    margin: 12px;
    padding: 16px 35px;
    text-decoration: none;
    font-weight: bold;
    border-radius: 14px;
    color: white;
    font-size: clamp(1rem, 2vw, 1.2rem);
    transition: 0.3s;
    min-width: 180px;
    text-align: center;
}

.flip-card-front a {
    background: #000;
}

.flip-card-back a {
    background: linear-gradient(45deg, #28a745, #20c997);
}

.flip-card a:hover {
    transform: scale(1.08);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
}

/* =========================
   TABLET
========================= */
@media (max-width: 992px) {
    .hero {
        min-height: 38vh;
        padding: 35px 20px;
    }

    .flip-card {
        width: 85%;
        height: 330px;
    }
}

/* =========================
   MOBILE
========================= */
@media (max-width: 768px) {
    body {
        overflow-y: auto;
    }

    .hero {
        min-height: auto;
        padding: 30px 15px;
    }

    .hero h1 {
        font-size: clamp(2.2rem, 9vw, 3.5rem);
    }

    .hero p {
        font-size: 1rem;
        padding: 0 10px;
    }

    .flip-card {
        width: 92%;
        height: 320px;
        top: 0;
        margin-top: 20px;
    }

    .flip-card h3 {
        font-size: 2rem;
    }

    .flip-card a {
        width: 100%;
        max-width: 230px;
        padding: 14px;
        font-size: 1rem;
        margin: 10px auto;
    }
}

/* =========================
   SMALL MOBILE
========================= */
@media (max-width: 480px) {
    .hero {
        padding: 25px 12px;
    }

    .hero h1 {
        font-size: 2rem;
    }

    .hero p {
        font-size: 0.95rem;
    }

    .flip-card {
        width: 95%;
        height: 300px;
    }

    .flip-card-front,
    .flip-card-back {
        padding: 25px 15px;
    }

    .flip-card h3 {
        font-size: 1.8rem;
    }

    .flip-card a {
        max-width: 200px;
        padding: 12px;
        font-size: 0.95rem;
    }
}

/* ANIMATIONS */
@keyframes diagonalMove {
    0% {
        left: -120%;
    }

    100% {
        left: -20%;
    }
}

@keyframes heroAppear {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes formAppear {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
</head>

<body>

    <!-- HERO TITLE -->
    <div class="hero">
        <h1>♻ E-Waste Management Portal</h1>
        <p>Manage electronic waste responsibly and easily</p>
    </div>

    <!-- DIAGONAL BACKGROUND -->
    <div class="diagonal-bg"></div>

    <!-- FLIP CARD -->
    <div class="flip-card" id="card">
        <div class="flip-card-inner">
            <!-- FRONT SIDE -->
            <div class="flip-card-front">
                <h3>Get Started</h3>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </div>
            <!-- BACK SIDE -->
            <div class="flip-card-back">
                <h3>Explore</h3>
                <a href="map.php">View Centers</a>
            </div>
        </div>
    </div>

    <script>
        const card = document.getElementById("card");
        card.addEventListener("click", function (e) {
            if (e.target.tagName === "A") return; // links click na ho
            card.classList.toggle("flipped");
        });
    </script>

</body>

</html>
