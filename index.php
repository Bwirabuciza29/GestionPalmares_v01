<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête pour récupérer l'utilisateur
    $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            // Création des variables de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['category'] = $user['category'];

            // Redirection en fonction de la catégorie
            if ($user['category'] == 'utilisateur') {
                header('Location: utilisateur.php');
                exit();
            } elseif ($user['category'] == 'admin') {
                header('Location: home.php');
                exit();
            }
        } else {
            $error_message = "Email ou mot de passe incorrect.";
        }
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>
<?php require_once('blade/LoggerUp.php'); ?>
<main>
    <div class="container mt-4">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Authentification</h5>
                                    <p class="text-center small">Entrez votre email et votre mot de passe pour vous connecter</p>
                                </div>
                                <?php if (isset($error_message)) : ?>
                                    <div class="alert alert-danger">
                                        <?= htmlspecialchars($error_message) ?>
                                    </div>
                                <?php endif; ?>
                                <form method="POST" class="row g-3 needs-validation">
                                    <div class="col-12">
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">Email</span>
                                            <input type="email" name="email" class="form-control" id="yourEmail" required>
                                            <div class="invalid-feedback">S'il vous plaît entrez votre email d'utilisateur.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Mot de passe</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">S'il vous plaît entrez votre mot de passe!</div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Se Connecter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<?php require_once('blade/LoggerDown.php'); ?>