<?php
require_once 'conf/conf.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate required fields
    $errors = [];
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($subject)) $errors[] = "Subject is required";
    if (empty($message)) $errors[] = "Message is required";

    if (empty($errors)) {
        // Insert contact message into database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, status, created_at) VALUES (?, ?, ?, ?, ?, 'unread', NOW())");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $message_id = $conn->insert_id;

            // Send confirmation email to user
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Configure with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'your-email@gmail.com'; // Replace with your email
                $mail->Password = 'your-app-password'; // Replace with your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('info@aidf.or.tz', 'AIDF Tanzania');
                $mail->addAddress($email, $name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Thank you for contacting AIDF Tanzania';
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                        <h2 style='color: #00a651;'>Thank You for Contacting AIDF Tanzania</h2>
                        <p>Dear {$name},</p>
                        <p>Thank you for reaching out to us. We have received your message and will get back to you within 24-48 hours.</p>
                        <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h4>Your Message Details:</h4>
                            <p><strong>Subject:</strong> {$subject}</p>
                            <p><strong>Message:</strong> {$message}</p>
                        </div>
                        <p>If you have any urgent matters, please call us at +255 745 600 763.</p>
                        <p>Best regards,<br>AIDF Tanzania Team</p>
                        <hr>
                        <p style='font-size: 12px; color: #666;'>
                            African Initiative for Development Foundation (AIDF)<br>
                            Promoting sustainable community development across Tanzania
                        </p>
                    </div>
                ";

                $mail->send();

                // Send notification email to AIDF admin
                $mail->clearAddresses();
                $mail->addAddress('info@aidf.or.tz', 'AIDF Admin');

                $mail->Subject = 'New Contact Message from AIDF Website';
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                        <h2 style='color: #00a651;'>New Contact Message Received</h2>
                        <div style='background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                            <h4>Contact Details:</h4>
                            <p><strong>Name:</strong> {$name}</p>
                            <p><strong>Email:</strong> {$email}</p>
                            <p><strong>Phone:</strong> {$phone}</p>
                            <p><strong>Subject:</strong> {$subject}</p>
                            <p><strong>Message:</strong> {$message}</p>
                            <p><strong>Received:</strong> " . date('Y-m-d H:i:s') . "</p>
                        </div>
                        <p>Please log into the admin dashboard to respond to this message.</p>
                    </div>
                ";

                $mail->send();

                // Redirect to success page
                header('Location: contact.php?status=success');
                exit();

            } catch (Exception $e) {
                // Log error and redirect with error
                error_log("Email sending failed: " . $mail->ErrorInfo);
                header('Location: contact.php?status=email_error');
                exit();
            }
        } else {
            // Database error
            error_log("Database error: " . $conn->error);
            header('Location: contact.php?status=db_error');
            exit();
        }
    } else {
        // Validation errors
        $error_string = implode(', ', $errors);
        header('Location: contact.php?status=validation_error&errors=' . urlencode($error_string));
        exit();
    }
} else {
    // Invalid request method
    header('Location: contact.php');
    exit();
}
?>