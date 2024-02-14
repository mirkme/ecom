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

// Fetch products based on seller ID if provided
if (isset($_SESSION["sellerid"])) {
    $sellerId = $_SESSION["sellerid"];
    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM products WHERE sellerid = ?";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameter
    mysqli_stmt_bind_param($stmt, "s", $sellerId);

    // Execute the statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Display products in the table
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['productname'] . "</td>";
            echo "<td>" . $row['productquantity'] . "</td>";
            echo "<td>" . $row['productprice'] . "</td>";
            echo "<td>" . $row['negotiableamount'] . "</td>";
            echo "<td>" . $row['productcategory'] . "</td>";
            echo "<td>" . $row['productsize'] . "</td>";
            echo "<td>" . $row['productcolour'] . "</td>";
            echo "<td>" . $row['productlink'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No products found for seller ID: $sellerId</td></tr>";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($conn);
?>
