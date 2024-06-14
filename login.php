<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Escapă caracterele speciale pentru a preveni SQL injection
        $email = $conn->real_escape_string($email);

        // Pregătește interogarea pentru verificarea existenței utilizatorului în baza de date
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Obține rezultatul interogării
        $result = $stmt->get_result();

        // Verifică dacă s-a găsit un rezultat
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verifică parola
            if (password_verify($password, $hashed_password)) {
                // Setează user_id în sesiune
                $_SESSION['user_id'] = $row['id'];
                header('Location: my_appointments.php');
                exit();
            } else {
                $error = 'Parolă incorectă. Verificare eșuată.';
            }
        } else {
            $error = 'Email incorect.';
        }

        // Închide declarația și conexiunea
        $stmt->close();
        $conn->close();
    } else {
        $error = 'Te rugăm să completezi toate câmpurile.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="post" action="login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
