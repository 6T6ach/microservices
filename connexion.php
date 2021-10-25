<?php
session_start();
require('./administrateur/database.php');
$cont = Database::connect();
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
        <?php
        if (isset($_POST['connect'])) {
            var_dump($_POST);
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $emailExist = $cont->query('SELECT * from users');
            $emailExist = $emailExist->fetch();
            // $emailExist->execute(array($email));
            // $result = $emailExist->rowCount();
            var_dump($emailExist);
            // if($result == 1){
            //    $user = $emailExist->fetch();
            //    if($pass == $user['password']){
            //        echo 'ok';
            //    }

            // }
            // $email =stripslashes($_REQUEST['email']);
            // $email = mysqli_real_escape_string($conn, $email);
            // $_SESSION['email'] = $email;
            // $password = stripslashes($_REQUEST['password']);
            // $password = mysqli_real_escape_string($conn, $password);
            // // interoger la bdd avec register.php

            // // $query = "SELECT * FROM `users` WHERE email = '$email' AND password = '".hash('sha256', $password) . "'";
            // // $result = mysqli_query($conn, $query) or die (sql_error());

            // if (mysqli_num_rows($result) == 1) {
            //     $email = mysqli_fetch_assoc($result);
            //     // vérifier si l'utilisateur est un administrateur ou un utilisateur
            //     if ($user['type'] == 'admin') {
            //         header('location: ./administrateur/index.php');
            //     } else {
            //         header('location: index.php');
            //     }
            // } else {
            //     $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            // }
        }


        ?>

        <div class="row">
            <h1>Connexion</h1>
        </div>

        <div class="row">
            <form method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>

                <button type="submit" class="btn btn-primary" name="connect">CONNEXION</button>
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