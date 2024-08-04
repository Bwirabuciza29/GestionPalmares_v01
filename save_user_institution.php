<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $category = $_POST['category'];
    $password = $_POST['password'];
    $created_by = $_POST['created_by'];

    // Traitement du téléchargement de la photo
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = basename($_FILES['photo']['name']);
        $uploadDir = 'img/';
        $uploadFile = $uploadDir . $photo;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $error_message = "Erreur lors du téléchargement de la photo.";
            header("Location: home.php?error=" . urlencode($error_message));
            exit();
        }
    }

    // Insérer dans la table institution
    $stmtInst = $conn->prepare("INSERT INTO institution (designation, email, adresse, photo, created_by) VALUES (:designation, :email, :adresse, :photo, :created_by)");
    $stmtInst->bindParam(':designation', $designation);
    $stmtInst->bindParam(':email', $email);
    $stmtInst->bindParam(':adresse', $adresse);
    $stmtInst->bindParam(':photo', $photo);
    $stmtInst->bindParam(':created_by', $created_by);

    if ($stmtInst->execute()) {
        // Récupérer l'ID de l'institution nouvellement créé
        $institution_id = $conn->lastInsertId();

        // Insérer dans la table users
        $stmtUser = $conn->prepare("INSERT INTO users (designation, email, category, password, institution_id) VALUES (:designation, :email, :category, :password, :institution_id)");
        $stmtUser->bindParam(':designation', $designation);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':category', $category);
        $stmtUser->bindParam(':password', $password);
        $stmtUser->bindParam(':institution_id', $institution_id);

        if ($stmtUser->execute()) {
            $success_message = "L'enregistrement a réussi.";
            header("Location: home.php?success=" . urlencode($success_message));
            exit();
        } else {
            $error_message = "Erreur lors de l'enregistrement de l'utilisateur.";
            header("Location: home.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = "Erreur lors de l'enregistrement de l'institution.";
        header("Location: home.php?error=" . urlencode($error_message));
        exit();
    }
}
