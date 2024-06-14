<?php
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("CALL add_appointment(?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $date, $description);

    if ($stmt->execute()) {
        header('Location: my_appointments.php');
        exit();
    } else {
        echo "Eroare la adăugarea programării: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adăugare Programare</title>
</head>
<body>
    <h1>Adăugare Programare</h1>
    <form method="post" action="add_appointment.php">
        <label for="date">Data:</label>
        <input type="date" name="date" id="date" required>
        <br>
        <label for="description">Descriere:</label>
        <input type="text" name="description" id="description" required>
        <br>
        <input type="submit" name="submit" value="Adaugă">
    </form>
</body>
</html>
