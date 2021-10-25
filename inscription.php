<?php
session_start();
require './administrateur/database.php';
?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    //on initialise nos messages d'erreurs; 
    $imageError = '';
    $nameError = '';
    $firstnameError = '';
    $ageError = '';
    $telError = '';
    $emailError = '';
    $paysError = '';
    $commentError = '';
    $metierError = '';
    $urlError = '';
    $passwordError = '';
    $roleError = '';
    $Error = '';


    // on recupère nos valeurs 
    // Récupération du nom l'images
    $image = htmlspecialchars($_FILES['image']['name']);
    var_dump($_FILES);
    var_dump($_FILES['image']['name']);

    $name = htmlspecialchars(trim($_POST['name']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $age = htmlspecialchars(trim($_POST['age']));
    $tel = htmlspecialchars(trim($_POST['tel']));
    $email = htmlspecialchars(trim($_POST['email']));
    $pays = htmlspecialchars(trim($_POST['pays']));
    $comment = htmlspecialchars(trim($_POST['comment']));
    $metier = htmlspecialchars(trim($_POST['metier']));
    $url = htmlspecialchars(trim($_POST['url']));
    $password = htmlspecialchars(trim($_POST['password']));
    // $role = htmlspecialchars(trim($_POST['role']));
    var_dump($_REQUEST);

    // *************************************************************************

    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
    if (isset($_FILES['image']) and $_FILES['image']['error'] == 0) {

        echo "====> Fichier reçu 👍<br>";

        // Testons si le fichier n'est pas trop gros
        if ($_FILES['image']['size'] <= 5000000) {
            echo "====> Taille Fichier < 1Mo 👍<br>";

            // Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['image']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');

            if (in_array($extension_upload, $extensions_autorisees)) {
                echo "====> Extension Autorisée 👍<br>";

                // On peut valider le fichier et le stocker définitivement

                move_uploaded_file($_FILES['image']['tmp_name'], './administrateur/uploads/images' . basename($_FILES['image']['name']));
                //  FIXME Attention la même image peut pas être téléversée 2 fois 
                echo "====> Téléversement terminé 👍<br>";
            } else {
                echo "⚠ Erreur: Ce format de fichier n'est pas autorisé";
            }
        } else {
            echo "⚠ Erreur: le fichier dépasse 1 Mo";
        }
    }

    // *************************************************************************

    // on vérifie nos champs et nous donne l'erreur
    $valid = true;
    if (empty($image)) {
        $imageError = 'Please insert un image';
        $valid = false;
    }
    // else if (!preg_match(" ", $image)) {
    //     $imageError = "Only jpg images";
    // }

    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameError = "Only letters and white space allowed";
    }

    if (empty($firstname)) {
        $firstnameError = 'Please enter firstname';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
        $firstnameError = "Only letters and white space allowed";
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    if (empty($age)) {
        $ageError = 'Please enter your age';
        $valid = false;
    }

    if (empty($tel)) {
        $telError = 'Please enter phone';
        $valid = false;
    } else if (!preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $tel)) {
        $telError = 'Please enter a valid phone';
        $valid = false;
    }

    if (!isset($pays)) {
        $paysError = 'Please select a country';
        $valid = false;
    }

    if (empty($comment)) {
        $commentError = 'Please enter a description';
        $valid = false;
    }

    if (empty($metier)) {
        $metierError = 'Please select a job';
        $valid = false;
    }

    if (empty($url)) {
        $urlError = 'Please enter website url';
        $valid = false;
    } else if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
        $urlError = 'Enter a valid url';
        $valid = false;
    }

    if (empty($role)) {
        $roleError = 'undefined role';
        $valid = false;
    }

    // si les données sont présentes et bonnes, on se connecte à la base 
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO users (image, name, firstname, age, tel, email, pays, comment, metier, url, password) values(?, ?, ?, ?, ? , ? , ? , ? , ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($image, $name, $firstname, $age, $tel, $email, $pays, $comment, $metier, $url, $password));
        Database::disconnect();
        header("Location: index.php");
    }

    if (empty($password)) {
        $passwordError = 'Please enter a password';
        $valid = false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include('./inc/head.php');
?>

<body>
    <?php
    include('./inc/header.php');
    ?>

    <main class="bg-secondary bg-opacity-25 mt-2">
        <div class="container-fluid ">

            <div class="row">

                <h1 class="text-center">Inscription</h1>
            </div>
        </div>

        <div class="container">
            <div class="row d-flex justify-content-center">

                <form class="row g-3 needs-validation w-75 border border-3 border-dark mt-5 pt-4 pb-5" novalidate method="POST" action="inscription.php" enctype="multipart/form-data">
                    <div class="col-md-4 <?php echo !empty($imageError) ? 'error' : ''; ?>">

                        <label for="validationCustom11" class="form-label"><b>Profil image :</b></label>

                        <input type="file" name="image" class="form-control" id="validationCustom11" value="<?php echo !empty($image) ? $image : ''; ?>" required>
                        <?php if (!empty($imageError)) : ?>
                            <span class="help-inline"><?php echo $imageError; ?></span>
                        <?php endif; ?>


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-4 <?php echo !empty($nameError) ? 'error' : ''; ?>">

                        <label for="validationCustom01" class="form-label"><b>Name :</b></label>

                        <input type="text" name="name" class="form-control" id="validationCustom01" placeholder="Name" value="<?php echo !empty($name) ? $name : ''; ?>" required>
                        <?php if (!empty($nameError)) : ?>
                            <span class="help-inline"><?php echo $nameError; ?></span>
                        <?php endif; ?>


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>



                    <div class="col-md-4 <?php echo !empty($firstnameError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>firstname :</b></label>

                        <input type="text" class="form-control" id="validationCustom02" name="firstname" placeholder="firstname" value="<?php echo !empty($firstname) ? $firstname : ''; ?>" required>

                        <?php if (!empty($firstnameError)) : ?>
                            <span class="help-inline"><?php echo $firstnameError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>


                    <div class="col-md-4 <?php echo !empty($ageError) ? 'error' : ''; ?>">
                        <label for="validationCustomUsername" class="form-label"><b>Age :</b></label>

                        <input type="date" class="form-control" id="validationCustom03" name="age" value="<?php echo !empty($age) ? $age : ''; ?>" required>

                        <?php if (!empty($ageError)) : ?>
                            <span class="help-inline"><?php echo $ageError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>



                    <div class="col-md-4 <?php echo !empty($emailError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>Email :</b></label>

                        <input type="email" class="form-control" id="validationCustom04" name="email" placeholder="xxxxx@xxx.xx" value="<?php echo !empty($email) ? $email : ''; ?>" required>

                        <?php if (!empty($emailError)) : ?>
                            <span class="help-inline"><?php echo $emailError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>



                    <div class="col-md-4 <?php echo !empty($telError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>Telephone :</b></label>

                        <input type="tel" class="form-control" id="validationCustom05" name="tel" placeholder="Telephone" value="<?php echo !empty($tel) ? $tel : ''; ?>" required>

                        <?php if (!empty($telError)) : ?>
                            <span class="help-inline"><?php echo $telError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>


                    <div class="col-md-4 <?php echo !empty($paysError) ? 'error' : ''; ?>">
                        <label for="validationCustom04" class="form-label"><b>Pays :</b></label>

                        <select name="pays" class="form-select" id="validationCustom06" value="<?php echo !empty($pays) ? $pays : ''; ?>" required>
                            <option value="France">France</option>
                            <option value="Angleterre">Angleterre</option>
                            <option value="pays-bas">Pays-bas</option>
                        </select>

                        <?php if (!empty($paysError)) : ?>
                            <span class="help-inline"><?php echo $paysError; ?></span>
                        <?php endif; ?>

                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>


                    <div class="col-md-3 <?php echo !empty($metierError) ? 'error' : ''; ?>">

                        <label class="checkbox-inline"><b>Metier :</b> </label><br>

                        <input type="checkbox" name="metier" value="dev" <?php if (isset($metier) && $metier == "dev" || empty($metier)) echo "checked"; ?>> Developpeur <br>

                        <input type="checkbox" name="metier" value="integrateur" <?php if (isset($metier) && $metier == "integrateur") echo "checked"; ?>> Integrateur<br>

                        <input type="checkbox" name="metier" value="reseau" <?php if (isset($metier) && $metier == "reseau") echo "checked"; ?>> Reseau

                        <?php if (!empty($metierError)) : ?>
                            <span class="help-inline"><?php echo $metierError; ?></span>
                        <?php endif; ?>
                    </div>



                    <div class="col-md-9 <?php echo !empty($urlError) ? 'error' : ''; ?>">

                        <label for="validationCustom07" class="form-label"><b>Siteweb :</b></label>

                        <input type="text" class="form-control w-100" id="validationCustom05" name="url" value="<?php echo !empty($url) ? $url : ''; ?>" placeholder="http://www.xxxxx.com" required>

                        <?php if (!empty($urlError)) : ?>
                            <span class="help-inline"><?php echo $urlError; ?></span>
                        <?php endif; ?>

                        <div class="invalid-feedback">
                            Please provide a valid url.
                        </div>
                    </div>



                    <div class="col-12 <?php echo !empty($commentError) ? 'error' : ''; ?>">

                        <label for="validationCustom08" class="form-label"><b>Commentaire :</b></label>

                        <textarea rows="4" cols="30" name="comment" class="form-control" id="validationCustom05"><?php if (isset($comment)) echo $comment; ?></textarea>

                        <?php if (!empty($commentError)) : ?>
                            <span class=" help-inline"><?php echo $commentError; ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 <?php echo !empty($passwordError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>password :</b></label>

                        <input type="text" class="form-control" id="validationCustom02" name="password" placeholder="password" value="<?php echo !empty($password) ? $password : ''; ?>" required>

                        <?php if (!empty($passwordError)) : ?>
                            <span class="help-inline"><?php echo $passwordError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>




                    <div class="col-12">
                        <input type="submit" class="btn btn-success" name="submit" value="submit">

                        <a class="btn" href="index.php">Retour</a>
                    </div>
                </form>

            </div>
        </div>


    </main>

</body>

</html>