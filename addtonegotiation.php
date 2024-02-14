<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Get book details from the request
$data = json_decode(file_get_contents("php://input"));

// Debugging: Output the received JSON data
error_log("Received JSON data: " . json_encode($data));

// Check if required fields are set in the JSON data
if (!$data || !isset($data->pid, $data->productname, $data->productquantity, $data->productprice, $data->productcategory, $data->productcolour, $data->productlink)) {
    $response = array('success' => false, 'message' => 'Invalid data');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$pid = $data->pid;
$productname = $data->productname;
$productquantity = $data->productquantity;
$productprice = $data->productprice;
$productcategory = $data->productcategory;
$productcolour = $data->productcolour;
$productlink = $data->productlink;

// Prepare and execute SQL query to insert into the cart table
$stmt = $conn->prepare("INSERT INTO negotiate(pid, productname, productquantity, productprice, productcategory, productcolour, productlink, customerid, added_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isdssssi", $pid, $productname, $productquantity, $productprice, $productcategory, $productcolour, $productlink, $customerid);


// Check if the SQL execution was successful
if ($stmt->execute()) {
    $response = array('success' => true);
} else {
    $response = array('success' => false, 'message' => $stmt->error);
}

// Debugging: Output the response
error_log("Response: " . json_encode($response));

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
