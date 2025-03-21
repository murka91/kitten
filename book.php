<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION["user_id"])) {
    header("Location: auth.php");
    exit();
}

$kitten_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt_check = $conn->prepare("SELECT id FROM kittens WHERE id = ? AND status = 'свободен'");
if ($stmt_check === false) {
    die('Ошибка подготовки запроса: ' . htmlspecialchars($conn->error));
}

$stmt_check->bind_param("i", $kitten_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows == 0) {
    echo "Этот котенок уже забронирован или продан.";
    exit();
}

$stmt_book = $conn->prepare("INSERT INTO bookings (user_id, kitten_id) VALUES (?, ?)");
if ($stmt_book === false) {
    die('Ошибка подготовки запроса: ' . htmlspecialchars($conn->error));
}

$stmt_book->bind_param("ii", $user_id, $kitten_id);

if ($stmt_book->execute()) {

    $stmt_update = $conn->prepare("UPDATE kittens SET status = 'забронирован' WHERE id = ?");
    if ($stmt_update === false) {
        die('Ошибка подготовки запроса: ' . htmlspecialchars($conn->error));
    }

    $stmt_update->bind_param("i", $kitten_id);
    if ($stmt_update->execute()) {
        echo "Котенок успешно забронирован!";
        header("Location: profile.php");
        exit();
    } else {
        echo "Ошибка при обновлении статуса котенка: " . htmlspecialchars($stmt_update->error);
    }
} else {
    echo "Ошибка при бронировании: " . htmlspecialchars($stmt_book->error);
}

$stmt_check->close();
$stmt_book->close();
$stmt_update->close();
$conn->close();
?>
