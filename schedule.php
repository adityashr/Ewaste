<?php
session_start();
include("config.php");

$msg = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user_info = mysqli_fetch_assoc($userQuery);

$user_email = $user_info['email'];
$user_name  = $user_info['name'];

if (isset($_POST['request'])) {

    $waste_type = trim($_POST['waste_type']);
    $address    = trim($_POST['address']);
    $date       = trim($_POST['date']);

    if (
        empty($waste_type) ||
        empty($address) ||
        empty($date)
    ) {

        $msg = "All fields are required!";

    } else {

        $stmt = $conn->prepare("INSERT INTO pickups (user_id, waste_type, address, pickup_date, status) VALUES (?, ?, ?, ?, 'Pending')");

        $stmt->bind_param("isss", $user_id, $waste_type, $address, $date);

        if ($stmt->execute()) {

            /*
            ============================================
            PHPMailer TEMPORARILY DISABLED
            ============================================

            require 'vendor/autoload.php';

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            try {

                // USER EMAIL
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                $mail->Username = 'aditya31182005@gmail.com';
                $mail->Password = 'YOUR_APP_PASSWORD';

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom(
                    'aditya31182005@gmail.com',
                    'E-Waste Management Portal'
                );

                $mail->addAddress($user_email, $user_name);

                $mail->isHTML(true);

                $mail->Subject = "Pickup Request Submitted";

                $mail->Body = "Pickup Request Submitted";

                $mail->send();

            } catch (Exception $e) {

                echo $mail->ErrorInfo;

            }

            ============================================
            END MAILER
            ============================================
            */

            // SUCCESS MESSAGE
            $_SESSION['msg'] = "Pickup Request Submitted Successfully!";

            // REDIRECT
            header("Location: mypickups.php");

            exit();

        } else {

            $msg = "Database Error!";

        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Schedule Pickup</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background: #000;
            overflow-x: hidden;
        }

        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50vh;
            background: linear-gradient(180deg, #000, #001100);
            overflow: hidden;
            z-index: -1;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(40, 172, 36, 0.6);
            pointer-events: none;
            animation: float 15s linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) scale(0.5);
            }

            50% {
                transform: translateY(-200px) translateX(50px) scale(1);
            }

            100% {
                transform: translateY(0) translateX(0) scale(0.5);
            }
        }

        .page-heading {
            text-align: center;
            margin: 30px 0 15px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .page-heading h1 {
            font-size: 36px;
            margin: 0;
        }

        .page-heading p {
            font-size: 16px;
            color: #ddd;
        }

        .container {
            width: 500px;
            max-width: 90%;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }

        .container h2 {
            text-align: center;
            color: #28a745;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 14px;
            font-weight: 500;
        }

        select,
        textarea,
        input[type=date] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            height: 60px;
            resize: none;
        }

        select:focus,
        textarea:focus,
        input:focus {
            border-color: #28a745;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .msg {
            margin-top: 15px;
            padding: 12px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            text-align: center;
        }


        /*old  */
        /* =========================================
   RESPONSIVE FIX FOR LOGIN PAGE
   OLD CSS KE END MEIN ADD KARO
   ========================================= */

html,
body {
    width: 100%;
    min-height: 100%;
    overflow-x: hidden !important;
}

/* BODY FIX */
body {
    overflow-y: auto !important;
    padding: 140px 20px 40px;
}

/* HERO FIX */
.hero {
    top: 40px !important;
    width: 100%;
    padding: 0 20px;
    z-index: 3;
}

.hero h1 {
    font-size: clamp(2.2rem, 6vw, 3.8rem) !important;
    line-height: 1.2;
}

.hero p {
    font-size: clamp(1rem, 2vw, 1.3rem) !important;
    line-height: 1.5;
}

/* LOGIN CARD FIX */
.login-card {
    width: min(400px, 95%) !important;
    padding: 40px !important;
    margin-top: 40px;
    z-index: 3;
}

/* INPUT FIX */
.login-card input,
.password-box input {
    font-size: 15px;
    padding: 14px;
}

/* BUTTON FIX */
.login-card button {
    padding: 15px;
    font-size: 16px;
}

/* =========================
   TABLET VIEW
   ========================= */
@media (max-width: 992px) {
    body {
        padding: 130px 20px 40px;
    }

    .login-card {
        width: 85% !important;
        max-width: 420px;
        padding: 35px !important;
    }

    .hero {
        top: 30px !important;
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
        top: 25px !important;
    }

    .hero h1 {
        font-size: clamp(2rem, 9vw, 3rem) !important;
    }

    .hero p {
        font-size: 1rem !important;
    }

    .login-card {
        width: 95% !important;
        padding: 30px 20px !important;
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
        font-size: 1.8rem !important;
    }

    .hero p {
        font-size: 0.9rem !important;
    }

    .login-card {
        width: 96% !important;
        padding: 25px 15px !important;
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

    <div class="animated-bg"></div>

    <div class="page-heading">
        <h1>E-Waste Management Portal</h1>
        <p>Schedule your e-waste pickup quickly and efficiently</p>
    </div>

    <div class="container">

        <h2>Schedule Pickup</h2>

        <form method="POST">

            <label>Waste Type</label>

            <select name="waste_type" required>
                <option value="">Select Waste Type</option>
                <option value="Mobile">Mobile</option>
                <option value="Laptop">Laptop</option>
                <option value="Battery">Battery</option>
                <option value="Plastic">Plastic</option>
                <option value="E-Waste Mixed">E-Waste Mixed</option>
                <option value="Others">Others</option>
            </select>

            <label>Address</label>

            <textarea name="address" placeholder="Enter your address..." required></textarea>

            <label>Pickup Date</label>

            <input type="date" name="date" required>

            <button class="btn" name="request">Request Pickup</button>

        </form>

        <?php
        if (!empty($msg)) {
            echo "<div class='msg'>$msg</div>";
        }
        ?>

    </div>

    <script>

        const particleCount = 30;

        const container = document.querySelector('.animated-bg');

        for (let i = 0; i < particleCount; i++) {

            const p = document.createElement('div');

            p.classList.add('particle');

            const size = Math.random() * 6 + 4;

            p.style.width = size + 'px';
            p.style.height = size + 'px';

            p.style.top = Math.random() * 50 + 'vh';
            p.style.left = Math.random() * 100 + 'vw';

            p.style.animationDuration = (Math.random() * 20 + 10) + 's';

            container.appendChild(p);
        }

    </script>

</body>

</html>
