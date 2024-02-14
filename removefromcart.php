<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customerid'])) {
    $response = array('activeSession' => false);
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

// Get the current product quantity in the cart
$conn = new mysqli("localhost", "root", "", "hack");

if ($conn->connect_error) {
    die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
}

// Check if product quantity in cart is greater than 0
$sqlCartQuantity = "SELECT productquantity FROM cart WHERE customerid = ? AND pid = ?";
$stmtCartQuantity = $conn->prepare($sqlCartQuantity);
$stmtCartQuantity->bind_param("ii", $customerid, $pid);
$stmtCartQuantity->execute();
$stmtCartQuantity->bind_result($cartQuantity);
$stmtCartQuantity->fetch();
$stmtCartQuantity->close();

if ($cartQuantity > 0) {
    // Subtract 1 from product quantity in cart
    $sqlUpdateCart = "UPDATE cart SET productquantity = productquantity - 1 WHERE customerid = ? AND pid = ?";
    $stmtUpdateCart = $conn->prepare($sqlUpdateCart);
    $stmtUpdateCart->bind_param("ii", $customerid, $pid);
    $stmtUpdateCart->execute();
    $stmtUpdateCart->close();

    // Add 1 to product quantity in products table
    $sqlUpdateProducts = "UPDATE products SET productquantity = productquantity + 1 WHERE pid = ?";
    $stmtUpdateProducts = $conn->prepare($sqlUpdateProducts);
    $stmtUpdateProducts->bind_param("i", $pid);

    if ($stmtUpdateProducts->execute()) {
        $response = array('message' => 'Product removed from cart successfully');
        echo json_encode($response);
    } else {
        $response = array('message' => 'Product removal from cart failed');
        echo json_encode($response);
    }

    $stmtUpdateProducts->close();
} else {
    $response = array('message' => 'Product removal from cart failed');
    echo json_encode($response);
}

$conn->close();
?>
