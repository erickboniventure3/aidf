<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
   http_response_code(403);
   exit('Unauthorized');
}

require_once 'conf/conf.php';

$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (empty($type) || $id <= 0) {
   die('Invalid request');
}

switch ($type) {
   case 'membership':
      $stmt = $conn->prepare("SELECT * FROM memberships WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();

      if ($data) {
         echo "<h5>Membership Application Details</h5>";
         echo "<div class='row'>";
         echo "<div class='col-md-6'><strong>Full Name:</strong> " . htmlspecialchars($data['full_name']) . "</div>";
         echo "<div class='col-md-6'><strong>Email:</strong> " . htmlspecialchars($data['email']) . "</div>";
         echo "<div class='col-md-6'><strong>Phone:</strong> " . htmlspecialchars($data['phone']) . "</div>";
         echo "<div class='col-md-6'><strong>Membership Type:</strong> " . ucfirst($data['membership_type']) . "</div>";
         echo "<div class='col-md-6'><strong>Date of Birth:</strong> " . ($data['date_of_birth'] ? date('M d, Y', strtotime($data['date_of_birth'])) : 'Not provided') . "</div>";
         echo "<div class='col-md-6'><strong>Gender:</strong> " . ucfirst($data['gender'] ?: 'Not specified') . "</div>";
         echo "<div class='col-md-6'><strong>Occupation:</strong> " . htmlspecialchars($data['occupation'] ?: 'Not provided') . "</div>";
         echo "<div class='col-md-6'><strong>Education Level:</strong> " . ucfirst(str_replace('_', ' ', $data['education_level'] ?: 'Not specified')) . "</div>";
         echo "</div>";
         echo "<div class='mt-3'><strong>Address:</strong><br>" . nl2br(htmlspecialchars($data['address'])) . "</div>";
         echo "<div class='mt-3'><strong>Areas of Interest:</strong> " . implode(', ', json_decode($data['interests'], true)) . "</div>";
         echo "<div class='mt-3'><strong>Motivation:</strong><br>" . nl2br(htmlspecialchars($data['motivation'])) . "</div>";
         echo "<div class='mt-3'><strong>Newsletter Subscription:</strong> " . ($data['newsletter_subscribed'] ? 'Yes' : 'No') . "</div>";
         echo "<div class='mt-3'><strong>Application Date:</strong> " . date('M d, Y H:i', strtotime($data['created_at'])) . "</div>";
      }
      break;

   case 'volunteer':
      $stmt = $conn->prepare("SELECT * FROM volunteers WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();

      if ($data) {
         echo "<h5>Volunteer Application Details</h5>";
         echo "<div class='row'>";
         echo "<div class='col-md-6'><strong>Full Name:</strong> " . htmlspecialchars($data['full_name']) . "</div>";
         echo "<div class='col-md-6'><strong>Email:</strong> " . htmlspecialchars($data['email']) . "</div>";
         echo "<div class='col-md-6'><strong>Phone:</strong> " . htmlspecialchars($data['phone']) . "</div>";
         echo "<div class='col-md-6'><strong>Date of Birth:</strong> " . date('M d, Y', strtotime($data['date_of_birth'])) . "</div>";
         echo "<div class='col-md-6'><strong>Gender:</strong> " . ucfirst($data['gender'] ?: 'Not specified') . "</div>";
         echo "<div class='col-md-6'><strong>Occupation:</strong> " . htmlspecialchars($data['occupation'] ?: 'Not provided') . "</div>";
         echo "</div>";
         echo "<div class='mt-3'><strong>Address:</strong><br>" . nl2br(htmlspecialchars($data['address'])) . "</div>";
         echo "<div class='mt-3'><strong>Areas of Interest:</strong> " . implode(', ', json_decode($data['interests'], true)) . "</div>";
         echo "<div class='mt-3'><strong>Availability:</strong> " . ucfirst($data['availability']) . "</div>";
         echo "<div class='mt-3'><strong>Hours per Week:</strong> " . $data['hours_per_week'] . "</div>";
         echo "<div class='mt-3'><strong>Skills & Experience:</strong><br>" . nl2br(htmlspecialchars($data['skills'])) . "</div>";
         if (!empty($data['previous_volunteer'])) {
            echo "<div class='mt-3'><strong>Previous Volunteer Experience:</strong><br>" . nl2br(htmlspecialchars($data['previous_volunteer'])) . "</div>";
         }
         echo "<div class='mt-3'><strong>Emergency Contact:</strong> " . htmlspecialchars($data['emergency_contact']) . "</div>";
         echo "<div class='mt-3'><strong>Background Check Consent:</strong> " . ($data['background_check_consent'] ? 'Yes' : 'No') . "</div>";
         echo "<div class='mt-3'><strong>Application Date:</strong> " . date('M d, Y H:i', strtotime($data['created_at'])) . "</div>";
      }
      break;

   case 'message':
      $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();

      if ($data) {
         echo "<h5>Contact Message Details</h5>";
         echo "<div class='row'>";
         echo "<div class='col-md-6'><strong>Name:</strong> " . htmlspecialchars($data['name']) . "</div>";
         echo "<div class='col-md-6'><strong>Email:</strong> " . htmlspecialchars($data['email']) . "</div>";
         echo "<div class='col-md-6'><strong>Phone:</strong> " . htmlspecialchars($data['phone'] ?: 'Not provided') . "</div>";
         echo "<div class='col-md-6'><strong>Subject:</strong> " . htmlspecialchars($data['subject']) . "</div>";
         echo "</div>";
         echo "<div class='mt-3'><strong>Message:</strong><br>" . nl2br(htmlspecialchars($data['message'])) . "</div>";
         echo "<div class='mt-3'><strong>Received:</strong> " . date('M d, Y H:i', strtotime($data['created_at'])) . "</div>";
      }
      break;

   default:
      echo "Invalid type";
}

if (!$data) {
   echo "Record not found";
}
?>
