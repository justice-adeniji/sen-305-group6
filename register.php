<?php
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (!$username || !$email || !$password || !$confirm) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM `users` WHERE `username` = ? OR `email` = ? LIMIT 1");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = 'Username or Email is already registered. Please choose another or log in.';
        } else {
            // Hash password and insert
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)");
            if ($insert->execute([$username, $email, $hashed])) {
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - SEN 305 Group 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form method="POST" action="register.php">
        <h2>Create an Account</h2>
        <p style="text-align: center; color: #bbb; font-size: 0.9rem; margin-top: -10px;">SEN 305 - Group 6</p>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <label for="username">Username / Matric No:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required placeholder="e.g. VUG/SEN/24/12345">

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required placeholder="student@example.com">

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required minlength="6" placeholder="At least 6 characters">

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required minlength="6" placeholder="Re-type password">

        <button type="submit">Register</button>

        <p style="text-align: center; margin-top: 15px; font-size: 0.9rem;">
            Already have an account? <a href="login.php" style="color: #64b5f6; text-decoration: none; font-weight: bold;">Log in here</a>
        </p>
    </form>

</body>
</html>
