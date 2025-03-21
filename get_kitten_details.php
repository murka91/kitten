<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM kittens WHERE id = $id");

    if ($result->num_rows > 0) {
        $kitten = $result->fetch_assoc();
        echo json_encode($kitten);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

$conn->close();
?>
