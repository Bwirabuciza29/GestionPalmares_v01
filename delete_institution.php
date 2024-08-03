<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Supprimer l'institution
    $stmt = $conn->prepare("DELETE FROM institution WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: user.php");
    exit();
}
