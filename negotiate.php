<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerid'])) {
    $response = array('activeSession' => false);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Simulate fetching data from the database
// Replace this with your actual database connection and query
$conn = new mysqli("localhost", "root", "", "hack");

if ($conn->connect_error) {
    die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
}

$customerid = $_SESSION['customerid'];
$sql = "SELECT * FROM negotiate WHERE customerid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerid);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: application/json');

if ($result !== null && $result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'pid' => $row['pid'],
            'productname' => $row['productname'],
            'productquantity' => $row['productquantity'],
            'productprice' => $row['productprice'],
            'productcategory' => $row['productcategory'],
            'productcolour' => $row['productcolour'],
            'productlink' => $row['productlink'],
            'added_at' => $row['added_at']
        );
    }

    echo json_encode($data);
} else {
    $response = array('message' => 'No orders found for the current user');
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>