<?php
$servername = 'db'; // Acesta este aliasul de serviciu definit în docker-compose.yml
$username = 'root';
$password = 'rootpassword'; // Parola definită în docker-compose.yml
$database = 'login_system';

// Crează conexiunea
$conn = new mysqli($servername, $username, $password, $database);

// Verifică conexiunea
if ($conn->connect_error) {
    die('Conexiunea la baza de date a eșuat: ' . $conn->connect_error);
}
?>
