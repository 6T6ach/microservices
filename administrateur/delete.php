<?php
session_start();

require 'database.php'; //lien base de données
$id = 0;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if (!empty($_POST)) {
    $id = $_POST['id'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM users  WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
    header("Location: index.php");
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html lang="en">

<?php include('./inc/head.php') ?>

<body class="bg-secondary bg-opacity-25">
    <?php include('./inc/header.php') ?>


    <div class="container-fluid pt-5  w-50">

        <div class="row text-center pt-5">
            <h3>Delete a user</h3>
        </div>

        <div class="span10 offset1 border border-3 border-dark pb-5 mt-5 bg-light">


            <br />
            <form class="form-horizontal d-block text-center" action="delete.php" method="post">

                <input type="hidden" name="id" value="<?php echo $id; ?>" /><b class="text-danger">Are you sure to delete ?</b>

                <br />
                <div class="form-actions pt-5">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <a class="btn btn-secondary" href="index.php">No</a>
                </div>
                <p>

            </form>
            <p>
        </div>
        <p>


    </div>
    <p>
        <!-- /container -->
</body>

</html>