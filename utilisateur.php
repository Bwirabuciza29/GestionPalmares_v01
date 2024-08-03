<?php
// Lien vers la NavBar
require_once('blade/DashPart.php');
// Lien vers l'ASIDE
require_once('blade/AsidePart.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="welcome-message" id="welcomeMessage">
            <h1>Bienvenue, <?= htmlspecialchars($user['designation']) ?>!</h1>
            <p>Vous êtes connecté en tant qu' <?= htmlspecialchars($user['category']) ?></p>
            <!-- <div class="col-md-8">
                <p><strong>Catégorie :</strong> <?= htmlspecialchars($user['category']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Institution :</strong> <?= htmlspecialchars($user['institution_designation']) ?></p>
                <p><strong>Email de l'institution :</strong> <?= htmlspecialchars($user['institution_email']) ?></p>
                <p><strong>Adresse de l'institution :</strong> <?= htmlspecialchars($user['institution_adresse']) ?></p>
            </div> -->
        </div>
    </section>

    <section class="section">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Palmarès</h5>
                        <?php if (isset($success_message)) : ?>
                            <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
                        <?php elseif (isset($error_message)) : ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                        <?php endif; ?>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Formulaire d'Enregistrement Palmarès
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="basicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Enregistrer Un Palmarès</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for credit registration -->
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="add">
                                            <div class="mb-3">
                                                <label for="idInst" class="form-label">Institution</label>
                                                <input type="text" class="form-control" id="idInst" name="idInst" value="<?= htmlspecialchars($user['institution_designation']) ?>" disabled>
                                                <input type="hidden" name="idInst" value="<?= htmlspecialchars($user['institution_id']) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="anneeAcademique" class="form-label">Année Académique</label>
                                                <input type="text" class="form-control" id="anneeAcademique" name="anneeAcademique" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fichierPalm" class="form-label">Fichier</label>
                                                <input type="file" class="form-control" id="fichierPalm" name="fichierPalm" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </form>

                                        <!-- End form -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- End modal -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mes Palmares</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Année Académique</th>
                                    <th>Fichier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($palmares as $palma) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($palma['anneeAcademique']) ?></td>
                                        <td><?= htmlspecialchars($palma['fichierPalm']) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?= $palma['id'] ?>">Voir</button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $palma['id'] ?>">Modifier</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $palma['id'] ?>">Supprimer</button>
                                        </td>
                                    </tr>
                                    <!-- Modal Voir -->
                                    <div class="modal fade" id="viewModal<?= $palma['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Voir Palmarès</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <embed src="fichier/<?= htmlspecialchars($palma['fichierPalm']) ?>" type="application/pdf" width="100%" height="600px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Modifier -->
                                    <div class="modal fade" id="editModal<?= $palma['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier Palmarès</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($palma['id']) ?>">
                                                        <div class="mb-3">
                                                            <label for="anneeAcademiqueEdit<?= $palma['id'] ?>" class="form-label">Année Académique</label>
                                                            <input type="text" class="form-control" id="anneeAcademiqueEdit<?= $palma['id'] ?>" name="anneeAcademique" value="<?= htmlspecialchars($palma['anneeAcademique']) ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="fichierPalmEdit<?= $palma['id'] ?>" class="form-label">Fichier</label>
                                                            <input type="file" class="form-control" id="fichierPalmEdit<?= $palma['id'] ?>" name="fichierPalm" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Supprimer -->
                                    <div class="modal fade" id="deleteModal<?= $palma['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Supprimer Palmarès</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Êtes-vous sûr de vouloir supprimer ce palmarès?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= htmlspecialchars($palma['id']) ?>">
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