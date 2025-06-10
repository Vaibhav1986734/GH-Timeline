<?php
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateVerificationCode() {
    return rand(100000, 999999);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    if (!in_array($email, file($file, FILE_IGNORE_NEW_LINES))) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $updated = array_filter($emails, fn($e) => trim($e) !== trim($email));
    file_put_contents($file, implode(PHP_EOL, $updated) . PHP_EOL);
}

function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vm464085@gmail.com';          //  Gmail
        $mail->Password = 'johc cuug gyne deej';          // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('vm464085@gmail.com', 'GH Timeline');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body    = "<p>Your verification code is: <strong>$code</strong></p>";

        $mail->send();
        
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

function sendUnsubscribeCode($email, $code) {
    $subject = "Confirm Unsubscription";
    $message = "<p>To confirm unsubscription, use this code: <strong>$code</strong></p>";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@example.com\r\n";
    mail($email, $subject, $message, $headers);
}

function fetchGitHubTimeline() {
    return file_get_contents("https://www.github.com/timeline");
}

function formatGitHubData($data) {
    // This should parse actual timeline data. For now, dummy format:
    return "
    <h2>GitHub Timeline Updates</h2>
    <table border='1'>
        <tr><th>Event</th><th>User</th></tr>
        <tr><td>Push</td><td>testuser</td></tr>
    </table>
    ";
}

function sendGitHubUpdatesToSubscribers() {
    $emails = file(__DIR__ . '/registered_emails.txt', FILE_IGNORE_NEW_LINES);
    $html = formatGitHubData(fetchGitHubTimeline());
    foreach ($emails as $email) {
        $subject = "Latest GitHub Updates";
        $message = $html . "<p><a href='http://yourdomain.com/src/unsubscribe.php?email=" . urlencode($email) . "' id='unsubscribe-button'>Unsubscribe</a></p>";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: no-reply@example.com\r\n";
        mail($email, $subject, $message, $headers);
    }
}
