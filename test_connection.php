<?php
require 'db_connection.php';

if ($conn) {
    echo "Conexiunea la baza de date a fost realizată cu succes!";
} else {
    echo "Conexiunea la baza de date a eșuat.";
}
?>
