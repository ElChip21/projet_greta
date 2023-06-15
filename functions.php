
<?php
// Connection à la base de données et renvoie l'objet PDO
function connect() {
    // hôte
    $hostname = 'localhost';

    // nom de la base de données
    $dbname = 'projet_annonces';

    // identifiant et mot de passe de connexion à la BDD
    $username = 'root';
    $password = '';
    
    // Création du DSN (data source name) en combinant le type de BDD, l'hôte et le nom de la BDD
    $dsn = "mysql:host=$hostname;dbname=$dbname";

    // Tentative de connexion avec levée d'une exception en cas de problème
    try{
      return new PDO($dsn, $username, $password);
    } catch (Exception $e){
      echo $e->getMessage();
    }
}


//On liste toutes les annonces
function getAnnonces() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $annoncesQuery=$db->query('SELECT * FROM annonces');

        // Renvoie tous les lignes
        return $annoncesQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}
function validerAnnonce($id_annonce) {
    try {
        // Se connecter à la BDD avec la fonction connect() définie dans functions.php
        $db = connect();

        // Préparer la requête pour mettre à jour l'annonce
        $query = $db->prepare('UPDATE annonces SET actif = 1 WHERE id_annonce = :id_annonce');

        // Exécuter la requête en fournissant l'ID de l'annonce
        $query->execute(['id_annonce' => $id_annonce]);

        // Fermer la connexion à la BDD
        $db = null;
    } catch (Exception $e) {
        // Afficher le message s'il y a une exception
        echo $e->getMessage();
    }
}
//liste tous les utilisateurs

function getUtilisateurs() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les membres
        $membresQuery=$db->query('SELECT * FROM membres');

        // Renvoie tous les lignes
        return $membresQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}
//liste toutes les catégories

function getCategories() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $categoriesQuery=$db->query('SELECT * FROM categories');

        // Renvoie tous les lignes
        return $categoriesQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}

function getEtats() {
    try {
        // Récupération de l'objet PDO
        $db = connect();

        // Requête pour récupérer tous les abos
        $etatsQuery=$db->query('SELECT * FROM etats');

        // Renvoie tous les lignes
        return $etatsQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // En cas d'erreur afficher le message
        echo $e->getMessage();
    }
}






