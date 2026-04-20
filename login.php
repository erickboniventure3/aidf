<?php
session_start();
require_once 'conf/conf.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $loginError = 'Enter both username and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, full_name, status FROM admin_users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            if ($admin['status'] !== 'active') {
                $loginError = 'This admin account is inactive.';
            } elseif (password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = (int) $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_name'] = $admin['full_name'] ?: $admin['username'];

                $updateStmt = $conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $updateStmt->bind_param("i", $admin['id']);
                $updateStmt->execute();
                $updateStmt->close();

                header('Location: admin.php');
                exit;
            } else {
                $loginError = 'Invalid username or password.';
            }
        } else {
            $loginError = 'Invalid username or password.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Login | AIDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: "DM Sans", Arial, sans-serif;
            background:
                linear-gradient(135deg, rgba(0, 92, 48, 0.92), rgba(4, 31, 24, 0.95)),
                url('assets/img/bg/about-sec-3-bg.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-shell {
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            overflow: hidden;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            background: #fff;
        }

        .login-brand {
            padding: 56px;
            color: #fff;
            background: linear-gradient(180deg, rgba(0, 128, 72, 0.92), rgba(0, 74, 51, 0.95));
            position: relative;
        }

        .login-brand h1 {
            font-size: 2.5rem;
            margin-bottom: 18px;
        }

        .login-brand p {
            color: rgba(255, 255, 255, 0.88);
            max-width: 420px;
            line-height: 1.7;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            margin-bottom: 28px;
            font-size: 0.95rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .login-card {
            padding: 56px 44px;
            background: #f8fbf9;
            display: flex;
            align-items: center;
        }

        .login-card-inner {
            width: 100%;
        }

        .login-card h2 {
            color: #123524;
            margin-bottom: 10px;
        }

        .login-card p {
            color: #5a6f63;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #1d3328;
        }

        .form-control {
            min-height: 52px;
            border-radius: 14px;
            border: 1px solid #d3e0d7;
            background: #fff;
        }

        .form-control:focus {
            border-color: #00a651;
            box-shadow: 0 0 0 0.2rem rgba(0, 166, 81, 0.15);
        }

        .login-btn {
            min-height: 52px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, #00a651, #007a3d);
            font-weight: 700;
        }

        .login-note {
            margin-top: 20px;
            font-size: 0.95rem;
            color: #5a6f63;
        }

        @media (max-width: 991px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .login-brand,
            .login-card {
                padding: 36px 28px;
            }
        }
    </style>
</head>
<body>
    <div class="login-shell">
        <section class="login-brand">
            <div class="brand-badge">
                <i class="fas fa-shield-alt"></i>
                <span>AIDF Admin Portal</span>
            </div>
            <h1>Secure access for the admin dashboard.</h1>
            <p>Sign in to review donations, membership applications, volunteer requests, and contact messages from one place.</p>
        </section>

        <section class="login-card">
            <div class="login-card-inner">
                <h2>Admin Login</h2>
                <p>Use your administrator account to continue.</p>

                <?php if ($loginError !== ''): ?>
                    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($loginError); ?></div>
                <?php endif; ?>

                <form method="post" action="login.php" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-success w-100 login-btn">Login to Dashboard</button>
                </form>

                
            </div>
        </section>
    </div>
</body>
</html>
