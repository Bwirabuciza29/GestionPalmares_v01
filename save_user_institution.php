<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $category = $_POST['category'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Gestion de l'upload de la photo
    $photo = $_FILES['photo']['name'];
    $target_dir = "img/"; // Le dossier où la photo sera enregistrée
    $target_file = $target_dir . basename($photo);

    // Vérifier si le dossier existe, sinon le créer
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Déplacer le fichier téléchargé vers le dossier cible
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        try {
            // Commencer la transaction
            $conn->beginTransaction();

            // Insérer dans la table institution
            $stmt1 = $conn->prepare("INSERT INTO institution (designation, email, adresse, photo, created_by) VALUES (?, ?, ?, ?, ?)");
            $stmt1->execute([$designation, $email, $adresse, $photo, $category]);

            // Insérer dans la table users
            $stmt2 = $conn->prepare("INSERT INTO users (designation, email, category, password) VALUES (?, ?, ?, ?)");
            $stmt2->execute([$designation, $email, $category, $password]);

            // Valider la transaction
            $conn->commit();

            // Stocker le message d'alerte dans une session
            $_SESSION['message'] = 'Enregistrement réussi !';
            $_SESSION['alert_type'] = 'primary';

            // Rediriger vers la page home.php après un enregistrement réussi
            header("Location: user.php");
            exit();
        } catch (PDOException $e) {
            // Annuler la transaction
            $conn->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Erreur lors du téléchargement de la photo.";
    }
}
