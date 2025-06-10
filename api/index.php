<?php
require 'functions.php';
session_start();

$message = '';
$showVerification = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $code = generateVerificationCode();
        $_SESSION['email'] = $email;
        $_SESSION['code'] = $code;
        sendVerificationEmail($email, $code);
        $message = "Verification code sent to your email.";
        $showVerification = true;
    }

    if (isset($_POST['verification_code'])) {
        $showVerification = true;
        if ($_POST['verification_code'] == $_SESSION['code']) {
            registerEmail($_SESSION['email']);
            $message = "✅ Email verified and registered successfully!";
        } else {
            $message = "❌ Invalid verification code.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GH Timeline</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: none;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #ffffff30;
            color: #fff;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .btn-custom {
            background-color: #00d4ff;
            border: none;
            color: #000;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #00c0e6;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card col-md-6 mx-auto" data-aos="zoom-in">
            <h2>Email Subscription</h2>

            <?php if (!empty($message)): ?>
                <div class="alert <?= strpos($message, '✅') !== false ? 'alert-success' : 'alert-danger' ?> text-center" role="alert">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="post" id="email-form">
                <div class="mb-3">
                   <input type="email" name="email" class="form-control" placeholder="Enter your email" required
       value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">

                </div>
                <button id="submit-email" class="btn btn-custom w-100" type="submit">Submit</button>
            </form>

            <form method="post" id="code-form" class="<?= $showVerification ? '' : 'hidden' ?>">
                <div class="mb-3 mt-3">
                    <input type="number" name="verification_code" maxlength="6" class="form-control" placeholder="Enter verification code" required>
                </div>
                <button id="submit-verification" class="btn btn-custom w-100" type="submit">Verify</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS + AOS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();

        <?php if ($showVerification): ?>
            document.getElementById('code-form').classList.remove('hidden');
        <?php endif; ?>
    </script>
</body>
</html>
