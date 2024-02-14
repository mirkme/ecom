<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerid'])) {
    $response = array('activeSession' => false, 'message' => 'User not logged in');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Check if the product ID is provided
if (!isset($_POST['pid'])) {
    $response = array('message' => 'Product ID is required for removal');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$customerid = $_SESSION['customerid'];
$pid = $_POST['pid'];

// Replace this with your actual database connection and query
$conn = new mysqli("localhost", "root", "", "hack");

// Check connection
if ($conn->connect_error) {
    die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
}

// Use prepared statement to prevent SQL injection
$sql = "DELETE FROM negotiate WHERE customerid = ? AND pid = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $response = array('message' => 'Failed to prepare statement');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$stmt->bind_param("ii", $customerid, $pid);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $response = array('message' => 'Product removed from negotiation successfully');
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('message' => 'Product removal from negotiation failed');
    header('Content-Type: application/json');
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
