<?php
// Lien vers la NavBar
require_once('blade/DashPart.php');
// Lien vers l'ASIDE
require_once('blade/AsidePart.php');
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gestion Compte</h1>
    </div><!-- End Page Title -->
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="img/<?= htmlspecialchars($user['institution_photo']) ?>" class=" rounded-circle">
                        <h2><?= htmlspecialchars($user['designation']) ?></h2>
                        <h3><?= htmlspecialchars($user['category']) ?></h3>
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Détail de l'Institution</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Désigntion</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['institution_designation']) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['email']) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Catégorie</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['category']) ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8"><?= htmlspecialchars($user['institution_adresse']) ?></div>
                                </div>
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>