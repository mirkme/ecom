<?php

$servername ="localhost";
$username   ="root";
$password   ="";
$dbname     ="hack";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
    echo "connection ok";
}
else
{
    echo "connection failed".mysqli_connect_error();
}

if (isset($_POST['register'])) {
    $customername = $_POST['name'];
    $customeremail = $_POST['email'];
    $customernumber = $_POST['mobile'];
    $customerusername = $_POST['username'];
    $customerlocation = $_POST['location'];
    $customerpassword = $_POST['password'];


    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO customerregister (customername, customeremail, customerusername, customernumber, customerlocation, customerpassword) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssss", $customername, $customeremail, $customerusername, $customernumber, $customerlocation, $customerpassword);
    // Execute the statement

    $success = mysqli_stmt_execute($stmt);
    // Close the statement
    mysqli_stmt_close($stmt);

    // Check the result and display the appropriate message
    if ($success) {
        echo "<script> alert('Data saved into database');window.location.href='customerlogin.html';</script>";
    } else {
        echo "<script> alert('Data failed to save into database');window.location.href='customerregister.html';</script>";
    }
}
?>