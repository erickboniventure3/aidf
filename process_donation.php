<?php
require_once 'conf/conf.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get form data
   $donor_name = trim($_POST['donor_name'] ?? '');
   $donor_email = trim($_POST['donor_email'] ?? '');
   $donor_phone = trim($_POST['donor_phone'] ?? '');
   $amount = (int)($_POST['amount'] ?? 0);
   $donation_type = $_POST['donation_type'] ?? 'one-time';
   $payment_method = $_POST['payment_method'] ?? 'card';
   $cause = $_POST['cause'] ?? '';
   $message = trim($_POST['message'] ?? '');
   $anonymous = isset($_POST['anonymous']) ? 1 : 0;

   // Validate required fields
   $errors = [];
   if (empty($donor_name)) $errors[] = "Donor name is required";
   if (empty($donor_email) || !filter_var($donor_email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
   if (empty($donor_phone)) $errors[] = "Phone number is required";
   if ($amount < 1000) $errors[] = "Minimum donation amount is TZS 1,000";

   if (empty($errors)) {
      // Insert donation into database
      $stmt = $conn->prepare("INSERT INTO donations 
(donor_name, donor_email, donor_phone, amount, donation_type, payment_method, cause, message, anonymous, status, created_at) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");

      if (!$stmt) {
         $error = "Database error: " . $conn->error;
         header('Location: donate.php?error=' . urlencode($error));
         exit;
      }

      $stmt->bind_param(
         "sssissssi",
         $donor_name,
         $donor_email,
         $donor_phone,
         $amount,
         $donation_type,
         $payment_method,
         $cause,
         $message,
         $anonymous
      );

      if ($stmt->execute()) {
         $donation_id = $conn->insert_id;

         // Send confirmation email
         $mail = new PHPMailer(true);

         try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Configure according to your email provider
            $mail->SMTPAuth = true;
            $mail->Username = 'info@aidf.or.tz'; // Replace with your email
            $mail->Password = 'your-app-password'; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('noreply@aidf.or.tz', 'AIDF Tanzania');
            $mail->addAddress($donor_email, $donor_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Your Donation - AIDF Tanzania';

            $email_body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
               <h2 style='color: #00a651;'>Thank You for Your Generous Donation!</h2>
               <p>Dear {$donor_name},</p>
               <p>We sincerely thank you for your donation to AIDF Tanzania. Your support helps us continue our mission of empowering communities and creating sustainable development across Tanzania.</p>

               <div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                  <h3>Donation Details:</h3>
                  <p><strong>Amount:</strong> TZS " . number_format($amount) . "</p>
                  <p><strong>Type:</strong> " . ucfirst($donation_type) . "</p>
                  <p><strong>Payment Method:</strong> " . ucfirst($payment_method) . "</p>
                  " . (!empty($cause) ? "<p><strong>Cause:</strong> " . ucfirst($cause) . "</p>" : "") . "
                  <p><strong>Reference ID:</strong> AIDF-DON-{$donation_id}</p>
               </div>

               <p>Your donation is currently being processed. You will receive a confirmation once the payment is completed.</p>

               <p>For any questions, please contact us at info@aidf.or.tz</p>

               <p>Best regards,<br>The AIDF Tanzania Team</p>
            </div>
            ";

            $mail->Body = $email_body;

            $mail->send();

            // Redirect to success page
            header('Location: donate.php?success=1&amount=' . $amount);
            exit;

         } catch (Exception $e) {
            // Email failed, but donation was recorded
            header('Location: donate.php?success=1&email_error=1&amount=' . $amount);
            exit;
         }
      } else {
         $error = "Failed to process donation. Please try again.";
      }
   } else {
      $error = implode("<br>", $errors);
   }
}

// If we get here, there was an error
header('Location: donate.php?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>
