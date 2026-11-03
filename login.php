<?php
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$message = '';

if (isset($_GET['registered'])) {
    $message = 'Registration successful! Please log in.';
} elseif (isset($_GET['logged_out'])) {
    $message = 'You have been logged out successfully.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = trim($_POST['login_input'] ?? '');
    $password    = $_POST['password'] ?? '';

    if (!$login_input || !$password) {
        $error = 'Please enter both username/email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `username` = ? OR `email` = ? LIMIT 1");
        $stmt->execute([$login_input, $login_input]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username/email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - SEN 305 Group 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form method="POST" action="login.php">
        <h2>Student Login</h2>
        <p style="text-align: center; color: #bbb; font-size: 0.9rem; margin-top: -10px;">SEN 305 - Group 6</p>

        <?php if (!empty($message)): ?>
            <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <label for="login_input">Username or Email:</label>
        <input type="text" id="login_input" name="login_input" value="<?php echo htmlspecialchars($_POST['login_input'] ?? ''); ?>" required placeholder="Username or Matric No">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Enter password">

        <button type="submit">Log In</button>

        <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
            Don't have an account? <a href="register.php" style="color: #64b5f6; text-decoration: none; font-weight: bold;">Sign up here</a>
        </p>
    </form>

</body>
</html>
