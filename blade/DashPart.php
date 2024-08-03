<?php
session_start();
require_once('config.php');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Récupérez les informations de l'utilisateur avec une jointure sur la table institution
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT u.*, i.id as institution_id, i.designation as institution_designation, i.email as institution_email, i.adresse as institution_adresse, i.photo as institution_photo 
    FROM users u 
    LEFT JOIN institution i ON u.institution_id = i.id 
    WHERE u.id = :user_id
");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Si l'utilisateur n'est pas trouvé, redirigez vers la page de connexion
    header('Location: index.php');
    exit();
}

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        // Traitement du formulaire d'enregistrement du palmarès
        $idInst = $_POST['idInst'];
        $anneeAcademique = $_POST['anneeAcademique'];
        $fichierPalm = $_FILES['fichierPalm']['name'];
        $created_by = $_SESSION['user_id'];

        // Upload du fichier
        $uploadDir = 'fichier/';
        $uploadFile = $uploadDir . basename($_FILES['fichierPalm']['name']);

        if (move_uploaded_file($_FILES['fichierPalm']['tmp_name'], $uploadFile)) {
            // Enregistrement du palmarès dans la base de données
            $stmtInsert = $conn->prepare("INSERT INTO palmares (idInst, anneeAcademique, fichierPalm, created_by) VALUES (:idInst, :anneeAcademique, :fichierPalm, :created_by)");
            $stmtInsert->bindParam(':idInst', $idInst);
            $stmtInsert->bindParam(':anneeAcademique', $anneeAcademique);
            $stmtInsert->bindParam(':fichierPalm', $fichierPalm);
            $stmtInsert->bindParam(':created_by', $created_by);

            if ($stmtInsert->execute()) {
                $success_message = "Palmarès enregistré avec succès.";
            } else {
                $error_message = "Erreur lors de l'enregistrement du palmarès.";
            }
        } else {
            $error_message = "Erreur lors du téléchargement du fichier.";
        }
    } elseif ($action === 'edit') {
        // Traitement du formulaire de modification du palmarès
        $id = $_POST['id'];
        $anneeAcademique = $_POST['anneeAcademique'];
        $fichierPalm = $_FILES['fichierPalm']['name'];

        // Mise à jour du fichier s'il y a un nouveau fichier téléchargé
        if (!empty($fichierPalm)) {
            $uploadDir = 'fichier/';
            $uploadFile = $uploadDir . basename($_FILES['fichierPalm']['name']);
            if (move_uploaded_file($_FILES['fichierPalm']['tmp_name'], $uploadFile)) {
                $stmtUpdate = $conn->prepare("UPDATE palmares SET anneeAcademique = :anneeAcademique, fichierPalm = :fichierPalm WHERE id = :id");
                $stmtUpdate->bindParam(':fichierPalm', $fichierPalm);
            } else {
                $error_message = "Erreur lors du téléchargement du fichier.";
            }
        } else {
            $stmtUpdate = $conn->prepare("UPDATE palmares SET anneeAcademique = :anneeAcademique WHERE id = :id");
        }

        $stmtUpdate->bindParam(':anneeAcademique', $anneeAcademique);
        $stmtUpdate->bindParam(':id', $id);

        if ($stmtUpdate->execute()) {
            $success_message = "Palmarès modifié avec succès.";
        } else {
            $error_message = "Erreur lors de la modification du palmarès.";
        }
    } elseif ($action === 'delete') {
        // Traitement du formulaire de suppression du palmarès
        $id = $_POST['id'];
        $stmtDelete = $conn->prepare("DELETE FROM palmares WHERE id = :id");
        $stmtDelete->bindParam(':id', $id);

        if ($stmtDelete->execute()) {
            $success_message = "Palmarès supprimé avec succès.";
        } else {
            $error_message = "Erreur lors de la suppression du palmarès.";
        }
    }
}

// Récupération des palmarès de l'institution connectée
$stmtPalm = $conn->prepare("SELECT * FROM palmares WHERE idInst = :idInst");
$stmtPalm->bindParam(':idInst', $user['institution_id']);
$stmtPalm->execute();
$palmares = $stmtPalm->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>GestionPalmarès</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="#" rel="icon">
    <link href="#" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        * {
            a {
                text-decoration: none;
            }
        }

        @media print {
            .no-print {
                display: none;
            }

            .invoice {
                display: block;
            }
        }

        .invoice {
            margin: 20px 0;
        }

        .invoice .container {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
        }

        .invoice table {
            width: 100%;
        }

        .invoice th,
        .invoice td {
            padding: 8px;
            text-align: left;
        }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">Gestion Palmarès</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
                        <img src="img/<?= htmlspecialchars($user['institution_photo']) ?>" alt="<?= htmlspecialchars($user['institution_designation']) ?>" class=" rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= htmlspecialchars($user['designation']) ?></span>
                    </a><!-- End Profile Iamge Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= htmlspecialchars($user['designation']) ?></h6>
                            <span><?= htmlspecialchars($user['category']) ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="utilisateur.php">
                                <i class="bi bi-person"></i>
                                <span> <?= htmlspecialchars($user['designation']) ?></span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <a href="logout.php" class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Se Deconnecter</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav>

    </header>