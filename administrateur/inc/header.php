<header>
    <div class="container">
        <div class="row justify-content-between">
            <p class="col-md-4">
                <a class="text-decoration-none text-dark fs-1 fw-bolder" href="index.php">
                    5euros.com
                </a>
            </p>
            <?php
            if (isset($_SESSION['status']) && $_SESSION['status'] === 1) :
            ?>
                <!-- CONNECTÉ -->
                <div class="col-md-4 d-flex flex-wrap align-items-center gap-2 ">
                    <a class="link-dark" href="#">ACHAT</a>
                    <a class="link-dark" href="#">VENTE</a>
                    <a class="link-dark" href="#">NOTIF</a>

                    <!-- DEBUT  -->
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= !empty($_SESSION['pseudo']) ? $_SESSION['pseudo'] : 'Anonyme' ?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item disabled" href="#">Paramètres</a></li>
                            <li><a class="dropdown-item disabled" href="#">Centre d'aide</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./admin">ADMIN</a></li>
                            <li><a class="dropdown-item" href="deconnexion.php">DECONNEXION</a></li>
                        </ul>
                    </div>
                    <!-- FIN -->

                </div>
            <?php
            else :
            ?>
                <!-- DECONNECTÉ -->
                <div class="col-md-6 d-flex justify-content-end align-items-center flex-wrap gap-2 ">
                    <a class="link-dark" href="connexion.php">CONNEXION</a>
                    <a class="link-dark" href="#">INSCRIPTION</a>
                    <a class="btn btn-success" href="#">DEVENEZ VENDEUR</a>

                </div>
            <?php
            endif;
            ?>

        </div>


    </div>

    <nav class="container-fluid bg-dark mb-5" style="min-height: 50px;">

    </nav>

</header>