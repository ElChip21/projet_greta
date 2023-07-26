<?php
session_start();
require_once ('functions.php');

if (!empty($_POST)) {
        //$date_creation = $_POST['date_creation'] ?? '';
     
        $titre = $_POST['titre'] ?? '';
        $description_annonces = $_POST['description_annonces'] ?? '';
        $prix_vente = $_POST['prix_vente'] ?? '';
 
    

    }
    // Connection à la BDD avec la fonction connect() dans functions.php
    $db = connect();

    

    // Une annonce n'a un ID que si ses infos sont déjà enregistrées en BDD, donc on vérifie si l'annonce a un ID.
    if (empty($_POST['id_annonce'])) {
         // S'il n'y a pas d'ID, l'annonce n'existe pas dans la BDD donc on l'ajoute.
         try {
            // Préparation de la requête d'insertion.
            $createAnnonceStmt = $db->prepare('INSERT INTO annonces (titre, description_annonces, prix_vente, id_utilisateur) VALUES (:titre, :description_annonces, :prix_vente, :id_utilisateur)');
            // Exécution de la requête
            $createAnnonceStmt->execute(['titre'=>$titre, 'description_annonces'=>$description_annonces, 'prix_vente'=>$prix_vente,'id_utilisateur'=>$_SESSION['id_membre']]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($createAnnonceStmt->rowCount()) {
                // Une ligne a été insérée => message de succès
                $type = 'success';
                $message = 'Annonce ajouté';
            } else {
                // Aucune ligne n'a été insérée => message d'erreur
                $type = 'error';
                $message = 'Annonce non ajouté';
            }
        } catch (Exception $e) {
            // Le membre n'a pas été ajouté, récupération du message de l'exception
            $type = 'error';
            $message = 'Annonce non ajouté: ' . $e->getMessage();
        }
    } else {
        // L'annonce existe, on met à jour ses informations

        // Récupération de l'ID de l'annonce
        $id = filter_input(INPUT_POST, 'id_annonce', FILTER_SANITIZE_NUMBER_INT);

        // Mise à jour des informations de l'annonce
        try {
            // Préparation de la requête de mise à jour
            $updateAnnonceStmt = $db->prepare('UPDATE annonces SET  titre=:titre, description_annonces=:description_annonces, prix_vente=:prix_vente WHERE id_annonce=:id_annonce');
            // Exécution de la requête
           $updateAnnonceStmt->execute(['titre'=>$titre, 'description_annonces'=>$description_annonces, 'prix_vente'=>$prix_vente,'id_annonce'=>$id]);
            // Vérification qu'une ligne a bien été impactée avec rowCount(). Si oui, on estime que la requête a bien été passée, sinon, elle a sûrement échoué.
            if ($updateAnnonceStmt->rowCount()) {
                // Une ligne a été mise à jour => message de succès
                $type = 'success';
                $message = 'Annonce mis à jour';
            } else {
                // Aucune ligne n'a été mise à jour => message d'erreur
                $type = 'error';
                $message = 'Annonce non mis à jour';
            }
        } catch (Exception $e) {
            // Une exception a été lancée, récupération du message de l'exception
            $type = 'error';
            $message = 'Annonce non mis à jour: ' . $e->getMessage();
        }
    }

    // Fermeture des connexions à la BDD
    $createAnnonceStmt = null;
    $updateAnnonceStmt = null;
    $db = null;

    // Redirection vers la page principale des annonces en passant le message et son type en variables GET
    header('location:' . 'Annonces.php?type=' . $type . '&message=' . $message);






//PREPARE
    //date_creation=:date_creation,duree_de_publication=:duree_de_publication,cout_annonce=:cout_annonce,date_validation=:date_validation,date_fin_publication=>:date_fin_publication,id_etat=:id_etat,id_utilisateur=:id_utilisateur,date_vente=:date_vente,id_acheteur=:id_acheteur

//EXECUTE
//'date_creation'=>$date_creation, 'duree_de_publication'=>$duree_de_publication, 'cout_annonce'=>$cout_annonce,'date_validation'=>$date_validation,'date_fin_publication'=>$date_fin_publication,'id_etat'=>$id_etat,'id_utilisateur'=>$id_utilisateur,'date_vente'=>$date_vente,'id_acheteur'=>$id_acheteur