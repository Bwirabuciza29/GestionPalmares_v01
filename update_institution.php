<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    // Gestion de l'upload de la photo
    if ($_FILES['photo']['name']) {
        $photo = $_FILES['photo']['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        // Si aucune nouvelle photo n'est téléchargée, garder l'ancienne
        $stmt = $conn->prepare("SELECT photo FROM institution WHERE id = ?");
        $stmt->execute([$id]);
        $photo = $stmt->fetchColumn();
    }

    // Mettre à jour l'institution
    $stmt = $conn->prepare("UPDATE institution SET designation = ?, email = ?, adresse = ?, photo = ? WHERE id = ?");
    $stmt->execute([$designation, $email, $adresse, $photo, $id]);

    header("Location: user.php");
    exit();
}
