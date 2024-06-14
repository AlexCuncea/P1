<?php
require 'db_connection.php';

$email = '';
$password = '';

// Validare email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Email invalid.');
}

// Validare parola (exemplu: minim 8 caractere)
if (strlen($password) < 8) {
    die('Parola trebuie să aibă cel puțin 8 caractere.');
}

// Hash parola înainte de a o stoca în baza de date
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Utilizare prepared statements pentru a preveni SQL injection
$query = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$query->bind_param('ss', $email, $hashed_password);

if ($query->execute() === TRUE) {
    echo "Utilizator adăugat cu succes.";
} else {
    echo "Eroare: " . $conn->error;
}

$conn->close();
?>
