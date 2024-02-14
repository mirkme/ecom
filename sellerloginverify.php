<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sellerusername = $_POST['username'];
    $sellerpassword = $_POST['password'];

    // Replace these values with your actual database credentials
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'hack';

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
    }

    $sql = "SELECT sellerid, sellername, sellerpassword FROM sellerregister WHERE sellerusername = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sellerusername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['sellerpassword'];

        // Debugging statements
        echo "Entered Password: " . $sellerpassword . "<br>";
        echo "Hashed Password from Database: " . $hashedPassword . "<br>";
        $c = password_hash($sellerpassword,PASSWORD_DEFAULT);
        echo "calculated password: ", $c;
        if ($sellerpassword == $hashedPassword) {
            // Login successful, store necessary information in session
            $_SESSION['sellerid'] = $row['sellerid'];
            $_SESSION['sellername'] = $row['sellername'];

            // Ensure no output before the header redirection
            ob_clean(); // Clean any output buffers
            header("Location: sellermainmenu.html");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid username or password')window.location.href='sellerlogin.html';;</script>";
        }
    } else {
        // Username not found in the database
        echo "<script>alert('Invalid username or password');window.location.href='sellerlogin.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
