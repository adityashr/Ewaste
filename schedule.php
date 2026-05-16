<?php
session_start();
include("config.php");

// Include PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$msg = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email, name FROM users WHERE id='$user_id'"));
$user_email = $user_info['email'];
$user_name = $user_info['name'];

if (isset($_POST['request'])) {

    $waste_type = trim($_POST['waste_type']);
    $address = trim($_POST['address']);
    $date = trim($_POST['date']);

    if (empty($waste_type) || empty($address) || empty($date)) {

        $msg = "All fields are required!";

    } else {

        $stmt = $conn->prepare("INSERT INTO pickups (user_id, waste_type, address, pickup_date, status) VALUES (?, ?, ?, ?, 'Pending')");

        $stmt->bind_param("isss", $user_id, $waste_type, $address, $date);

        if ($stmt->execute()) {

            try {

                // USER EMAIL
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;

                // YOUR GMAIL
                $mail->Username = 'aditya31182005@gmail.com';

                // GOOGLE APP PASSWORD
                $mail->Password = 'pmaw qnuh hcpu hdiu';

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // IMPORTANT FIX
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom('aditya31182005@gmail.com', 'E-Waste Portal');

                $mail->addAddress($user_email, $user_name);

                $mail->isHTML(true);

                $mail->Subject = 'Pickup Request Submitted';

                $mail->Body = "
                <h2>Hello {$user_name}</h2>

                <p>Your e-waste pickup request has been submitted successfully.</p>

                <h3>Pickup Details</h3>

                <ul>
                    <li><b>Waste Type:</b> {$waste_type}</li>
                    <li><b>Address:</b> {$address}</li>
                    <li><b>Pickup Date:</b> {$date}</li>
                    <li><b>Status:</b> Pending</li>
                </ul>

                <br>

                <p>Thank you for using our platform.</p>

                <p><b>♻ E-Waste Management Portal</b></p>
                ";

                $mail->send();

                // ADMIN EMAIL
                $adminMail = new PHPMailer(true);

                $adminMail->isSMTP();
                $adminMail->Host = 'smtp.gmail.com';
                $adminMail->SMTPAuth = true;

                $adminMail->Username = 'aditya31182005@gmail.com';
                $adminMail->Password =  'pmaw qnuh hcpu hdiu';

                $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $adminMail->Port = 587;

                // IMPORTANT FIX
                $adminMail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $adminMail->setFrom('aditya31182005@gmail.com', 'E-Waste Portal');

                // ADMIN RECEIVER
                $adminMail->addAddress('aditya31182005@gmail.com', 'Admin');

                $adminMail->isHTML(true);

                $adminMail->Subject = 'New Pickup Request';

                $adminMail->Body = "
                <h2>New Pickup Request Received</h2>

                <ul>
                    <li><b>User Name:</b> {$user_name}</li>
                    <li><b>User Email:</b> {$user_email}</li>
                    <li><b>Waste Type:</b> {$waste_type}</li>
                    <li><b>Address:</b> {$address}</li>
                    <li><b>Pickup Date:</b> {$date}</li>
                </ul>
                ";

                $adminMail->send();

                $_SESSION['msg'] = "Pickup Request Submitted Successfully!";

                header("Location: mypickups.php");

                exit();

            } catch (Exception $e) {

                // SHOW REAL ERROR
                $msg = "Mailer Error: " . $mail->ErrorInfo;

            }

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