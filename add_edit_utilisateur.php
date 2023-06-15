<?php
session_start();
require_once 'functions.php';

if (!empty($_POST)) {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $adresse_postale = $_POST['adresse_postale'] ?? '';
    $code_postal = $_POST['code_postal'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $email = $_POST['email'] ?? '';
    $pwd = $_POST['pwd'] ?? '';
    $num_telephone = $_POST['num_telephone'] ?? '';
    $username = $_POST['username'] ?? '';
    $ville = $_POST['ville'] ?? '';

    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    // Un membre n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie s'il  le membre a un ID.
    if (empty($_POST['id_membre'])) {
         // S'il n'y a pas d'ID, le membre n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createUtilisateurStmt = $db->prepare('INSERT INTO membres (prenom, nom, adresse_postale, code_postal,date_naissance,email,pwd,num_telephone,username,ville) VALUES (:prenom, :nom, :adresse_postale, :code_postal,:date_naissance,:email,:pwd,:num_telephone,:username,:ville )');
            // Exécution de la requête
            $createUtilisateurStmt->execute(['prenom'=>$prenom, 'nom'=>$nom, 'adresse_postale'=>$adresse_postale,'code_postal'=>$code_postal,'date_naissance'=>$date_naissance, 'email'=>$email, 'pwd'=>$pwd, 'num_telephone'=>$num_telephone, 'username'=>$username, 'ville'=>$ville]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createUtilisateurStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Membre ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Membre non ajouté';
            }
        } catch (Exception $e) {
            // Le membre n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Membre non ajouté: ' . $e->getMessage();
        }
    } else {
        // Le membre existe, on met à jour ses informations

        // Récupération de l'ID du membre
        $id = filter_input(INPUT_POST, 'id_membre', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations du membre
        try {
            // Préparation de la requête de mis à jour
            $updateUtilisateurStmt = $db->prepare('UPDATE membres SET prenom=:prenom, nom=:nom, username=:username,adresse_postale=:adresse_postale,code_postal=:code_postal, ville=:ville,date_naissance=:date_naissance,email=:email,pwd=:pwd,num_telephone=:num_telephone WHERE id_membre=:id_membre');
            // Exécution de la requête
           $updateUtilisateurStmt->execute(['prenom'=>$prenom, 'nom'=>$nom, 'username'=>$username,'adresse_postale'=>$adresse_postale,'code_postal'=>$code_postal, 'ville'=>$ville,'date_naissance'=>$date_naissance,'email'=>$email,'pwd'=>$pwd,'num_telephone'=>$num_telephone, 'id_membre'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateUtilisateurStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Membre mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Membre non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Membre non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createUtilisateurStmt = null;
    $updateUtilisateurStmt = null;
    $db = null;

    // Redirection vers la page principale des membres en passant le message et son type en variables GET
    header('location:' . 'Utilisateur.php?type=' . $type . '&message=' . $message);
}