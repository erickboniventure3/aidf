<?php
require_once 'conf/conf.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $membershipTypeLabels = [
      'ordinary' => 'Ordinary Member',
      'college_student' => 'College Student',
      'institutional' => 'Institutional Member',
      'honorary' => 'Honorary Member',
   ];

   // Get form data
   $full_name = trim($_POST['full_name'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $phone = trim($_POST['phone'] ?? '');
   $date_of_birth = $_POST['date_of_birth'] ?? '';
   $gender = $_POST['gender'] ?? '';
   $occupation = trim($_POST['occupation'] ?? '');
   $education_level = $_POST['education_level'] ?? '';
   $address = trim($_POST['address'] ?? '');
   $country = trim($_POST['country'] ?? '');
   $region = trim($_POST['region'] ?? '');
   $district = trim($_POST['district'] ?? '');
   $membership_type = $_POST['membership_type'] ?? '';
   $interests = isset($_POST['interests']) ? json_encode($_POST['interests']) : '[]';
   $motivation = trim($_POST['motivation'] ?? '');
   $terms = isset($_POST['terms']) ? 1 : 0;
   $membership_policy_accepted = isset($_POST['membership_policy_accepted']) ? 1 : 0;
   $newsletter = isset($_POST['newsletter']) ? 1 : 0;

   // Validate required fields
   $errors = [];
   if (empty($full_name)) $errors[] = "Full name is required";
   if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
   if (empty($phone)) $errors[] = "Phone number is required";
   if (empty($address)) $errors[] = "Address is required";
   if (empty($country)) $errors[] = "Country is required";
   if (empty($region)) $errors[] = "Region is required";
   if (empty($membership_type)) $errors[] = "Membership type is required";
   if (!empty($membership_type) && !isset($membershipTypeLabels[$membership_type])) $errors[] = "Invalid membership type selected";
   if (empty($motivation)) $errors[] = "Motivation statement is required";
   if (!$terms) $errors[] = "You must agree to the terms and conditions";
   if (!$membership_policy_accepted) $errors[] = "You must read and accept the membership policy before registering";

   if (empty($errors)) {
      // Insert membership application into database
      $stmt = $conn->prepare("INSERT INTO memberships (full_name, email, phone, date_of_birth, gender, occupation, education_level, address, country, region, district, membership_type, interests, motivation, terms_accepted, newsletter_subscribed, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
      if (!$stmt) {
         $error = "Database error: " . $conn->error;
         header('Location: membership.php?error=' . urlencode($error));
         exit;
      }
      $stmt->bind_param("ssssssssssssssii", $full_name, $email, $phone, $date_of_birth, $gender, $occupation, $education_level, $address, $country, $region, $district, $membership_type, $interests, $motivation, $terms, $newsletter);

      if ($stmt->execute()) {
         $membership_id = $conn->insert_id;

         // Send confirmation email
         $mail = new PHPMailer(true);

         try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Configure according to your email provider
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Replace with your email
            $mail->Password = 'your-app-password'; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('noreply@aidf.or.tz', 'AIDF Tanzania');
            $mail->addAddress($email, $full_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Membership Application Received - AIDF Tanzania';

            $email_body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
               <h2 style='color: #00a651;'>Thank You for Your Membership Application!</h2>
               <p>Dear {$full_name},</p>
               <p>Thank you for applying to become a member of AIDF Tanzania. We appreciate your interest in joining our community and contributing to sustainable development initiatives across Tanzania.</p>

               <div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                  <h3>Application Details:</h3>
                  <p><strong>Membership Type:</strong> " . $membershipTypeLabels[$membership_type] . "</p>
                  <p><strong>Application ID:</strong> AIDF-MEM-{$membership_id}</p>
                  <p><strong>Status:</strong> Under Review</p>
               </div>

               <p>Your application is currently being reviewed by our team. We will contact you within 7-10 business days with the results of your application.</p>

               <p>If you have any questions, please contact us at membership@aidf.or.tz</p>

               <p>Best regards,<br>The AIDF Tanzania Membership Team</p>
            </div>
            ";

            $mail->Body = $email_body;
            $mail->send();

            // Redirect to success page
            header('Location: membership.php?success=1');
            exit;

         } catch (Exception $e) {
            // Email failed, but application was recorded
            header('Location: membership.php?success=1&email_error=1');
            exit;
         }
      } else {
         $error = "Failed to submit application. Please try again.";
      }
   } else {
      $error = implode("<br>", $errors);
   }
}

// If we get here, there was an error
header('Location: membership.php?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>
