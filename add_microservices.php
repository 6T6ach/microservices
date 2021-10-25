<?php
session_start();
?>

<?php require './administrateur/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    //on initialise nos messages d'erreurs; 
    $imageError = '';
    $nameError = '';
    $titreError = '';
    $contenuError = '';
    $prixError = '';
    $category_idError = '';
    $Error = '';


    // on recupère nos valeurs 
    // Récupération du nom l'images
    $image = htmlspecialchars($_FILES['image']['name']);
    var_dump($_FILES);
    var_dump($_FILES['image']['name']);

    // $name = htmlspecialchars(trim($_POST['name']));
    $titre = htmlspecialchars(trim($_POST['titre']));
    $contenu = htmlspecialchars(trim($_POST['contenu']));
    $prix = htmlspecialchars(trim($_POST['prix']));
    $user_id = htmlspecialchars(trim($_POST['user_id']));
    $category_id = htmlspecialchars(trim($_POST['category_id']));



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

                move_uploaded_file($_FILES['image']['tmp_name'], './administrateur/uploads/images/' . basename($_FILES['image']['name']));
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

    // on vérifie nos champs 
    $valid = true;
    if (empty($image)) {
        $imageError = 'Please insert un image';
        $valid = false;
    }
    // else if (!preg_match(" ", $image)) {
    //     $imageError = "Only jpg images";
    // }

    if (empty($titre)) {
        $nameError = 'Please enter title';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $titre)) {
        $titreError = "Only letters and white space allowed";
    }

    if (empty($user_id)) {
        $user_idError = 'Please enter name';
        $valid = false;
    } else if (!preg_match("/^[a-zA-Z ]*$/", $user_id)) {
        $user_idError = "Only letters and white space allowed";
    }

    if (empty($contenu)) {
        $contenuError = 'Please enter a description';
        $valid = false;
    }
    if (empty($prix)) {
        $prixError = 'Please enter a description';
        $valid = false;
    }
    if (empty($category_id)) {
        $category_idError = 'Please enter a description';
        $valid = false;
    }



    // si les données sont présentes et bonnes, on se connecte à la base 
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO microservices (image, titre, contenu, prix, user_id, category_id) values(?, ?, ?, ?, ?, ?)";
        // $sql = "INSERT INTO users (name) values(?)";

        $q = $pdo->prepare($sql);
        $q->execute(array($image, $titre, $contenu, $prix, $user_id, $category_id));
        Database::disconnect();
        header("Location: index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include('./inc/head.php');
?>

<body class="bg-secondary bg-opacity-25">
    <?php
    include('./inc/header.php');
    ?>

    <main>
        <div class="container-fluid mt-5 pt-4">

            <div class="row">

                <h1 class="text-center">Ajouter un microservice</h1>
            </div>
        </div>

        <div class="container">
            <div class="row d-flex justify-content-center">

                <form class="row g-3 needs-validation w-75 border border-3 border-dark mt-5 pt-4 pb-5" novalidate method="POST" action="add_microservices.php" enctype="multipart/form-data">

                    <div class="col-md-4 <?php echo !empty($titreError) ? 'error' : ''; ?>">

                        <label for="validationCustom01" class="form-label"><b>Titre article :</b></label>

                        <input type="text" name="titre" class="form-control" id="validationCustom01" placeholder="titre" value="<?php echo !empty($titre) ? $titre : ''; ?>" required>
                        <?php if (!empty($titreError)) : ?>
                            <span class="help-inline"><?php echo $titreError; ?></span>
                        <?php endif; ?>


                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

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


                    <div class="col-md-4 <?php echo !empty($user_idError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>user_id :</b></label>

                        <input type="text" class="form-control" id="validationCustom02" name="user_id" placeholder="user_id" value="<?php echo !empty($user_id) ? $user_id : ''; ?>" required>

                        <?php if (!empty($user_idError)) : ?>
                            <span class="help-inline"><?php echo $user_idError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-4 <?php echo !empty($category_idError) ? 'error' : ''; ?>">
                        <label for="validationCustom04" class="form-label"><b>category_id :</b></label>

                        <select name="category_id" class="form-select" id="validationCustom06" value="<?php echo !empty($category_id) ? $category_id : ''; ?>" required>
                            <!-- FIXME changer INT category_id en VARCHAR dans la bdd microservices -->
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>

                        <?php if (!empty($category_idError)) : ?>
                            <span class="help-inline"><?php echo $category_idError; ?></span>
                        <?php endif; ?>

                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>




                    <div class="col-md-4 <?php echo !empty($contenuError) ? 'error' : ''; ?>">
                        <label for="validationCustom02" class="form-label"><b>contenu :</b></label>

                        <textarea rows="4" cols="30" name="contenu" class="form-control" id="validationCustom05"><?php if (isset($contenu)) echo $contenu; ?></textarea>

                        <?php if (!empty($contenuError)) : ?>
                            <span class="help-inline"><?php echo $contenuError; ?></span>
                        <?php endif; ?>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                    <div class="col-md-4 <?php echo !empty($prixError) ? 'error' : ''; ?>">

                        <label for="validationCustom01" class="form-label"><b>Prix :</b></label>

                        <input type="number" name="prix" class="form-control" id="validationCustom01" placeholder="prix" value="<?php echo !empty($prix) ? $prix : ''; ?>" required>
                        <?php if (!empty($prixError)) : ?>
                            <span class="help-inline"><?php echo $prixError; ?></span>
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