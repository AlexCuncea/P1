<?php
require 'db_connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Obține programările utilizatorului curent
$query = "SELECT id, date, description FROM appointments WHERE user_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die('Eroare la pregătirea interogării: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Eroare la obținerea rezultatelor: ' . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Programările mele</title>
</head>
<body>
    <h1>Programările mele</h1>
    <a href="add_appointment.php">Adaugă o programare nouă</a>
    <table>
        <tr>
            <th>Data Programării</th>
            <th>Descriere</th>
            <th>Acțiuni</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <a href="view_appointment.php?id=<?php echo $row['id']; ?>">View</a>
                    <a href="edit_appointment.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_appointment.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Ești sigur că vrei să ștergi această programare?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
