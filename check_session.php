<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['customerid'])) {
    $response = array('activeSession' => true, 'userid' => $_SESSION['customerid'], 'username' => $_SESSION['customername'], 'usertype' => 'customer');
} elseif (isset($_SESSION['sellerid'])) {
    $response = array('activeSession' => true, 'userid' => $_SESSION['sellerid'], 'username' => $_SESSION['sellername'], 'usertype' => 'seller');
} else {
    $response = array('activeSession' => false);
}

header('Content-Type: application/json');
echo json_encode($response);
?>

