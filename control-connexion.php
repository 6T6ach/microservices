<?php
session_start();

// Vide $_SESSION si existe 
session_unset();

// Controle des infos envoyés par l'utilisateur

echo "<pre>";
echo '$_POST<br>';
var_dump($_POST);
echo "</pre>";

require('./administrateur/database.php');

if (isset($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['type'])) {

    // récupérer le nom d'utilisateur 
    $name = stripslashes($_REQUEST['name']);
    $name = mysqli_real_escape_string($cont, $name);

    // récupérer l'email 
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($cont, $email);

    // récupérer du type
    $type = stripslashes($_REQUEST['type']);
    $type = mysqli_real_escape_string($cont, $type);


    // récupérer le mot de passe 
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($cont, $password);


    // Vérifie si utilisateur est présent dans bdd
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT email, password, type FROM users WHERE email = $_POST[email] && password = $_POST[password] && type =$type";
    $q = $pdo->prepare($sql);

    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);


    // BDD - Table user
    // REVIEW récuperation de email et mdp et role(a ajouter dans la bdd) dans la bdd
    // $email = 'a@b.c';
    // $passwd = '123456';
    // $pseudo = 'Nico';
    $lang = 'fr';
    // $image_profile = 'image/profile.jpg';

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        session_unset();
        $_SESSION['message'] = '✅ Données reçues';


        // si user n'est pas admin
        if ($_POST['email'] == $email && $_POST['password'] == $password && $type == '') {
            session_unset();

            $_SESSION['status'] = 1;
            $_SESSION['name'] = $name;
            $_SESSION['lang'] = $lang;
            // Retour automatique à la page d'accueil
            header('Location: ../index.php');
        } else {
            session_unset();
            $_SESSION['message'] = '⚠ Email ou Mot de passe inconnu';

            header('Location: ../connexion.php');
        }

        // si user est admin
        if ($_POST['email'] == $email && $_POST['password'] == $password && $type == 'admin') {
            session_unset();

            $_SESSION['status'] = 2;
            $_SESSION['name'] = $name;
            $_SESSION['lang'] = $lang;
            // Retour automatique à la page d'accueil
            header('Location: ./index.php');
        } else {
            session_unset();
            $_SESSION['message'] = '⚠ Email ou Mot de passe inconnu';

            header('Location: ../connexion.php');
        }
    } else {
        session_unset();
        $_SESSION['message'] = '⚠ Veuillez remplir les 2 champs pour vous connecter';

        header('Location: ../connexion.php');
    }
}


echo "<pre>";
echo '$_SESSION<br>';
print_r($_SESSION);
echo "</pre>";
