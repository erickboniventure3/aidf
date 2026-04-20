<?php
// Include PHPMailer via Composer autoload
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Create PHPMailer instance
$mail = new PHPMailer();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $number = htmlspecialchars($_POST["number"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (empty($name) || empty($email) || empty($number) || empty($subject) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'aidf.or.tz'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'info@aidf.or.tz'; // Replace with your email
        $mail->Password = 'Levana@2025'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and Recipient
        $mail->setFrom($email, $name);
        $mail->addAddress('info@aidf.or.tz', 'Website Admin'); // Replace with recipient email

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "
            <h3>Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $number</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong> $message</p>
        ";

        // Send Email
        if ($mail->send()) {
            echo "Message has been sent successfully!";
        } else {
            echo "Message could not be sent. Error: " ;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: ";
    }
} else {
    echo "Invalid request!";
}
?>
