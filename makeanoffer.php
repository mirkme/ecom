<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerid'])) {
    $response = array('success' => false, 'message' => 'User not logged in');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$conn = new mysqli("localhost", "root", "", "hack");

// Check connection
if ($conn->connect_error) {
    die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
}

// Get user ID from session
$customerid = $_SESSION['customerid'];

// Validate and sanitize product ID
$pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT);
if ($pid === false) {
    $response = array('success' => false, 'message' => 'Invalid product ID');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Validate and sanitize customernegotiateprice
$customernegotiateprice = filter_input(INPUT_POST, 'customernegotiateprice', FILTER_VALIDATE_FLOAT);
if ($customernegotiateprice === false) {
    $response = array('success' => false, 'message' => 'Invalid customernegotiateprice');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}


// Check if the negotiate record already exists
$checkNegotiateStmt = $conn->prepare("SELECT * FROM negotiate WHERE pid = ? AND customerid = ?");
$checkNegotiateStmt->bind_param("ii", $pid, $customerid);
$checkNegotiateStmt->execute();
$checkNegotiateStmt->store_result();

if ($checkNegotiateStmt->num_rows > 0) {
    // Negotiate record already exists, update the customernegotiateprice
    $updateNegotiateStmt = $conn->prepare("UPDATE negotiate SET customernegotiateprice = ? WHERE pid = ? AND customerid = ?");
    $updateNegotiateStmt->bind_param("dii", $customernegotiateprice, $pid, $customerid);

    if ($updateNegotiateStmt->execute()) {
        // Fetch negotiableamount and productprice from products table
        $fetchProductDetailsStmt = $conn->prepare("SELECT negotiableamount, productprice FROM products WHERE pid = ?");
        $fetchProductDetailsStmt->bind_param("i", $pid);
        $fetchProductDetailsStmt->execute();
        $fetchProductDetailsStmt->bind_result($negotiableamount, $productprice);
        $fetchProductDetailsStmt->fetch();
        $fetchProductDetailsStmt->close();

        // Compare customernegotiateprice with negotiableamount and productprice
        if ($customernegotiateprice >= $negotiableamount && $customernegotiateprice <= $productprice) {
            $response = array(
                'success' => true,
                'message' => 'Offer accepted. Choose an action:',
                'actions' => array('negotiate again', 'stop negotiation', 'proceed to pay')
            );
        } else {
            $response = array('success' => false, 'message' => 'Offer rejected. Choose an action:', 'actions' => array('negotiate again', 'stop negotiation'));
        }

        $updateNegotiateStmt->close();
    } else {
        $response = array('success' => false, 'message' => 'Failed to update negotiate price');
    }
} else {
    // Negotiate record does not exist, insert a new record
    $insertNegotiateStmt = $conn->prepare("INSERT INTO negotiate (pid, customerid, customernegotiateprice) VALUES (?, ?, ?)");
    $insertNegotiateStmt->bind_param("iid", $pid, $customerid, $customernegotiateprice);

    if ($insertNegotiateStmt->execute()) {
        $response = array('success' => true, 'message' => 'Negotiate price added successfully');
    } else {
        $response = array('success' => false, 'message' => 'Failed to add negotiate price');
    }

    $insertNegotiateStmt->close();
}

$checkNegotiateStmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>