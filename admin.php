<?php
session_start();
require_once 'conf/conf.php';

function getMonthlyTrendData(mysqli $conn, string $table, string $valueExpression = 'COUNT(*)'): array
{
   $rows = [];
   $sql = "
      SELECT DATE_FORMAT(created_at, '%Y-%m') AS month_key, {$valueExpression} AS total
      FROM {$table}
      WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
      GROUP BY DATE_FORMAT(created_at, '%Y-%m')
      ORDER BY month_key ASC
   ";
   $result = $conn->query($sql);

   if ($result) {
      while ($row = $result->fetch_assoc()) {
         $rows[$row['month_key']] = (float) $row['total'];
      }
   }

   $labels = [];
   $values = [];
   $currentMonth = new DateTime('first day of this month');
   $startMonth = (clone $currentMonth)->modify('-11 months');
   $period = new DatePeriod($startMonth, new DateInterval('P1M'), 12);

   foreach ($period as $month) {
      $key = $month->format('Y-m');
      $labels[] = $month->format('M Y');
      $values[] = $rows[$key] ?? 0;
   }

   return ['labels' => $labels, 'values' => $values];
}

function formatMembershipType(string $type): string
{
   $labels = [
      'ordinary' => 'Ordinary Member',
      'college_student' => 'College Student',
      'institutional' => 'Institutional Member',
      'honorary' => 'Honorary Member',
   ];

   return $labels[$type] ?? ucwords(str_replace('_', ' ', $type));
}

function outputCsvDownload(mysqli $conn, string $type): void
{
   $exports = [
      'memberships' => [
         'filename' => 'memberships-' . date('Y-m-d') . '.csv',
         'query' => "SELECT id, full_name, email, phone, gender, country, region, district, occupation, education_level, membership_type, status, created_at FROM memberships ORDER BY created_at DESC",
         'headers' => ['ID', 'Full Name', 'Email', 'Phone', 'Gender', 'Country', 'Region', 'District', 'Occupation', 'Education Level', 'Membership Type', 'Status', 'Created At'],
      ],
      'volunteers' => [
         'filename' => 'volunteers-' . date('Y-m-d') . '.csv',
         'query' => "SELECT id, full_name, email, phone, country, region, district, occupation, volunteer_area, availability, status, created_at FROM volunteers ORDER BY created_at DESC",
         'headers' => ['ID', 'Full Name', 'Email', 'Phone', 'Country', 'Region', 'District', 'Occupation', 'Volunteer Area', 'Availability', 'Status', 'Created At'],
      ],
   ];

   if (!isset($exports[$type])) {
      http_response_code(404);
      exit('Invalid export type');
   }

   $config = $exports[$type];
   $result = $conn->query($config['query']);

   header('Content-Type: text/csv; charset=UTF-8');
   header('Content-Disposition: attachment; filename="' . $config['filename'] . '"');

   $output = fopen('php://output', 'w');
   fputcsv($output, $config['headers']);

   if ($result) {
      while ($row = $result->fetch_assoc()) {
         fputcsv($output, $row);
      }
   }

   fclose($output);
   exit;
}

function getEditConfig(string $type): ?array
{
   $configs = [
      'donation' => [
         'table' => 'donations',
         'title' => 'Edit Donation',
         'page' => 'donations',
         'query' => "SELECT id, donor_name, donor_email, donor_phone, amount, donation_type, payment_method, cause, transaction_id, status FROM donations WHERE id = ?",
      ],
      'membership' => [
         'table' => 'memberships',
         'title' => 'Edit Membership',
         'page' => 'memberships',
         'query' => "SELECT id, full_name, email, phone, gender, occupation, education_level, membership_type, status FROM memberships WHERE id = ?",
      ],
      'volunteer' => [
         'table' => 'volunteers',
         'title' => 'Edit Volunteer',
         'page' => 'volunteers',
         'query' => "SELECT id, full_name, email, phone, gender, occupation, volunteer_area, availability, status FROM volunteers WHERE id = ?",
      ],
   ];

   return $configs[$type] ?? null;
}

function getEditRecord(mysqli $conn, string $type, int $id): ?array
{
   $config = getEditConfig($type);
   if ($config === null || $id <= 0) {
      return null;
   }

   $stmt = $conn->prepare($config['query']);
   $stmt->bind_param("i", $id);
   $stmt->execute();
   $result = $stmt->get_result();
   $record = $result ? $result->fetch_assoc() : null;
   $stmt->close();

   return $record ?: null;
}

function updateEditableRecord(mysqli $conn, string $type, int $id): bool
{
   if ($id <= 0) {
      return false;
   }

   switch ($type) {
      case 'donation':
         $stmt = $conn->prepare("
            UPDATE donations
            SET donor_name = ?, donor_email = ?, donor_phone = ?, amount = ?, donation_type = ?, payment_method = ?, cause = ?, transaction_id = ?, status = ?
            WHERE id = ?
         ");
         $name = trim($_POST['donor_name'] ?? '');
         $email = trim($_POST['donor_email'] ?? '');
         $phone = trim($_POST['donor_phone'] ?? '');
         $amount = (float) ($_POST['amount'] ?? 0);
         $donationType = $_POST['donation_type'] ?? 'one-time';
         $paymentMethod = $_POST['payment_method'] ?? 'card';
         $cause = trim($_POST['cause'] ?? '');
         $transactionId = trim($_POST['transaction_id'] ?? '');
         $status = $_POST['status'] ?? 'pending';
         $stmt->bind_param("sssdsssssi", $name, $email, $phone, $amount, $donationType, $paymentMethod, $cause, $transactionId, $status, $id);
         break;

      case 'membership':
         $stmt = $conn->prepare("
            UPDATE memberships
            SET full_name = ?, email = ?, phone = ?, gender = ?, occupation = ?, education_level = ?, membership_type = ?, status = ?
            WHERE id = ?
         ");
         $fullName = trim($_POST['full_name'] ?? '');
         $email = trim($_POST['email'] ?? '');
         $phone = trim($_POST['phone'] ?? '');
         $gender = $_POST['gender'] ?? '';
         $occupation = trim($_POST['occupation'] ?? '');
         $educationLevel = trim($_POST['education_level'] ?? '');
         $membershipType = $_POST['membership_type'] ?? 'ordinary';
         $status = $_POST['status'] ?? 'pending';
         $stmt->bind_param("ssssssssi", $fullName, $email, $phone, $gender, $occupation, $educationLevel, $membershipType, $status, $id);
         break;

      case 'volunteer':
         $stmt = $conn->prepare("
            UPDATE volunteers
            SET full_name = ?, email = ?, phone = ?, gender = ?, occupation = ?, volunteer_area = ?, availability = ?, status = ?
            WHERE id = ?
         ");
         $fullName = trim($_POST['full_name'] ?? '');
         $email = trim($_POST['email'] ?? '');
         $phone = trim($_POST['phone'] ?? '');
         $gender = $_POST['gender'] ?? '';
         $occupation = trim($_POST['occupation'] ?? '');
         $volunteerArea = trim($_POST['volunteer_area'] ?? '');
         $availability = trim($_POST['availability'] ?? '');
         $status = $_POST['status'] ?? 'pending';
         $stmt->bind_param("ssssssssi", $fullName, $email, $phone, $gender, $occupation, $volunteerArea, $availability, $status, $id);
         break;

      default:
         return false;
   }

   $success = $stmt->execute();
   $stmt->close();
   return $success;
}

if (isset($_GET['logout'])) {
   $_SESSION = [];
   if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
   }
   session_destroy();
   header('Location: login.php');
   exit;
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
   header('Location: login.php');
   exit;
}

if (isset($_GET['export'])) {
   outputCsvDownload($conn, $_GET['export']);
}

$page = $_GET['page'] ?? 'dashboard';
$editType = $_GET['edit'] ?? '';
$editId = (int) ($_GET['id'] ?? 0);
$editConfig = getEditConfig($editType);
$editRecord = null;

if ($editConfig !== null && $editConfig['page'] === $page && $editId > 0) {
   $editRecord = getEditRecord($conn, $editType, $editId);
}

$stats = [];
$queries = [
   'donations' => "SELECT COUNT(*) as count, COALESCE(SUM(amount), 0) as total FROM donations",
   'memberships' => "SELECT COUNT(*) as count FROM memberships",
   'volunteers' => "SELECT COUNT(*) as count FROM volunteers",
   'contacts' => "SELECT COUNT(*) as count FROM contact_messages WHERE status = 'unread'"
];

foreach ($queries as $key => $query) {
   $result = $conn->query($query);
   $stats[$key] = $result ? $result->fetch_assoc() : ['count' => 0, 'total' => 0];
}

$donationTrends = getMonthlyTrendData($conn, 'donations', 'COALESCE(SUM(amount), 0)');
$membershipTrends = getMonthlyTrendData($conn, 'memberships');
$volunteerTrends = getMonthlyTrendData($conn, 'volunteers');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
   $action = $_POST['action'];
   $id = (int) ($_POST['id'] ?? 0);
   $table = $_POST['table'] ?? '';
   $status = $_POST['status'] ?? '';
   $redirectPage = $_POST['redirect_page'] ?? $page;
   $allowedTables = ['donations', 'memberships', 'volunteers', 'contact_messages'];

   if ($id > 0 && in_array($table, $allowedTables, true)) {
      if ($action === 'update_status') {
         $stmt = $conn->prepare("UPDATE {$table} SET status = ? WHERE id = ?");
         $stmt->bind_param("si", $status, $id);
         $stmt->execute();
         $stmt->close();
      } elseif ($action === 'delete') {
         $stmt = $conn->prepare("DELETE FROM {$table} WHERE id = ?");
         $stmt->bind_param("i", $id);
         $stmt->execute();
         $stmt->close();
      } elseif ($action === 'edit_record') {
         $recordType = $_POST['record_type'] ?? '';
         updateEditableRecord($conn, $recordType, $id);
      }
   }

   header('Location: admin.php?page=' . urlencode($redirectPage));
   exit;
}
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>AIDF Admin Dashboard</title>
   <meta name="author" content="Kleanix">
   <meta name="description" content="AIDF Administration Dashboard">
   <meta name="robots" content="NOINDEX,NOFOLLOW">
   <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
   <link rel="preconnect" href="https://fonts.googleapis.com/">
   <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&amp;family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&amp;display=swap" rel="stylesheet">
   <link rel="stylesheet" href="assets/css/app.min.css">
   <link rel="stylesheet" href="assets/css/fontawesome.min.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
   <style>
      .admin-dashboard {
         background: #f8f9fa;
         min-height: 100vh;
      }

      .sidebar {
         background: #343a40;
         color: white;
         min-height: 100vh;
         padding: 20px 0;
      }

      .sidebar .nav-link {
         color: rgba(255, 255, 255, 0.8);
         padding: 12px 20px;
         margin: 5px 0;
         border-radius: 0;
      }

      .sidebar .nav-link:hover,
      .sidebar .nav-link.active {
         color: white;
         background: #00a651;
      }

      .sidebar .nav-link i {
         margin-right: 10px;
         width: 20px;
      }

      .main-content {
         padding: 30px;
      }

      .stats-card {
         background: white;
         padding: 25px;
         border-radius: 10px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
         text-align: center;
         margin-bottom: 20px;
      }

      .stats-card .icon {
         font-size: 40px;
         color: #00a651;
         margin-bottom: 15px;
      }

      .stats-card .number {
         font-size: 32px;
         font-weight: bold;
         color: #333;
      }

      .stats-card .label {
         color: #666;
         font-size: 14px;
      }

      .data-table {
         background: white;
         border-radius: 10px;
         overflow: hidden;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      .table th {
         background: #00a651;
         color: white;
         border: none;
      }

      .status-badge {
         padding: 5px 10px;
         border-radius: 20px;
         font-size: 12px;
         font-weight: bold;
      }

      .status-pending {
         background: #fff3cd;
         color: #856404;
      }

      .status-approved {
         background: #d1ecf1;
         color: #0c5460;
      }

      .status-rejected {
         background: #f8d7da;
         color: #721c24;
      }

      .status-completed {
         background: #d4edda;
         color: #155724;
      }

      .action-btn {
         padding: 5px 10px;
         margin: 2px;
         border-radius: 5px;
         font-size: 12px;
      }

      .logout-btn {
         position: absolute;
         top: 20px;
         right: 30px;
      }

      .panel-card {
         background: #fff;
         border-radius: 16px;
         box-shadow: 0 2px 14px rgba(0, 0, 0, 0.08);
         padding: 24px;
         margin-bottom: 24px;
      }

      .panel-head {
         display: flex;
         justify-content: space-between;
         align-items: center;
         gap: 15px;
         margin-bottom: 18px;
         flex-wrap: wrap;
      }

      .chart-wrap {
         position: relative;
         height: 320px;
      }

      .export-actions {
         display: flex;
         gap: 12px;
         flex-wrap: wrap;
      }
   </style>
</head>

<body>
   <div class="admin-dashboard">
      <div class="container-fluid">
         <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
               <div class="sidebar">
                  <h4 class="text-center mb-4">
                     <i class="fas fa-cogs"></i> AIDF Admin
                  </h4>
                  <nav class="nav flex-column">
                     <a class="nav-link <?php echo $page === 'dashboard' ? 'active' : ''; ?>" href="?page=dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                     </a>
                     <a class="nav-link <?php echo $page === 'donations' ? 'active' : ''; ?>" href="?page=donations">
                        <i class="fas fa-hand-holding-heart"></i> Donations
                     </a>
                     <a class="nav-link <?php echo $page === 'memberships' ? 'active' : ''; ?>" href="?page=memberships">
                        <i class="fas fa-users"></i> Memberships
                     </a>
                     <a class="nav-link <?php echo $page === 'volunteers' ? 'active' : ''; ?>" href="?page=volunteers">
                        <i class="fas fa-hands-helping"></i> Volunteers
                     </a>
                     <a class="nav-link <?php echo $page === 'contacts' ? 'active' : ''; ?>" href="?page=contacts">
                        <i class="fas fa-envelope"></i> Messages
                     </a>
                  </nav>
               </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
               <a class="btn btn-outline-danger logout-btn" href="admin.php?logout=1">
                  <i class="fas fa-sign-out-alt"></i> Logout
               </a>

               <?php if ($page === 'dashboard'): ?>
                  <!-- Dashboard -->
                  <h2 class="mb-4">Dashboard Overview</h2>

                  <div class="row">
                     <div class="col-md-3">
                        <div class="stats-card">
                           <div class="icon"><i class="fas fa-hand-holding-heart"></i></div>
                           <div class="number"><?php echo number_format($stats['donations']['total']); ?> TZS</div>
                           <div class="label">Total Donations</div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stats-card">
                           <div class="icon"><i class="fas fa-users"></i></div>
                           <div class="number"><?php echo $stats['memberships']['count']; ?></div>
                           <div class="label">Members</div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stats-card">
                           <div class="icon"><i class="fas fa-hands-helping"></i></div>
                           <div class="number"><?php echo $stats['volunteers']['count']; ?></div>
                           <div class="label">Volunteers</div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stats-card">
                           <div class="icon"><i class="fas fa-envelope"></i></div>
                           <div class="number"><?php echo $stats['contacts']['count']; ?></div>
                           <div class="label">Unread Messages</div>
                        </div>
                     </div>
                  </div>

                  <div class="row mt-4">
                     <div class="col-12">
                        <div class="panel-card">
                           <div class="panel-head">
                              <div>
                                 <h5 class="mb-1">Monthly Trends</h5>
                                 <p class="text-muted mb-0">Last 12 months of donations, memberships, and volunteers.</p>
                              </div>
                           </div>
                           <div class="chart-wrap">
                              <canvas id="monthlyTrendsChart"></canvas>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="data-table">
                           <h5 class="p-3 mb-0">Recent Donations</h5>
                           <table class="table table-striped mb-0">
                              <thead>
                                 <tr>
                                    <th>Donor</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $recent_donations = $conn->query("SELECT donor_name, amount, created_at, status FROM donations ORDER BY created_at DESC LIMIT 5");
                                 while ($donation = $recent_donations->fetch_assoc()):
                                 ?>
                                    <tr>
                                       <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                       <td><?php echo number_format($donation['amount']); ?> TZS</td>
                                       <td><?php echo date('M d, Y', strtotime($donation['created_at'])); ?></td>
                                       <td><span class="status-badge status-<?php echo $donation['status']; ?>"><?php echo ucfirst($donation['status']); ?></span></td>
                                    </tr>
                                 <?php endwhile; ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="data-table">
                           <h5 class="p-3 mb-0">Recent Applications</h5>
                           <table class="table table-striped mb-0">
                              <thead>
                                 <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $recent_apps = $conn->query("
                                       SELECT 'Membership' as type, full_name, created_at, status FROM memberships
                                       UNION ALL
                                       SELECT 'Volunteer' as type, full_name, created_at, status FROM volunteers
                                       ORDER BY created_at DESC LIMIT 5
                                    ");
                                 while ($app = $recent_apps->fetch_assoc()):
                                 ?>
                                    <tr>
                                       <td><?php echo $app['type']; ?></td>
                                       <td><?php echo htmlspecialchars($app['full_name']); ?></td>
                                       <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                                       <td><span class="status-badge status-<?php echo $app['status']; ?>"><?php echo ucfirst($app['status']); ?></span></td>
                                    </tr>
                                 <?php endwhile; ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>

               <?php elseif ($page === 'donations'): ?>
                  <!-- Donations Management -->
                  <h2 class="mb-4">Donations Management</h2>
                  <?php if ($editRecord !== null && $editType === 'donation'): ?>
                     <div class="panel-card">
                        <div class="panel-head">
                           <div>
                              <h5 class="mb-1"><?php echo $editConfig['title']; ?></h5>
                              <p class="text-muted mb-0">Update donation details and save changes.</p>
                           </div>
                           <a class="btn btn-outline-secondary" href="admin.php?page=donations">Close</a>
                        </div>
                        <form method="post" class="row g-3">
                           <input type="hidden" name="action" value="edit_record">
                           <input type="hidden" name="table" value="donations">
                           <input type="hidden" name="record_type" value="donation">
                           <input type="hidden" name="id" value="<?php echo $editRecord['id']; ?>">
                           <input type="hidden" name="redirect_page" value="donations">
                           <div class="col-md-6">
                              <label class="form-label">Donor Name</label>
                              <input type="text" class="form-control" name="donor_name" value="<?php echo htmlspecialchars($editRecord['donor_name']); ?>" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" name="donor_email" value="<?php echo htmlspecialchars($editRecord['donor_email']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Phone</label>
                              <input type="text" class="form-control" name="donor_phone" value="<?php echo htmlspecialchars($editRecord['donor_phone']); ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Amount</label>
                              <input type="number" step="0.01" min="0" class="form-control" name="amount" value="<?php echo htmlspecialchars($editRecord['amount']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Status</label>
                              <select class="form-select" name="status">
                                 <option value="pending" <?php echo $editRecord['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                 <option value="completed" <?php echo $editRecord['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                 <option value="failed" <?php echo $editRecord['status'] === 'failed' ? 'selected' : ''; ?>>Failed</option>
                                 <option value="cancelled" <?php echo $editRecord['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Donation Type</label>
                              <select class="form-select" name="donation_type">
                                 <option value="one-time" <?php echo $editRecord['donation_type'] === 'one-time' ? 'selected' : ''; ?>>One-time</option>
                                 <option value="monthly" <?php echo $editRecord['donation_type'] === 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                                 <option value="yearly" <?php echo $editRecord['donation_type'] === 'yearly' ? 'selected' : ''; ?>>Yearly</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Payment Method</label>
                              <select class="form-select" name="payment_method">
                                 <option value="card" <?php echo $editRecord['payment_method'] === 'card' ? 'selected' : ''; ?>>Card</option>
                                 <option value="bank" <?php echo $editRecord['payment_method'] === 'bank' ? 'selected' : ''; ?>>Bank</option>
                                 <option value="mobile" <?php echo $editRecord['payment_method'] === 'mobile' ? 'selected' : ''; ?>>Mobile</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Cause</label>
                              <input type="text" class="form-control" name="cause" value="<?php echo htmlspecialchars($editRecord['cause']); ?>">
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Transaction ID</label>
                              <input type="text" class="form-control" name="transaction_id" value="<?php echo htmlspecialchars($editRecord['transaction_id']); ?>">
                           </div>
                           <div class="col-12">
                              <button type="submit" class="btn btn-success">Save Donation</button>
                           </div>
                        </form>
                     </div>
                  <?php endif; ?>
                  <div class="data-table">
                     <table id="donationsTable" class="table table-striped">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Donor</th>
                              <th>Email</th>
                              <th>Amount</th>
                              <th>Type</th>
                              <th>Method</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $donations = $conn->query("SELECT * FROM donations ORDER BY created_at DESC");
                           while ($donation = $donations->fetch_assoc()):
                           ?>
                              <tr>
                                 <td><?php echo $donation['id']; ?></td>
                                 <td><?php echo htmlspecialchars($donation['donor_name']); ?></td>
                                 <td><?php echo htmlspecialchars($donation['donor_email']); ?></td>
                                 <td><?php echo number_format($donation['amount']); ?> TZS</td>
                                 <td><?php echo ucfirst($donation['donation_type']); ?></td>
                                 <td><?php echo ucfirst($donation['payment_method']); ?></td>
                                 <td><span class="status-badge status-<?php echo $donation['status']; ?>"><?php echo ucfirst($donation['status']); ?></span></td>
                                 <td><?php echo date('M d, Y H:i', strtotime($donation['created_at'])); ?></td>
                                 <td>
                                    <form method="post" style="display: inline;">
                                       <input type="hidden" name="action" value="update_status">
                                       <input type="hidden" name="table" value="donations">
                                       <input type="hidden" name="id" value="<?php echo $donation['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="donations">
                                       <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                          <option value="pending" <?php echo $donation['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                          <option value="completed" <?php echo $donation['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                          <option value="failed" <?php echo $donation['status'] === 'failed' ? 'selected' : ''; ?>>Failed</option>
                                       </select>
                                    </form>
                                    <a class="btn btn-sm btn-primary action-btn" href="admin.php?page=donations&amp;edit=donation&amp;id=<?php echo $donation['id']; ?>">Edit</a>
                                    <form method="post" style="display: inline;" onsubmit="return confirmDelete('donation record');">
                                       <input type="hidden" name="action" value="delete">
                                       <input type="hidden" name="table" value="donations">
                                       <input type="hidden" name="id" value="<?php echo $donation['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="donations">
                                       <button type="submit" class="btn btn-sm btn-danger action-btn">Delete</button>
                                    </form>
                                 </td>
                              </tr>
                           <?php endwhile; ?>
                        </tbody>
                     </table>
                  </div>

               <?php elseif ($page === 'memberships'): ?>
                  <!-- Memberships Management -->
                  <div class="panel-card">
                     <div class="panel-head">
                        <div>
                           <h2 class="mb-1">Membership Applications</h2>
                           <p class="text-muted mb-0">Download all membership submissions as a CSV file.</p>
                        </div>
                        <div class="export-actions">
                           <a class="btn btn-success" href="admin.php?page=memberships&amp;export=memberships">
                              <i class="fas fa-download"></i> Download Members CSV
                           </a>
                        </div>
                     </div>
                  </div>
                  <?php if ($editRecord !== null && $editType === 'membership'): ?>
                     <div class="panel-card">
                        <div class="panel-head">
                           <div>
                              <h5 class="mb-1"><?php echo $editConfig['title']; ?></h5>
                              <p class="text-muted mb-0">Update member details and save changes.</p>
                           </div>
                           <a class="btn btn-outline-secondary" href="admin.php?page=memberships">Close</a>
                        </div>
                        <form method="post" class="row g-3">
                           <input type="hidden" name="action" value="edit_record">
                           <input type="hidden" name="table" value="memberships">
                           <input type="hidden" name="record_type" value="membership">
                           <input type="hidden" name="id" value="<?php echo $editRecord['id']; ?>">
                           <input type="hidden" name="redirect_page" value="memberships">
                           <div class="col-md-6">
                              <label class="form-label">Full Name</label>
                              <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($editRecord['full_name']); ?>" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($editRecord['email']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Phone</label>
                              <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($editRecord['phone']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Gender</label>
                              <select class="form-select" name="gender">
                                 <option value="">Not specified</option>
                                 <option value="male" <?php echo $editRecord['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                 <option value="female" <?php echo $editRecord['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                                 <option value="other" <?php echo $editRecord['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Status</label>
                              <select class="form-select" name="status">
                                 <option value="pending" <?php echo $editRecord['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                 <option value="approved" <?php echo $editRecord['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                 <option value="rejected" <?php echo $editRecord['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Occupation</label>
                              <input type="text" class="form-control" name="occupation" value="<?php echo htmlspecialchars($editRecord['occupation']); ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Education Level</label>
                              <input type="text" class="form-control" name="education_level" value="<?php echo htmlspecialchars($editRecord['education_level']); ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Membership Type</label>
                              <select class="form-select" name="membership_type">
                                 <option value="ordinary" <?php echo $editRecord['membership_type'] === 'ordinary' ? 'selected' : ''; ?>>Ordinary Member</option>
                                 <option value="college_student" <?php echo $editRecord['membership_type'] === 'college_student' ? 'selected' : ''; ?>>College Student</option>
                                 <option value="institutional" <?php echo $editRecord['membership_type'] === 'institutional' ? 'selected' : ''; ?>>Institutional Member</option>
                                 <option value="honorary" <?php echo $editRecord['membership_type'] === 'honorary' ? 'selected' : ''; ?>>Honorary Member</option>
                              </select>
                           </div>
                           <div class="col-12">
                              <button type="submit" class="btn btn-success">Save Member</button>
                           </div>
                        </form>
                     </div>
                  <?php endif; ?>
                  <div class="data-table">
                     <table id="membershipsTable" class="table table-striped">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Type</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $memberships = $conn->query("SELECT * FROM memberships ORDER BY created_at DESC");
                           while ($member = $memberships->fetch_assoc()):
                           ?>
                              <tr>
                                 <td><?php echo $member['id']; ?></td>
                                 <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                                 <td><?php echo htmlspecialchars($member['email']); ?></td>
                                 <td><?php echo htmlspecialchars(formatMembershipType($member['membership_type'])); ?></td>
                                 <td><span class="status-badge status-<?php echo $member['status']; ?>"><?php echo ucfirst($member['status']); ?></span></td>
                                 <td><?php echo date('M d, Y H:i', strtotime($member['created_at'])); ?></td>
                                 <td>
                                    <form method="post" style="display: inline;">
                                       <input type="hidden" name="action" value="update_status">
                                       <input type="hidden" name="table" value="memberships">
                                       <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="memberships">
                                       <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                          <option value="pending" <?php echo $member['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                          <option value="approved" <?php echo $member['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                          <option value="rejected" <?php echo $member['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                       </select>
                                    </form>
                                    <a class="btn btn-sm btn-primary action-btn" href="admin.php?page=memberships&amp;edit=membership&amp;id=<?php echo $member['id']; ?>">Edit</a>
                                    <button class="btn btn-sm btn-info action-btn" onclick="viewDetails('membership', <?php echo $member['id']; ?>)">View</button>
                                    <form method="post" style="display: inline;" onsubmit="return confirmDelete('member record');">
                                       <input type="hidden" name="action" value="delete">
                                       <input type="hidden" name="table" value="memberships">
                                       <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="memberships">
                                       <button type="submit" class="btn btn-sm btn-danger action-btn">Delete</button>
                                    </form>
                                 </td>
                              </tr>
                           <?php endwhile; ?>
                        </tbody>
                     </table>
                  </div>

               <?php elseif ($page === 'volunteers'): ?>
                  <!-- Volunteers Management -->
                  <div class="panel-card">
                     <div class="panel-head">
                        <div>
                           <h2 class="mb-1">Volunteer Applications</h2>
                           <p class="text-muted mb-0">Download all volunteer submissions as a CSV file.</p>
                        </div>
                        <div class="export-actions">
                           <a class="btn btn-success" href="admin.php?page=volunteers&amp;export=volunteers">
                              <i class="fas fa-download"></i> Download Volunteers CSV
                           </a>
                        </div>
                     </div>
                  </div>
                  <?php if ($editRecord !== null && $editType === 'volunteer'): ?>
                     <div class="panel-card">
                        <div class="panel-head">
                           <div>
                              <h5 class="mb-1"><?php echo $editConfig['title']; ?></h5>
                              <p class="text-muted mb-0">Update volunteer details and save changes.</p>
                           </div>
                           <a class="btn btn-outline-secondary" href="admin.php?page=volunteers">Close</a>
                        </div>
                        <form method="post" class="row g-3">
                           <input type="hidden" name="action" value="edit_record">
                           <input type="hidden" name="table" value="volunteers">
                           <input type="hidden" name="record_type" value="volunteer">
                           <input type="hidden" name="id" value="<?php echo $editRecord['id']; ?>">
                           <input type="hidden" name="redirect_page" value="volunteers">
                           <div class="col-md-6">
                              <label class="form-label">Full Name</label>
                              <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($editRecord['full_name']); ?>" required>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($editRecord['email']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Phone</label>
                              <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($editRecord['phone']); ?>" required>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Gender</label>
                              <select class="form-select" name="gender">
                                 <option value="">Not specified</option>
                                 <option value="male" <?php echo $editRecord['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                 <option value="female" <?php echo $editRecord['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                                 <option value="other" <?php echo $editRecord['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Status</label>
                              <select class="form-select" name="status">
                                 <option value="pending" <?php echo $editRecord['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                 <option value="approved" <?php echo $editRecord['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                 <option value="rejected" <?php echo $editRecord['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                 <option value="active" <?php echo $editRecord['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                 <option value="inactive" <?php echo $editRecord['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                              </select>
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Occupation</label>
                              <input type="text" class="form-control" name="occupation" value="<?php echo htmlspecialchars($editRecord['occupation']); ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Volunteer Area</label>
                              <input type="text" class="form-control" name="volunteer_area" value="<?php echo htmlspecialchars($editRecord['volunteer_area']); ?>">
                           </div>
                           <div class="col-md-4">
                              <label class="form-label">Availability</label>
                              <input type="text" class="form-control" name="availability" value="<?php echo htmlspecialchars($editRecord['availability']); ?>">
                           </div>
                           <div class="col-12">
                              <button type="submit" class="btn btn-success">Save Volunteer</button>
                           </div>
                        </form>
                     </div>
                  <?php endif; ?>
                  <div class="data-table">
                     <table id="volunteersTable" class="table table-striped">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Interests</th>
                              <th>Availability</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $volunteers = $conn->query("SELECT * FROM volunteers ORDER BY created_at DESC");
                           while ($volunteer = $volunteers->fetch_assoc()):
                           ?>
                              <tr>
                                 <td><?php echo $volunteer['id']; ?></td>
                                 <td><?php echo htmlspecialchars($volunteer['full_name']); ?></td>
                                 <td><?php echo htmlspecialchars($volunteer['email']); ?></td>
                                 <td><?php echo htmlspecialchars(implode(', ', json_decode($volunteer['interests'], true))); ?></td>
                                 <td><?php echo ucfirst($volunteer['availability']); ?></td>
                                 <td><span class="status-badge status-<?php echo $volunteer['status']; ?>"><?php echo ucfirst($volunteer['status']); ?></span></td>
                                 <td><?php echo date('M d, Y H:i', strtotime($volunteer['created_at'])); ?></td>
                                 <td>
                                    <form method="post" style="display: inline;">
                                       <input type="hidden" name="action" value="update_status">
                                       <input type="hidden" name="table" value="volunteers">
                                       <input type="hidden" name="id" value="<?php echo $volunteer['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="volunteers">
                                       <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                          <option value="pending" <?php echo $volunteer['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                          <option value="approved" <?php echo $volunteer['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                          <option value="rejected" <?php echo $volunteer['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                       </select>
                                    </form>
                                    <a class="btn btn-sm btn-primary action-btn" href="admin.php?page=volunteers&amp;edit=volunteer&amp;id=<?php echo $volunteer['id']; ?>">Edit</a>
                                    <button class="btn btn-sm btn-info action-btn" onclick="viewDetails('volunteer', <?php echo $volunteer['id']; ?>)">View</button>
                                    <form method="post" style="display: inline;" onsubmit="return confirmDelete('volunteer record');">
                                       <input type="hidden" name="action" value="delete">
                                       <input type="hidden" name="table" value="volunteers">
                                       <input type="hidden" name="id" value="<?php echo $volunteer['id']; ?>">
                                       <input type="hidden" name="redirect_page" value="volunteers">
                                       <button type="submit" class="btn btn-sm btn-danger action-btn">Delete</button>
                                    </form>
                                 </td>
                              </tr>
                           <?php endwhile; ?>
                        </tbody>
                     </table>
                  </div>

               <?php elseif ($page === 'contacts'): ?>
                  <!-- Contact Messages -->
                  <h2 class="mb-4">Contact Messages</h2>
                  <div class="data-table">
                     <table id="contactsTable" class="table table-striped">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Subject</th>
                              <th>Status</th>
                              <th>Date</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $contacts = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
                           while ($contact = $contacts->fetch_assoc()):
                           ?>
                              <tr>
                                 <td><?php echo $contact['id']; ?></td>
                                 <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                 <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                 <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                                 <td><span class="status-badge status-<?php echo $contact['status']; ?>"><?php echo ucfirst($contact['status']); ?></span></td>
                                 <td><?php echo date('M d, Y H:i', strtotime($contact['created_at'])); ?></td>
                                 <td>
                                    <button class="btn btn-sm btn-info action-btn" onclick="viewMessage(<?php echo $contact['id']; ?>)">View</button>
                                    <?php if ($contact['status'] === 'unread'): ?>
                                       <form method="post" style="display: inline;">
                                          <input type="hidden" name="action" value="update_status">
                                          <input type="hidden" name="table" value="contact_messages">
                                          <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                          <input type="hidden" name="status" value="read">
                                          <input type="hidden" name="redirect_page" value="contacts">
                                          <button type="submit" class="btn btn-sm btn-success action-btn">Mark Read</button>
                                       </form>
                                    <?php endif; ?>
                                 </td>
                              </tr>
                           <?php endwhile; ?>
                        </tbody>
                     </table>
                  </div>
               <?php endif; ?>
            </div>
         </div>
      </div>
   </div>

   <!-- Details Modal -->
   <div class="modal fade" id="detailsModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Application Details</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
               <!-- Content will be loaded here -->
            </div>
         </div>
      </div>
   </div>

   <div class="col-lg-6">
      <p class="copyright-text">With Love <i class="fal fa-copyright"></i> 2026 <a href="#home-sec">Developed By:</a>.Erick Boniventure.</p>
   </div>

   <script src="assets/js/vendor/jquery-3.7.1.min.js"></script>
   <script src="assets/js/app.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script>
      $(document).ready(function() {
         $('#donationsTable, #membershipsTable, #volunteersTable, #contactsTable').DataTable({
            "pageLength": 25,
            "order": [
               [0, "desc"]
            ]
         });

         const trendCanvas = document.getElementById('monthlyTrendsChart');
         if (trendCanvas) {
            new Chart(trendCanvas, {
               type: 'line',
               data: {
                  labels: <?php echo json_encode($donationTrends['labels']); ?>,
                  datasets: [{
                        label: 'Donations (TZS)',
                        data: <?php echo json_encode($donationTrends['values']); ?>,
                        borderColor: '#00a651',
                        backgroundColor: 'rgba(0, 166, 81, 0.12)',
                        tension: 0.35,
                        fill: true,
                        yAxisID: 'yAmount'
                     },
                     {
                        label: 'Memberships',
                        data: <?php echo json_encode($membershipTrends['values']); ?>,
                        borderColor: '#1f4e79',
                        backgroundColor: 'rgba(31, 78, 121, 0.10)',
                        tension: 0.35,
                        fill: false,
                        yAxisID: 'yCount'
                     },
                     {
                        label: 'Volunteers',
                        data: <?php echo json_encode($volunteerTrends['values']); ?>,
                        borderColor: '#ff8c42',
                        backgroundColor: 'rgba(255, 140, 66, 0.10)',
                        tension: 0.35,
                        fill: false,
                        yAxisID: 'yCount'
                     }
                  ]
               },
               options: {
                  maintainAspectRatio: false,
                  interaction: {
                     mode: 'index',
                     intersect: false
                  },
                  plugins: {
                     legend: {
                        position: 'top'
                     }
                  },
                  scales: {
                     yAmount: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        ticks: {
                           callback: function(value) {
                              return Number(value).toLocaleString() + ' TZS';
                           }
                        }
                     },
                     yCount: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                           drawOnChartArea: false
                        },
                        ticks: {
                           precision: 0
                        }
                     }
                  }
               }
            });
         }
      });

      function viewDetails(type, id) {
         fetch(`get_details.php?type=${type}&id=${id}`)
            .then(response => response.text())
            .then(data => {
               document.getElementById('modalContent').innerHTML = data;
               new bootstrap.Modal(document.getElementById('detailsModal')).show();
            });
      }

      function viewMessage(id) {
         fetch(`get_details.php?type=message&id=${id}`)
            .then(response => response.text())
            .then(data => {
               document.getElementById('modalContent').innerHTML = data;
               new bootstrap.Modal(document.getElementById('detailsModal')).show();
            });
      }

      function confirmDelete(label) {
         return confirm(`Delete this ${label}? This action cannot be undone.`);
      }
   </script>
</body>

</html>
