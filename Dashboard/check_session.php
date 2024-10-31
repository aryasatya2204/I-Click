<?php
session_start();
include '../login/config.php';

$response = array(
    'isLoggedIn' => false,
    'username' => ''
);

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
    $sql = "SELECT name FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $response['isLoggedIn'] = true;
        $response['username'] = htmlspecialchars($user['name']);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>