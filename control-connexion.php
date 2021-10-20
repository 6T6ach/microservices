<?php 
session_start();

// Vide $_SESSION si existe 
session_unset();

// Controle des infos envoyés par l'utilisateur
echo '$_POST';
var_dump($_POST);

// BDD - Table user
// REVIEW récuperation de email et mdp et role(a ajouter dans la bdd) dans la bdd
$email = 'a@b.c';
$passwd = '123456';
$pseudo = 'Nico';
$lang = 'fr';
$image_profile = 'image/profile.jpg';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    session_unset();
    $_SESSION['message'] = '✅ Données reçues';

    if ( $_POST['email'] == $email && $_POST['password'] == $passwd ){
        session_unset();

        $_SESSION['status'] = 1;
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['lang'] = $lang;
        // Retour automatique à la page d'accueil
        header('Location: index.php');

    } else {
        session_unset();
        $_SESSION['message'] = '⚠ Email ou Mot de passe inconnu';

        header('Location: connexion.php');
    } 


} else {
    session_unset();
    $_SESSION['message'] = '⚠ Veuillez remplir les 2 champs pour vous connecter';

    header('Location: connexion.php');

}


echo '$_SESSION';
var_dump($_SESSION);

