<?php
require_once('config.php');

// Lien vers la NavBar
require_once('blade/DashHeader.php');
// Lien vers l'ASIDE
require_once('blade/AsideUser.php');
// Récupérer les données des tables institution et palmares
$query = "SELECT i.designation, i.photo, i.adresse, p.id, p.anneeAcademique, p.fichierPalm, p.date_add 
          FROM institution i 
          JOIN palmares p ON i.id = p.idInst";
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Les Palmarès</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Accueil</a></li>
                <li class="breadcrumb-item active">Les Palmares</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
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
                                    <th>Désignation</th>
                                    <th>Photo</th>
                                    <th>Adresse</th>
                                    <th>Année Académique</th>
                                    <th>Fichier Palm</th>
                                    <th>Date d'Ajout</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $row) :
                                    $modalId = htmlspecialchars($row['designation'] . '-' . $row['anneeAcademique']);
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['designation']) ?></td>
                                        <td><img src="img/<?= htmlspecialchars($row['photo']) ?>" alt="Photo" width="50" height="50"></td>
                                        <td><?= htmlspecialchars($row['adresse']) ?></td>
                                        <td><?= htmlspecialchars($row['anneeAcademique']) ?></td>
                                        <td><?= htmlspecialchars($row['fichierPalm']) ?></td>
                                        <td><?= htmlspecialchars($row['date_add']) ?></td>
                                        <td><button class="btn btn-primary" data-toggle="modal" data-target="#modal<?= $modalId ?>">Voir</button></td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal<?= $modalId ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?= $modalId ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel<?= $modalId ?>">Fichier Palm</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src="fichier/<?= htmlspecialchars($row['fichierPalm']) ?>" width="100%" height="500px"></iframe>
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>