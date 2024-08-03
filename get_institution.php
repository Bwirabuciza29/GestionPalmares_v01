<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM institution WHERE id = ?");
    $stmt->execute([$id]);
    $institution = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($institution);
}
