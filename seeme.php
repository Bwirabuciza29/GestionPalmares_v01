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

    <section class="section dashboard">
        <div class="welcome-message" id="welcomeMessage">
            <div class="col-md-8">
                <p><strong>Catégorie :</strong> <?= htmlspecialchars($user['category']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Institution :</strong> <?= htmlspecialchars($user['institution_designation']) ?></p>
                <p><strong>Email de l'institution :</strong> <?= htmlspecialchars($user['institution_email']) ?></p>
                <p><strong>Adresse de l'institution :</strong> <?= htmlspecialchars($user['institution_adresse']) ?></p>
            </div>
        </div>
    </section>

</main>

<?php
// Lien vers le footer
require_once('blade/DashFooter.php');
?>