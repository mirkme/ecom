<?php
$conn = new mysqli("localhost", "root", "", "hack");
if ($conn->connect_error){
    die("Can't connect to the server at the moment.\n Reason : " . $conn->connect_error);
}

$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM products ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $books = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($books);
    } else {
        echo json_encode(['valid' => false]);
    }
} else {
    $key = $input['search'];
    $sql = "SELECT * FROM products WHERE sellerid LIKE ?";
    $stmt = $conn->prepare($sql);
    $keyParam = "%$key%";
    $stmt->bind_param("s",$keyParam);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $books = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($books);
    } else {
        echo json_encode(['valid' => false]);
    }
    $stmt->close();
}

$conn->close();
?>