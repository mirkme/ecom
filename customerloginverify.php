<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerusername = $_POST['username'];
    $customerpassword = $_POST['password'];

    // Replace these values with your actual database credentials
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'hack';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
    }

    $sql = "SELECT customerid, customername, customerpassword FROM customerregister WHERE customerusername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $customerusername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['customerpassword'];

        $c = password_hash($customerpassword,PASSWORD_DEFAULT);
        if ($customerpassword == $hashedPassword) {
            // Login successful, store necessary information in session
            $_SESSION['customerid'] = $row['customerid'];
            $_SESSION['customername'] = $row['customername'];

            // Ensure no output before the header redirection
            ob_clean(); // Clean any output buffers
            header("Location: customerhomepage.html");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid username or password');window.location.href='customerlogin.html';</script>";
        }
    } else {
        // Username not found in the database
        echo "<script>alert('Invalid username or password');window.location.href='customerlogin.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
