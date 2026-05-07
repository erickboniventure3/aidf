<?php
require_once 'conf/conf.php';
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Get form data
   $full_name = trim($_POST['full_name'] ?? '');
   $email = trim($_POST['email'] ?? '');
   $phone = trim($_POST['phone'] ?? '');
   $date_of_birth = $_POST['date_of_birth'] ?? '';
   $gender = $_POST['gender'] ?? '';
   $occupation = trim($_POST['occupation'] ?? '');
   $address = trim($_POST['address'] ?? '');
   $country = trim($_POST['country'] ?? '');
   $region = trim($_POST['region'] ?? '');
   $district = trim($_POST['district'] ?? '');
   $interests = isset($_POST['interests']) ? json_encode($_POST['interests']) : '[]';
   $availability = $_POST['availability'] ?? '';
   $hours_per_week = $_POST['hours_per_week'] ?? '';
   $skills = trim($_POST['skills'] ?? '');
   $previous_volunteer = trim($_POST['previous_volunteer'] ?? '');
   $emergency_contact = trim($_POST['emergency_contact'] ?? '');
   $terms = isset($_POST['terms']) ? 1 : 0;
   $volunteer_policy_accepted = isset($_POST['volunteer_policy_accepted']) ? 1 : 0;
   $background_check = isset($_POST['background_check']) ? 1 : 0;

   // Validate required fields
   $errors = [];
   if (empty($full_name)) $errors[] = "Full name is required";
   if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
   if (empty($phone)) $errors[] = "Phone number is required";
   if (empty($date_of_birth)) $errors[] = "Date of birth is required";
   if (empty($address)) $errors[] = "Address is required";
   if (empty($country)) $errors[] = "Country is required";
   if (empty($region)) $errors[] = "Region is required";
   if (empty($availability)) $errors[] = "Availability is required";
   if (empty($hours_per_week)) $errors[] = "Hours per week commitment is required";
   if (empty($skills)) $errors[] = "Skills and experience description is required";
   if (empty($emergency_contact)) $errors[] = "Emergency contact is required";
   if (!$terms) $errors[] = "You must agree to the volunteer terms and conditions";
   if (!$volunteer_policy_accepted) $errors[] = "You must read and accept the volunteer policy before registering";

   if (empty($errors)) {
      // Insert volunteer application into database
      $stmt = $conn->prepare("INSERT INTO volunteers (full_name, email, phone, date_of_birth, gender, occupation, address, country, region, district, interests, availability, hours_per_week, skills, previous_volunteer, emergency_contact, terms_accepted, background_check_consent, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())");
      if (!$stmt) {
         $error = "Database error: " . $conn->error;
         header('Location: volunteer.php?error=' . urlencode($error));
         exit;
      }
      $stmt->bind_param("ssssssssssssssssii", $full_name, $email, $phone, $date_of_birth, $gender, $occupation, $address, $country, $region, $district, $interests, $availability, $hours_per_week, $skills, $previous_volunteer, $emergency_contact, $terms, $background_check);

      if ($stmt->execute()) {
         $volunteer_id = $conn->insert_id;

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
            $mail->Subject = 'Volunteer Application Received - AIDF Tanzania';

            $email_body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
               <h2 style='color: #00a651;'>Thank You for Your Volunteer Application!</h2>
               <p>Dear {$full_name},</p>
               <p>Thank you for your interest in volunteering with AIDF Tanzania. We are excited about the possibility of working together to create positive change in communities across Tanzania.</p>

               <div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                  <h3>Application Details:</h3>
                  <p><strong>Application ID:</strong> AIDF-VOL-{$volunteer_id}</p>
                  <p><strong>Areas of Interest:</strong> " . implode(', ', json_decode($interests, true)) . "</p>
                  <p><strong>Availability:</strong> " . ucfirst($availability) . "</p>
                  <p><strong>Commitment:</strong> {$hours_per_week} hours per week</p>
                  <p><strong>Status:</strong> Under Review</p>
               </div>

               <p>Your application is currently being reviewed by our volunteer coordinator. We will contact you within 7-10 business days to discuss next steps and potential volunteer opportunities that match your skills and availability.</p>

               <p>If you have any questions, please contact us at volunteers@aidf.or.tz</p>

               <p>Best regards,<br>The AIDF Tanzania Volunteer Team</p>
            </div>
            ";

            $mail->Body = $email_body;
            $mail->send();

            // Redirect to success page
            header('Location: volunteer.php?success=1');
            exit;
         } catch (Exception $e) {
            // Email failed, but application was recorded
            header('Location: volunteer.php?success=1&email_error=1');
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
header('Location: volunteer.php?error=' . urlencode($error ?? 'Unknown error'));
exit;
