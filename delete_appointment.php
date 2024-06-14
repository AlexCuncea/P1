<?php
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("CALL delete_appointment(?)");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: my_appointments.php');
    exit();
} else {
    echo "Eroare la ștergerea programării: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
