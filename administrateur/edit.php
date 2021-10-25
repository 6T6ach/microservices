<?php
session_start();

require('./database.php'); //on appelle notre fichier de config 
$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location:index.php");
} else { //on lance la connection et la requete 
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) .
        $sql = "SELECT * FROM users where id =?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}



/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!DOCTYPE html>
<html lang="en">

<?php
include('../inc/head.php');
?>

<body class="bg-secondary bg-opacity-50">

    <?php
    include('./inc/header.php');
    ?>


    <div class="container mt-5 mb-5 pb-5">
        <div class="span10 offset1">
            <div class="row text-center ">

                <h1>Edition</h1>

            </div>

            <div class="form-horizontal mt-5 border border-3 border-dark bg-light">
                <div class="control-group m-4">
                    <label class="control-label fw-bold">Image :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['image'] ?>
                        </label>
                    </div>

                </div>


                <div class="control-group m-4">
                    <label class="control-label fw-bold">Name :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['name']; ?>
                        </label>
                    </div>

                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Firstname :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['firstname']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Email Address :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['email']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Phone :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['tel']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Pays :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['pays']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Metier :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['metier']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Url :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['url']; ?>
                        </label>
                    </div>


                </div>




                <div class="control-group m-4">
                    <label class="control-label fw-bold">Comment :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['comment']; ?>
                        </label>
                    </div>


                </div>

                <div class="control-group m-4">
                    <label class="control-label fw-bold">Password :</label>


                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['password']; ?>
                        </label>
                    </div>

                </div>






                <div class="form-actions text-center pb-5">
                    <a class="btn btn-primary w-25" href="index.php">Back</a>
                </div>




            </div>


        </div>



    </div>
    <!-- /container -->
</body>

</html>