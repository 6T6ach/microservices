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

    <main class="container min-vh-100">

        <div class="row">
            <h1>Connexion</h1>
        </div>

        <div class="row">
            <form action="control-connexion.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>

                <button type="submit" class="btn btn-primary">CONNEXION</button>
            </form>
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