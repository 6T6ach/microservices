<?php
session_start();
include '../config.php';
?>



<!DOCTYPE html>
<html>

<?php
include('./inc/head.php');
?>

<body>
    <?php
    include SITE_ROOT.'/inc/header.php';
    ?>

    <div class="container-fluid border border-dark pt-5 justify-content-center w-100 bg-dark bg-opacity-50">
        <div class="row">
            <h2 class="title text-center text-light">CRUD EN PHP</h2>
        </div>
        <br>
        <br>

        <div class="row text-light">
            <a href="add.php" class="btn btn-success bg-primary w-25 m-1 mt-5 fw-bold">Créer un utilisateur :</a>

            <div class="table-responsive">

                <table class="table table-hover table-bordered">

                    <!-- thead = designation tableau -->
                    <thead class="bg-dark text-light text-center">
                        <th>id</th>

                        <th>image</th>

                        <th>Name</th>

                        <th>Firstname</th>

                        <th>Age</th>

                        <th>Tel</th>

                        <th>Email</th>

                        <th>Ville</th>

                        <th>Comment</th>

                        <th>Metier</th>

                        <th>Url</th>

                        <th>Edition</th>

                        <th>password</th>

                    </thead>


                    <br />
                    <tbody class="text-dark fw-bold text-light">
                        <?php
                        include 'database.php'; //on inclut notre fichier de connection 

                        $pdo = Database::connect(); //on se connecte à la base 
                        // var_dump($pdo);
                        $sql = 'SELECT * FROM users ORDER BY id DESC'; //on formule notre requete 
                        foreach ($pdo->query($sql) as $row) :
                            //on cree les lignes du tableau avec chaque valeur retournée
                            //td= contenu du tableau + formule lien base de donnée
                        ?>
                            <br />
                            <tr>
                                <td class="text-light"><?= $row['id'] ?></td>
                                <td class="text-light">
                                    <?= !empty($row['image']) ? '<img src="uploads/images/' . $row['image'] . '"width="50">' : '' ?></td>
                                <td class="text-light"><?= $row['name'] ?></td>
                                <td class="text-light"><?= $row['firstname'] ?></td>
                                <td class="text-light"><?= $row['age'] ?></td>
                                <td class="text-light"><?= $row['tel'] ?></td>
                                <td class="text-light"><?= $row['email'] ?></td>
                                <td class="text-light"><?= $row['pays'] ?></td>
                                <td class="text-light"><?= $row['comment'] ?></td>
                                <td class="text-light"><?= $row['metier'] ?></td>
                                <td class="text-light"><?= $row['url'] ?></td>
                                <td class="text-light"><?= $row['password'] ?></td>
                                <td class="text-light">
                                    <a class="btn bg-dark text-light" href="edit.php?id=<?= $row['id'] ?>">Read</a>

                                    <a class="btn btn-success m-1" href="update.php?id=<?= $row['id'] ?>">Update</a>

                                    <a class="btn btn-danger" href="delete.php?id=<?= $row['id'] ?>">Delete</a>

                            </tr>
                        <?php
                        endforeach;
                        Database::disconnect();
                        //on se deconnecte de la base
                        ?>
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <?php
    include('./inc/js.php');
    ?>



</body>

</html>