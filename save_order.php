<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tea_sewa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$table = $data['table'];
$orders = $data['orders'];

foreach ($orders as $item => $details) {
    $qty = $details['qty'];
    $price = $details['price'];
    $sql = "INSERT INTO orders (table_number, item, qty, price) VALUES ('$table', '$item', '$qty', '$price')";

    if (!$conn->query($sql)) {
        echo json_encode(['success' => false, 'message' => 'Failed to save order']);
        $conn->close();
        exit();
    }
}

echo json_encode(['success' => true, 'message' => 'Order saved successfully']);
$conn->close();
?>
