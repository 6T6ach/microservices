<?php
session_start();

require 'database.php';
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) { // on initialise nos erreurs 
    $image = null;
    $nameError = null;
    $firstnameError = null;
    $ageError = null;
    $telError = null;
    $emailError = null;
    $paysError = null;
    $commentError = null;
    $metierError = null;
    $urlError = null; // On assigne nos valeurs 


    $image = $_FILES['image'];
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $age = $_POST['age'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $pays = $_POST['pays'];
    $comment = $_POST['comment'];
    $metier = $_POST['metier'];
    $url = $_POST['url']; // On verifie que les champs sont remplis 
    $valid = true;

    if (empty($image)) {
        $imageError = 'Please upload your photo';
        $valid = false;
    }
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }

    if (empty($firstname)) {
        $firstnameError = 'Please enter firstname';
        $valid = false;
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
    }

    if (!isset($pays)) {
        $paysError = 'Please select a country';
        $valid = false;
    }

    if (empty($comment)) {
        $commentError = 'Please enter a description';
        $valid = false;
    }

    if (!isset($metier)) {
        $metierError = 'Please select a job';
        $valid = false;
    }

    if (empty($url)) {
        $urlError = 'Please enter website url';
        $valid = false;
    } // mise à jour des donnés 

    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE users SET image = ?, name = ?, firstname = ?, age = ?,tel = ?, email = ?, pays = ?, comment = ?, metier = ?, url = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($image, $name, $firstname, $age, $tel, $email, $pays, $comment, $metier, $url, $id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM users where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $image = $data['image'];
    $name = $data['name'];
    $firstname = $data['firstname'];
    $age = $data['age'];
    $tel = $data['tel'];
    $email = $data['email'];
    $pays = $data['pays'];
    $comment = $data['comment'];
    $metier = $data['metier'];
    $url = $data['url'];
    Database::disconnect();
}

?>

<!DOCTYPE html>
<html>

<?php
include('./inc/head.php');
?>

<body class="bg-secondary bg-opacity-25">

    <?php
    include('./inc/header.php');
    ?>



    <div class="container w-25 mt-5 mb-5">


        <div class="row text-center mt-5 flex-wrap">

            <h1>Modifier un contact</h1>

        </div>



        <form class="border border-3 border-dark mt-5 flex-wrap bg-light" method="GET" action="update.php?id=<?php echo $id; ?>">

            <div class="control-group m-3<?php echo !empty($imageError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Image :</label>

                <div class="controls">
                    <input class="form-control w-100" id="validationCustom11" name="image" type="file" placeholder="Image" value="<?php echo !empty($image) ? $image : ''; ?>">
                    <?php if (!empty($imageError)) : ?>
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    <?php endif; ?>
                </div>


            </div>

            <div class="control-group m-3<?php echo !empty($nameError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Name :</label>

                <div class="controls">
                    <input class="form-control w-100" id="validationCustom01" name="name" type="text" placeholder="Name" value="<?php echo !empty($name) ? $name : ''; ?>">
                    <?php if (!empty($nameError)) : ?>
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    <?php endif; ?>
                </div>


            </div>


            <div class="control-group m-3<?php echo !empty($firstnameError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">firstname :</label>


                <div class="controls">
                    <input class="form-control w-100" id="validationCustom01" type="text" name="firstname" value="<?php echo !empty($firstname) ? $firstname : ''; ?>">
                    <?php
                    if (!empty($firstnameError)) : ?>
                        <span class="help-inline"><?php echo $firstnameError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>


            <div class="control-group m-3<?php echo !empty($ageError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Age :</label>


                <div class="controls">
                    <input class="form-control w-100" id="validationCustom01" type="date" name="age" value="<?php echo !empty($age) ? $age : ''; ?>">
                    <?php
                    if (!empty($ageError)) : ?>
                        <span class="help-inline"><?php echo $ageError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>


            <div class="control-group m-3 <?php echo !empty($emailError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Email :</label>


                <div class="controls">
                    <input class="form-control w-100" id="validationCustom01" name="email" type="text" placeholder="Email" value="<?php echo !empty($email) ? $email : ''; ?>">
                    <?php
                    if (!empty($emailError)) : ?>
                        <span class="help-inline"><?php echo $emailError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>



            <div class="control-group m-3 <?php echo !empty($telError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Telephone :</label>


                <div class="controls">
                    <input class="form-control w-100" id="validationCustom01" name="tel" type="tel" placeholder="Telephone" value="<?php echo !empty($tel) ? $tel : ''; ?>">
                    <?php
                    if (!empty($telError)) : ?>
                        <span class="help-inline"><?php echo $telError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>



            <div class="control-group m-3 <?php echo !empty($paysError) ? 'error' : ''; ?>">

                <label class="control-label fw-bold">Pays :</label><br>

                <select class="form-control w-100" id="validationCustom01" name="pays">

                    <option value=" paris">Paris</option>

                    <option value="londres">Londres</option>

                    <option value="amsterdam">Amsterdam</option>

                </select>
                <?php
                if (!empty($paysError)) : ?>
                    <span class="help-inline"><?php echo $paysError; ?></span>
                <?php
                endif;
                ?>
            </div>


            <div class="control-group m-3 <?php echo !empty($metierError) ? 'error' : ''; ?>">
                <label class="checkbox-inline fw-bold">Metier :</label>


                <div class="controls">
                    Dev : <input type="checkbox" name="metier" value="dev" <?php if (isset($metier) && $metier == "dev") echo "checked"; ?>>
                    Integrateur <input type="checkbox" name="metier" value="integrateur" <?php if (isset($metier) && $metier == "integrateur") echo "checked"; ?>>
                    Reseau <input type="checkbox" name="metier" value="reseau" <?php if (isset($metier) && $metier == "reseau") echo "checked"; ?>>
                </div>


                <?php
                if (!empty($metierError)) : ?>
                    <span class="help-inline"><?php echo $metierError; ?></span>
                <?php
                endif;
                ?>
            </div>



            <div class="control-group m-3 <?php echo !empty($urlError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Siteweb :</label>


                <div class="controls">
                    <input class="w-100 form-control" id="validationCustom01" type="text" name="url" value="<?php echo !empty($url) ? $url : ''; ?>">
                    <?php
                    if (!empty($urlError)) : ?>
                        <span class="help-inline"><?php echo $urlError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>


            <div class="control-group m-3 <?php echo !empty($commentError) ? 'error' : ''; ?>">
                <label class="control-label fw-bold">Commentaire :</label>


                <div class="controls">
                    <textarea class="w-100 form-control" id="validationCustom01" rows="4" cols="30" name="comment"><?php if (isset($comment)) echo $comment; ?></textarea>
                    <?php
                    if (!empty($commentError)) : ?>
                        <span class="help-inline"><?php echo $commentError; ?></span>
                    <?php
                    endif;
                    ?>
                </div>


            </div>


            <div class="form-actions text-center p-5">
                <input type="submit" class="btn btn-primary" name="submit" value="submit">
                <a class="btn btn-secondary" href="index.php">Retour</a>
            </div>


        </form>




    </div>


</body>

</html>