<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['sellerid'])) {
    $response = array('activeSession' => false);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hack";

// Establishing connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add Product
if (isset($_POST['submit'])) {
    $productname = $_POST['productname'];
    $productquantity = $_POST['productquantity'];
    $productprice = $_POST['productprice'];
    $negotiableamount = $_POST['negotiableamount'];
    $productcategory = $_POST['productcategory'];
    $productsize = $_POST['productsize'];
    $productcolour = $_POST['productcolour'];
    $productlink = $_POST['productlink'];
    $sellerid = $_POST['sellerid'];

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO products (productname, productquantity, productprice, negotiableamount, productcategory, productsize, productcolour, productlink, sellerid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "siiissssi", $productname, $productquantity, $productprice, $negotiableamount, $productcategory, $productsize, $productcolour, $productlink, $sellerid);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Check the result and display the appropriate message
    if ($success) {
        echo "<script>alert('Product added successfully');window.location.href='showallproducts.html';</script>";
    } else {
        echo "<script>alert('Failed to add product');window.location.href='sellerhomepage.html';</script>";
    }
}

// Close connection
mysqli_close($conn);
?>
