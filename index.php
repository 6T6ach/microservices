<?php
session_start();
?>
<!DOCTYPE html>

<!-- Opérateur ternaire -->
<html lang="<?= !empty($_SESSION['lang']) ? $_SESSION['lang'] : 'en' ?>">

<?php
include('./inc/head.php');
?>

<body>

    <?php
    include('./inc/header.php');

    ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded me-2" alt="...">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
       
    </div>
    <main class="container min-vh-100">

        <div class="row">
            <h1>Des milliers de microservices pour tous vos besoins, à partir de 5 €</h1>
        </div>

        <!-- Lister le contenu de la table "microservices" -->



        <div class="row">

            <?php

            try {
                $bdd = new PDO('mysql:host=localhost;dbname=mysql-training;charset=utf8', 'root', '');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

            $reponse = $bdd->query("SELECT * FROM microservices LIMIT 6");

            while ($donnees = $reponse->fetch()) :
            ?>
                <div class="col-md-4 p-2">
                    <div class="border border-dark p-2 h-100">
                        <h3><?= $donnees['titre'] ?></h3>
                        <p><img src="https://source.unsplash.com/services/1600x900" alt="" width="150"></p>
                        <p><small><?= $donnees['auteur'] ?></small></p>
                        <p><?= $donnees['contenu'] ?></p>
                        <p>
                            <a class="btn btn-light" href="#">À partir de <?= $donnees['prix'] ?> €</a>
                        </p>
                    </div>
                </div>
            <?php
            endwhile;

            $reponse->closeCursor();

            ?>



        </div>

    </main>

    <?php
    include('./inc/footer.php');
    ?>

    <script>
        // TOASTS
        console.log("Script is loading");
        window.onload = (e) => {
            console.log("windows is loading");
            let myToast = document.querySelector(".toast"); // Selectionne l'id de myToast
            let toasted = new bootstrap.Toast(myToast); // Initialise
            toasted.show(); // show myToast
        };
    </script>
</body>

</html>