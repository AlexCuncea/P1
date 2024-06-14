<?php
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$appointment_id = $_GET['id'];

// Obține detaliile programării
$query = "SELECT date, description FROM appointments WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die('Eroare la pregătirea interogării: ' . $conn->error);
}

$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Eroare la obținerea rezultatelor: ' . $stmt->error);
}

$appointment = $result->fetch_assoc();

if (!$appointment) {
    die('Programare nu a fost găsită.');
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vizualizare Programare</title>
</head>
<body>
    <h1>Vizualizare Programare</h1>
    <p><strong>Data:</strong> <?php echo htmlspecialchars($appointment['date']); ?></p>
    <p><strong>Descriere:</strong> <?php echo htmlspecialchars($appointment['description']); ?></p>
    <a href="my_appointments.php">Înapoi la Programările Mele</a>
</body>
</html>
