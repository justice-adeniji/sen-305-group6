<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Please log in before submitting biodata.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    $data = $_POST;
}

$fullname   = trim($data['fullname'] ?? '');
$matric_no  = trim($data['matric_no'] ?? '');
$email      = trim($data['email'] ?? '');
$dob        = trim($data['dob'] ?? '');
$level      = trim($data['level'] ?? '');
$gender     = trim($data['gender'] ?? '');
$department = trim($data['department'] ?? '');

if (!$fullname || !$matric_no || !$email || !$dob || !$level || !$gender || !$department) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required.'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

$dobTimestamp = strtotime($dob);
$todayTimestamp = strtotime('today midnight');

if (!$dobTimestamp || $dobTimestamp >= $todayTimestamp) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Date of birth must be a valid date in the past.'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO `biodata` (`user_id`, `fullname`, `matric_no`, `email`, `dob`, `level`, `gender`, `department`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $fullname,
        $matric_no,
        $email,
        $dob,
        $level,
        $gender,
        $department
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Biodata submitted and saved to database successfully!'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
