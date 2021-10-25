<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<?php
include('./inc/head.php');
?>

<body>

    <?php
    include('./inc/header.php');
    ?>

    <main class="min-vh-100">
        <div class="container mt-5 pt-5 w-75">
            <div class="row">
                <div class="col-sm-1 col-md-offset-3 col-md-6 mt-5 bg-dark text-light text-center rounded rounded-3">
                    <h1>Connexion</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-1 col-md-offset-3 col-md-6 border border-dark rounded rounded-3">
                    <form action="control-connexion.php" method="POST">
                        <div class="mb-3 mt-2">
                            <label for="exampleInputEmail1" class="form-label">Email :</label>
                            <input type="email" class="form-control w-100" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password : </label>
                            <input type="password" class="form-control w-100" id="exampleInputPassword1" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary mb-4">CONNEXION</button>
                    </form>
                </div>
            </div>
        </div>


        <!-- Message pour l'utilisateur -->
        <?php
        if (isset($_SESSION['message'])) :
        ?>
            <div class="row justify-content-end">
                <div class="message my-2 alert alert-danger">
                    <?= $_SESSION['message'] ?>
                </div>
            </div>
        <?php
        endif;
        ?>

    </main>

    <?php
    include('./inc/footer.php');
    ?>


</body>

</html>