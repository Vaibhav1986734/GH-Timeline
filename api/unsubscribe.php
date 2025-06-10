<?php
require 'functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['unsubscribe_email'])) {
        $email = $_POST['unsubscribe_email'];
        $code = generateVerificationCode();
        $_SESSION['unsubscribe_email'] = $email;
        $_SESSION['unsubscribe_code'] = $code;
        sendUnsubscribeCode($email, $code);
        echo "Unsubscribe code sent to your email.";
    }

    if (isset($_POST['unsubscribe_verification_code'])) {
        if ($_POST['unsubscribe_verification_code'] == $_SESSION['unsubscribe_code']) {
            unsubscribeEmail($_SESSION['unsubscribe_email']);
            echo "You have been unsubscribed.";
        } else {
            echo "Invalid verification code.";
        }
    }
}
?>

<h2>Unsubscribe</h2>
<form method="post">
    <input type="email" name="unsubscribe_email" required>
    <button id="submit-unsubscribe">Unsubscribe</button>
</form>

<form method="post">
    <input type="text" name="unsubscribe_verification_code">
    <button id="verify-unsubscribe">Verify</button>
</form>
