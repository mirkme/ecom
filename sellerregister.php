<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hack";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
}

if (isset($_POST['register'])) {
    $sellername = $_POST['name'];
    $sellernumber = $_POST['mobile'];
    $selleremail = $_POST['email'];
    $sellerlocation = $_POST['location'];
    $sellergstin = $_POST['gstin'];
    $sellerusername = $_POST['username'];
    $sellerpassword = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO sellerregister(sellername, sellernumber, selleremail, sellerlocation, sellergstinno, sellerusername, sellerpassword) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssssss", $sellername, $sellernumber, $selleremail, $sellerlocation, $sellergstin, $sellerusername, $sellerpassword);

    // Execute the statement
    $success = mysqli_stmt_execute($stmt);

    // Get the last inserted ID
    $sellerid = mysqli_insert_id($conn);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Check the result and display the appropriate message
    if ($success) {
        echo "<script>alert('Data saved into database. Seller ID: $sellerid'); window.location.href='index.html';</script>";
        exit();
    } else {
        echo "<script>alert('Data failed to save into database');</script>";
    }
}

// Close the connection
mysqli_close($conn);
?>
