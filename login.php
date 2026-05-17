<?php
session_start();
include("config.php");

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Email or Password!";
        }

    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>♻ Login - E-Waste Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
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
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-y: auto;
            padding: 140px 20px 40px;
        }

        /* DIAGONAL BACKGROUND */
        .diagonal-bg {
            position: absolute;
            top: 0;
            left: -120%;
            width: 220%;
            height: 220%;
            background: linear-gradient(135deg, #28a745, #20c997);
            transform: rotate(-45deg);
            animation: diagonalSlide 1s forwards 0.5s;
            z-index: 1;
        }

        /* HERO TITLE */
        .hero {
            position: absolute;
            top: 40px;
            width: 100%;
            text-align: center;
            color: white;
            z-index: 3;
            opacity: 1;
            animation: heroSlide 1s ease forwards;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            line-height: 1.2;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
            margin-bottom: 10px;
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.3rem);
            color: #eee;
            line-height: 1.5;
        }

        /* LOGIN CARD */
        .login-card {
            position: relative;
            z-index: 3;
            width: min(400px, 95%);
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            animation: cardSlide 1s forwards 1s;
            margin-top: 40px;
        }

        /* CARD TITLE */
        .login-card h2 {
            margin-bottom: 25px;
            color: #28a745;
            font-size: clamp(1.8rem, 4vw, 2.3rem);
        }

        /* INPUTS */
        .login-card input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: 0.3s;
        }

        .login-card input:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
        }

        /* PASSWORD BOX */
        .password-box {
            position: relative;
            width: 100%;
            margin: 10px 0;
        }

        .password-box input {
            padding-right: 45px;
        }

        .password-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            font-size: 16px;
        }

        .password-box i:hover {
            color: #28a745;
        }

        /* BUTTON */
        .login-card button {
            width: 100%;
            padding: 15px;
            background: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            margin-top: 15px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-card button:hover {
            background: #20c997;
            transform: scale(1.03);
        }

        /* ERROR */
        .error {
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* REGISTER LINK */
        .register-link {
            margin-top: 18px;
            font-size: 14px;
        }

        .register-link a {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* ANIMATIONS */
        @keyframes diagonalSlide {
            0% {
                left: -120%;
            }

            100% {
                left: -20%;
            }
        }

        @keyframes heroSlide {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes cardSlide {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================
           TABLET VIEW
        ========================= */
        @media (max-width: 992px) {
            body {
                padding: 130px 20px 40px;
            }

            .hero {
                top: 30px;
            }

            .login-card {
                width: 85%;
                max-width: 420px;
                padding: 35px;
            }
        }

        /* =========================
           MOBILE VIEW
        ========================= */
        @media (max-width: 768px) {
            body {
                padding: 120px 15px 30px;
                align-items: flex-start;
            }

            .hero {
                top: 25px;
            }

            .hero h1 {
                font-size: clamp(2rem, 9vw, 3rem);
            }

            .hero p {
                font-size: 1rem;
            }

            .login-card {
                width: 95%;
                padding: 30px 20px;
                margin-top: 30px;
            }

            .login-card h2 {
                font-size: 1.8rem;
            }

            .login-card input,
            .password-box input {
                padding: 13px;
                font-size: 14px;
            }

            .login-card button {
                padding: 14px;
                font-size: 15px;
            }
        }

        /* =========================
           SMALL MOBILE VIEW
        ========================= */
        @media (max-width: 480px) {
            body {
                padding: 110px 12px 25px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .login-card {
                width: 96%;
                padding: 25px 15px;
                border-radius: 18px;
            }

            .login-card h2 {
                font-size: 1.6rem;
            }

            .login-card button {
                padding: 13px;
                font-size: 14px;
            }

            .register-link {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <!-- DIAGONAL BACKGROUND -->
    <div class="diagonal-bg"></div>

    <!-- HERO TITLE -->
    <div class="hero">
        <h1>♻ E-Waste Management Portal</h1>
        <p>Login to manage your pickups and reviews</p>
    </div>

    <!-- LOGIN CARD -->
    <div class="login-card">
        <h2>Welcome Back</h2>

        <?php
        if (isset($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>

            <div class="password-box">
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <i class="fa-solid fa-eye" id="eye" onclick="togglePassword()"></i>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="register-link">
            Don't have an account? <a href="register.php">Register</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            var password = document.getElementById("password");
            var eye = document.getElementById("eye");

            if (password.type === "password") {
                password.type = "text";
                eye.classList.remove("fa-eye");
                eye.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                eye.classList.remove("fa-eye-slash");
                eye.classList.add("fa-eye");
            }
        }
    </script>

</body>

</html>
