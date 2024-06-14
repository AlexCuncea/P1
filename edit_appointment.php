<?php
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("CALL edit_appointment(?, ?, ?)");
    $stmt->bind_param("iss", $id, $date, $description);

    if ($stmt->execute()) {
        header('Location: my_appointments.php');
        exit();
    } else {
        echo "Eroare la actualizarea programării: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT date, description FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if (!$appointment) {
        echo "Programare nu a fost găsită.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editare Programare</title>
</head>
<body>
    <h1>Editare Programare</h1>
    <form method="post" action="edit_appointment.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label for="date">Data:</label>
        <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($appointment['date']); ?>" required>
        <br>
        <label for="description">Descriere:</label>
        <input type="text" name="description" id="description" value="<?php echo htmlspecialchars($appointment['description']); ?>" required>
        <br>
        <input type="submit" name="submit" value="Actualizează">
    </form>
</body>
</html>
