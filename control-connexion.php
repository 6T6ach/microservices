<?php
session_start();

// Vide $_SESSION si existe 
session_unset();

// Controle des infos envoyés par l'utilisateur
echo '$_POST';
var_dump($_POST);

// BDD - Table user
// REVIEW récuperation de email et mdp et role(a ajouter dans la bdd) dans la bdd
require('./administrateur/database.php');
$email = '';
$password = '';
$name = '';

$image_profile = 'image/profile.jpg';

if (isset($_SESSION['email'], $_SESSION['password'])) {
    // récupérer le nom d'utilisateur 
    
    $_SESSION['status'] = 1;
    // récupérer l'email 
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    // récupérer le mot de passe 
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "INSERT into users (email, type, password)
    VALUES ('$email', 'user', '" . hash('sha256', $password) . "')";
    $res = mysqli_query($conn, $query);
    if ($res) {
        echo "<div class='sucess'>
         <h3>Vous êtes inscrit avec succès.</h3>
         <p>Cliquez ici pour vous <a href='connexion.php'>connecter</a></p>
   </div>";
    }
} else {
    session_unset();
    $_SESSION['message'] = '⚠ Veuillez remplir les 2 champs pour vous connecter';

    header('Location: connexion.php');
}


echo '$_SESSION';
var_dump($_SESSION);
