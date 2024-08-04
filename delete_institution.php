<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    try {
        // Commencer une transaction
        $conn->beginTransaction();

        // Supprimer les utilisateurs associés à l'institution
        $stmtUsers = $conn->prepare("DELETE FROM users WHERE institution_id = ?");
        $stmtUsers->execute([$id]);

        // Supprimer l'institution
        $stmtInst = $conn->prepare("DELETE FROM institution WHERE id = ?");
        $stmtInst->execute([$id]);

        // Valider la transaction
        $conn->commit();

        header("Location: user.php");
        exit();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $conn->rollBack();
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
}
