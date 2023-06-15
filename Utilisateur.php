<?php
session_start();



require_once 'functions.php';



    // Connection à la BDD
   $utilisateur=getUtilisateurs();



?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='utilisateur.php' class='btn btn-secondary m-2 active' role='button'>Utilisateurs</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
    <div class='row'>
        <div class='alert alert-success'>             
            Succès! <?= $_GET['message'] ?>
        </div>
    </div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
    <div class='row'>
        <div class='alert alert-danger'>
            Erreur! <?= $_GET['message'] ?>
        </div>
    </div>
<?php endif; ?>
<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Utilisateurs</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>nom</th>
                <th scope='col'>prenom</th>
                <th scope='col'>username</th>
                <th scope='col'>num_telephone</th>
                <th scope='col'>adresse_postale</th>
                <th scope='col'>code_postal</th>
                <th scope='col'>ville</th>
                <th scope='col'>email</th>
                <th scope='col'>mot_de_passe</th>
                <th scope='col'>date_naissance</th>



            </tr>
        </thead>
        <tbody>
        <?php

//require_once 'authentification/model/functions.php';
// Vérification des identifiants de connexion
if ($_POST=== 'is_login') {
    $email = $_POST['email'];
    $password = $_POST['pwd'];
  
    // Vérifier les identifiants de connexion dans la base de données
    // Remplacez les lignes suivantes par votre propre logique de vérification
    $adminEmail = 'morgansclavo70@gmail.com';
    $adminPassword = 'Marlatin@18';
  
    if($email === $adminEmail && $password === $adminPassword) {
      
      // Connexion réussie pour un administrateur
      $_SESSION['is_admin'] = true;
  
}}
foreach ($utilisateur as $utilisateurs) : ?>
    <tr>
        <td><?= $utilisateurs['id_membre'] ?></td>
        <td><?= htmlentities($utilisateurs['nom']) ?></td>
        <td><?= htmlentities($utilisateurs['prenom']) ?></td>
        <td><?= htmlentities($utilisateurs['username']) ?></td>
        <td><?= htmlentities($utilisateurs['num_telephone']) ?></td>
        <td><?= htmlentities($utilisateurs['adresse_postale']) ?></td>
        <td><?= htmlentities($utilisateurs['code_postal']) ?></td>
        <td><?= htmlentities($utilisateurs['ville']) ?></td>
        <td><?= htmlentities($utilisateurs['email']) ?></td>
        <td><?= htmlentities($utilisateurs['pwd']) ?></td>
        <td><?= htmlentities($utilisateurs['date_naissance']) ?></td>
      
        <td>
            <a class='btn btn-primary' href='utilisateur_form.php?id=<?= $utilisateurs['id_membre'] ?>' role='button'>Modifier</a>
            <a class='btn btn-danger' href='delete_membres.php?id=<?= $utilisateurs['id_membre'] ?>' role='button'>Supprimer</a>
        </td>
    </tr>
<?php endforeach; 
      // Redirigez l'administrateur vers une page d'administration appropriée
      /*header('Location: admin_Backoffice.php');
      exit();
    } else {
      // Connexion échouée
      echo "Identifiants de connexion invalides";
    }
  }*/
           ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'><?php if($_SESSION['is_admin']===1){ ?>
        <a class='btn btn-success' href='utilisateur_form.php' role='button'>Ajouter utilisateur</a><?php } ?>
    </div>
</div>

<?php require_once 'footer.php'; ?>

