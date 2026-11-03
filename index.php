<?php
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$currentUser = $_SESSION['username'] ?? 'Student';
$currentEmail = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Biodata Form - SEN 305 Group 6</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>

    <header class="top-nav">
        <div class="nav-brand">
            <strong>SEN 305</strong> &bull; Group 6
        </div>
        <div class="nav-user">
            <span>Welcome, <strong><?php echo htmlspecialchars($currentUser); ?></strong></span>
            <a href="view_biodata.php" class="nav-link">View Records</a>
            <a href="logout.php" class="nav-btn logout-btn">Logout</a>
        </div>
    </header>

    <main class="form-container">
        <form id="biodataForm">
            <h2>Student Biodata</h2>
            <p class="form-subtitle">Fill in your information to store in the database</p>

            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" placeholder="e.g. Adeniji Justice Adeyemi" required>

            <label for="matric">Matric Number:</label>
            <input type="text" id="matric" name="matric" placeholder="e.g. VUG/SEN/24/11401" value="<?php echo htmlspecialchars($currentUser); ?>" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="e.g. student@veritas.edu.ng" value="<?php echo htmlspecialchars($currentEmail); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="level">Level:</label>
            <select id="level" name="level" required>
                <option value="">Select level</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="300">300</option>
                <option value="400">400</option>
            </select>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" placeholder="e.g. Software Engineering" required>

            <button type="submit">Submit Biodata</button>

            <p id="message" role="status"></p>

            <div style="text-align: center; margin-top: 15px;">
                <a href="view_biodata.php" style="color: #64b5f6; font-size: 0.9rem; text-decoration: none;">&rarr; View All Submitted Records</a>
            </div>
        </form>
    </main>

</body>
</html>
