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

// Get user ID and username from session
$customerid = $_SESSION['customerid'];

// Get product details from the request
$data = json_decode(file_get_contents("php://input"));

// Debugging: Output the received JSON data
error_log("Received JSON data: " . json_encode($data));

// Check if required fields are set in the JSON data
if (!$data || !isset($data->pid, $data->productname, $data->productprice, $data->productcategory, $data->productcolour, $data->productlink)) {
    $response = array('success' => false, 'message' => 'Invalid data');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$pid = $data->pid;
$productname = $data->productname;
$productprice = $data->productprice;
$productcategory = $data->productcategory;
$productcolour = $data->productcolour;
$productlink = $data->productlink;

// Check if the product already exists in the cart
$checkStmt = $conn->prepare("SELECT productquantity FROM cart WHERE pid = ? AND customerid = ?");
$checkStmt->bind_param("ii", $pid, $customerid);
$checkStmt->execute();
$checkStmt->store_result();

// Check if the product exists in the cart and if its quantity is greater than 0
if ($checkStmt->num_rows > 0) {
    $checkStmt->bind_result($existingQuantity);
    $checkStmt->fetch();

    // Product already exists in the cart and has sufficient quantity
    if ($existingQuantity > 0) {
        $response = array('success' => false, 'message' => 'Product already exists in your cart and has sufficient quantity.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Product in cart but out of stock, consider informing user and returning appropriate message
        $response = array('success' => false, 'message' => 'This product is currently out of stock.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
} else {
    // Product does not exist in the cart, proceed with adding it
    $conn->begin_transaction(); // Start transaction for atomic operation

    // Check product availability in `products` table
    $productAvailabilityStmt = $conn->prepare("SELECT productquantity FROM products WHERE pid = ?");
    $productAvailabilityStmt->bind_param("i", $pid);
    $productAvailabilityStmt->execute();
    $productAvailabilityStmt->store_result();

    if ($productAvailabilityStmt->num_rows == 0) {
        // Product not found in `products` table
        $conn->rollback(); // Rollback transaction
        $response = array('success' => false, 'message' => 'Product not found.');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $productAvailabilityStmt->bind_result($productQuantity);

    if ($productAvailabilityStmt->fetch() && $productQuantity > 0) {
        // Sufficient quantity available, deduct from `products`
        $updateProductQuantityStmt = $conn->prepare("UPDATE products SET productquantity = productquantity - 1 WHERE pid = ?");
        $updateProductQuantityStmt->bind_param("i", $pid);

        if ($updateProductQuantityStmt->execute()) {
            // Product quantity updated successfully, commit the transaction
            $conn->commit();

            // Insert the product into the cart
            $insertIntoCartStmt = $conn->prepare("INSERT INTO cart (pid, productname, productquantity, productprice, productcategory, productcolour, productlink, customerid, added_at) VALUES (?, ?, 1, ?, ?, ?, ?, ?, NOW())");
            $insertIntoCartStmt->bind_param("isdsssi", $pid, $productname, $productprice, $productcategory, $productcolour, $productlink, $customerid);

            if ($insertIntoCartStmt->execute()) {
                // Product added to cart successfully
                $response = array('success' => true, 'message' => 'Product added to cart successfully.');
            } else {
                // Failed to insert into `cart` table, rollback
                $conn->rollback();
                $response = array('success' => false, 'message' => 'Failed to add product to cart (database error).');
            }

            $insertIntoCartStmt->close();
        } else {
            // Failed to update `products` table quantity, rollback
            $conn->rollback();
            $response = array('success' => false, 'message' => 'Failed to add product to cart (database error).');
        }

        $updateProductQuantityStmt->close();
    } else {
        // Product out of stock
        $conn->rollback();
        $response = array('success' => false, 'message' => 'Product is out of stock.');
    }

    $productAvailabilityStmt->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$checkStmt->close();
$conn->close();
?>
