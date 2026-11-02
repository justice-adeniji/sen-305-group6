<?php
require_once __DIR__ . '/db.php';

// Authentication check
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$currentUser = $_SESSION['username'] ?? 'Student';

// Fetch all biodata records
try {
    $stmt = $pdo->query("SELECT * FROM `biodata` ORDER BY `id` DESC");
    $records = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to load records: " . $e->getMessage();
    $records = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Biodata Records - SEN 305 Group 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="top-nav">
        <div class="nav-brand">
            <strong>SEN 305</strong> &bull; Group 6
        </div>
        <div class="nav-user">
            <span>Logged in as: <strong><?php echo htmlspecialchars($currentUser); ?></strong></span>
            <a href="index.php" class="nav-link">+ New Biodata</a>
            <a href="logout.php" class="nav-btn logout-btn">Logout</a>
        </div>
    </header>

    <div class="table-container">
        <div class="table-header">
            <h2>Database Records: Student Biodata</h2>
            <p>Database: <code>sen305-group6</code> | Total records: <strong><?php echo count($records); ?></strong></p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (empty($records)): ?>
            <div class="no-records">
                <p>No biodata records found in the database yet.</p>
                <a href="index.php" class="inline-btn">Submit First Biodata Entry</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Matric Number</th>
                            <th>Email</th>
                            <th>Date of Birth</th>
                            <th>Level</th>
                            <th>Gender</th>
                            <th>Department</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><strong><?php echo htmlspecialchars($row['fullname']); ?></strong></td>
                                <td><code><?php echo htmlspecialchars($row['matric_no']); ?></code></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['dob']); ?></td>
                                <td><?php echo htmlspecialchars($row['level']); ?></td>
                                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                <td><?php echo htmlspecialchars($row['department']); ?></td>
                                <td><small><?php echo htmlspecialchars($row['submitted_at']); ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 25px;">
            <a href="index.php" class="inline-btn">&larr; Back to Biodata Form</a>
        </div>
    </div>

</body>
</html>
