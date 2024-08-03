<?php
require_once('config.php');

// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');

// Récupérer toutes les institutions de la base de données
$stmt = $conn->prepare("SELECT * FROM institution");
$stmt->execute();
$institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gestion Comptes Utilisateurs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <?php
            // Afficher le message d'alerte s'il existe
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-' . $_SESSION['alert_type'] . ' alert-dismissible fade show" role="alert">';
                echo $_SESSION['message'];
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                echo '</div>';

                // Supprimer le message de la session après l'affichage
                unset($_SESSION['message']);
                unset($_SESSION['alert_type']);
            }
            ?>
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- naissance Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Institutions <span>| Toutes</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-badge"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= htmlspecialchars($totalInstitutions) ?></h6>
                                        <span class="text-success small pt-1 fw-bold">Institutions</span> <span class="text-muted small pt-2 ps-1">Enregistrées</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End naissance Card -->

                    <!-- personne Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Palmares <span>|Tout</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= htmlspecialchars($totalPalmares) ?></h6>
                                        <span class="text-success small pt-1 fw-bold">palmares ajoutés</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End personnes Card -->
                    <div class="col-xxl-4 col-xl-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Nouveau <span>| Créer</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="ps-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Nouvel Enregistrement Compte Utilisateur
                                        </button>
                                        <div class="modal fade" id="basicModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Créer un Compte</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="save_user_institution.php" method="post" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="designation" class="form-label">Designation</label>
                                                                <input type="text" class="form-control" id="designation" name="designation" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" id="email" name="email" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="adresse" class="form-label">Adresse</label>
                                                                <input type="text" class="form-control" id="adresse" name="adresse" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="photo" class="form-label">Photo</label>
                                                                <input type="file" class="form-control" id="photo" name="photo" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="category" class="form-label">Catégorie</label>
                                                                <select class="form-select" id="category" name="category" required>
                                                                    <option value="utilisateur">Utilisateur</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Mot de passe</label>
                                                                <input type="password" class="form-control" id="password" name="password" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Basic Modal-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>
    <!-- TABLEAU -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <h5 class="card-title">Liste des Institutions</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($institutions as $institution) : ?>
                                    <tr>
                                        <td><?= $institution['id'] ?></td>
                                        <td><?= $institution['designation'] ?></td>
                                        <td><?= $institution['email'] ?></td>
                                        <td><?= $institution['adresse'] ?></td>
                                        <td><img src="img/<?= $institution['photo'] ?>" alt="<?= $institution['designation'] ?>" width="50"></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal<?= $institution['id'] ?>">Afficher</button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $institution['id'] ?>">Modifier</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $institution['id'] ?>">Supprimer</button>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal<?= $institution['id'] ?>" tabindex="-1" aria-labelledby="viewModalLabel<?= $institution['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel<?= $institution['id'] ?>">Afficher Institution</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="viewDesignation<?= $institution['id'] ?>" class="form-label">Designation</label>
                                                        <input type="text" class="form-control" id="viewDesignation<?= $institution['id'] ?>" value="<?= $institution['designation'] ?>" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="viewEmail<?= $institution['id'] ?>" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="viewEmail<?= $institution['id'] ?>" value="<?= $institution['email'] ?>" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="viewAdresse<?= $institution['id'] ?>" class="form-label">Adresse</label>
                                                        <input type="text" class="form-control" id="viewAdresse<?= $institution['id'] ?>" value="<?= $institution['adresse'] ?>" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="viewPhoto<?= $institution['id'] ?>" class="form-label">Photo</label>
                                                        <img src="img/<?= $institution['photo'] ?>" id="viewPhoto<?= $institution['id'] ?>" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal<?= $institution['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $institution['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel<?= $institution['id'] ?>">Modifier Institution</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="update_institution.php" enctype="multipart/form-data">
                                                        <input type="hidden" name="id" value="<?= $institution['id'] ?>">
                                                        <div class="mb-3">
                                                            <label for="editDesignation<?= $institution['id'] ?>" class="form-label">Designation</label>
                                                            <input type="text" class="form-control" id="editDesignation<?= $institution['id'] ?>" name="designation" value="<?= $institution['designation'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editEmail<?= $institution['id'] ?>" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="editEmail<?= $institution['id'] ?>" name="email" value="<?= $institution['email'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editAdresse<?= $institution['id'] ?>" class="form-label">Adresse</label>
                                                            <input type="text" class="form-control" id="editAdresse<?= $institution['id'] ?>" name="adresse" value="<?= $institution['adresse'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editPhoto<?= $institution['id'] ?>" class="form-label">Photo</label>
                                                            <input type="file" class="form-control" id="editPhoto<?= $institution['id'] ?>" name="photo">
                                                            <img src="img/<?= $institution['photo'] ?>" id="editCurrentPhoto<?= $institution['id'] ?>" class="img-fluid mt-2">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Modifier</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal<?= $institution['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $institution['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel<?= $institution['id'] ?>">Supprimer Institution</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Êtes-vous sûr de vouloir supprimer cette institution ?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="delete_institution.php">
                                                        <input type="hidden" name="id" value="<?= $institution['id'] ?>">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var welcomeMessage = document.getElementById('welcomeMessage');
        welcomeMessage.style.display = 'block';
        setTimeout(function() {
            welcomeMessage.style.opacity = 0;
            setTimeout(function() {
                welcomeMessage.style.display = 'none';
            }, 1000);
        }, 10000);
    });
</script>
<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>