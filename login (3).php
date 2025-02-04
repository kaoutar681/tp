<?php
 $serveur = "localhost";
 $user = "root";
 $password = "";

session_start();
$pdo = new PDO("mysql:host=$serveur;dbname=app_exercice", $user, $password);
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$nom_utilisateur = $_POST['nom_utilisateur'];
$mot_de_passe = $_POST['mot_de_passe'];

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur AND mot_de_passe = :mot_de_passe");
$stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
$stmt->bindParam(':mot_de_passe', $mot_de_passe);
$stmt->execute();

if ($stmt->fetch()) {
    $_SESSION['nom_utilisateur'] = $nom_utilisateur;

    //"Se souvenir de moi"
    if (isset($_POST['remember'])) {
        setcookie("utilisateur", $nom_utilisateur, time() + (86400 * 7), "/"); // Cookie pour 7 jours
    }
    
    header("Location: bienvenue.php");
    exit();
} else {
    echo "Nom d'utilisateur ou mot de passe incorrect.";
}
?>