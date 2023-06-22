<?php /*
session_start();
require_once 'functions.php';



    // Connection à la BDD
   $annonce=getAnnonces();
 


?>

<?php require_once 'header.php';
require_once "authentification/model/functions.php";?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='Annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>

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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Annonces</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>titre</th>
                <th scope='col'>description_annonces</th>
                <th scope='col'>prix_vente</th>
                

            </tr>
        </thead>
        <tbody>
            <?php foreach ($annonce as $annonces) : ?>
                <tr>            <?php if ($_SESSION['is_admin'] == true || ($_SESSION['id_membre'] == $annonces['id_utilisateur'])) : ?> <tr> 

                    <td><?= $annonces['id_annonce'] ?></td>
                    <td><?= htmlentities($annonces['titre']) ?></td>
                    <td><?= htmlentities($annonces['description_annonces']) ?></td>
                    <td><?= htmlentities($annonces['prix_vente']) ?></td>
                    <td><?= htmlentities($annonces['actif']) ?></td>
                    <td><?= $annonces['id_etat'] ?></td>
                    <td>
                        <a class='btn btn-primary' href='annonces_form.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete_annonces.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Supprimer</a>


                        <?php if($annonces['actif']==0 && $_SESSION['is_admin']==true) 
                            { ?>  <a class='btn btn-success' href='validate_annonces.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Valider</a> </a>
                            <?php } ?>
                       
                    </td>
                </tr><?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='annonces_form.php' role='button'>Ajouter Annonce</a>
    </div>
</div>

<?php require_once 'footer.php' */?>



<?php
session_start();
require_once 'functions.php';

// Connexion à la BDD
$id= $_SESSION['id_membre'];
$annonce = getAnnoncesByIdMembre($id);




 require_once 'header.php';
require_once "authentification/model/functions.php"; ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='Annonces.php' class='btn btn-secondary m-2 active' role='button'>Annonces</a>

<?php if (!empty($_GET['type']) && ($_GET['type'] === 'success')) : ?>
    <div class='row'>
        <div class='alert alert-success'>
            Succès! <?= htmlspecialchars($_GET['message']) ?>
        </div>
    </div>
<?php elseif (!empty($_GET['type']) && ($_GET['type'] === 'error')) : ?>
    <div class='row'>
        <div class='alert alert-danger'>
            Erreur! <?= htmlspecialchars($_GET['message']) ?>
        </div>
    </div>
<?php endif; ?>

<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Annonces</h1>
</div>

<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>id</th>
                <th scope='col'>titre</th>
                <th scope='col'>description_annonces</th>
                <th scope='col'>prix_vente</th>
            </tr>
        </thead>
        <tbody>
        <?php var_dump($_SESSION['is_admin']);
              var_dump($_SESSION['id_membre']);
         if(!empty($annonce) && is_array($annonce)){

         foreach ($annonce as $annonces) : 
            
     if ($_SESSION['is_admin'] == true || $_SESSION['id_membre'] == $annonces['id_utilisateur']) :
   ?>
            <tr>
                <td><?= $annonces['id_annonce'] ?></td>
                <td><?=$annonces['id_utilisateur'] ?></td>
                <td><?= htmlspecialchars($annonces['titre']) ?></td>
                <td><?= htmlspecialchars($annonces['description_annonces']) ?></td>
                <td><?= htmlspecialchars($annonces['prix_vente']) ?></td>
                <td><?= htmlspecialchars($annonces['actif'] ?? "") ?></td>
               
                <td>
                    
                    <a class='btn btn-primary' href='annonces_form.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Modifier</a>
                    <?php if ($_SESSION['is_admin'] == true||$_SESSION['id_membre'] == $annonces['id_utilisateur']) : ?>
                        <a class='btn btn-danger' href='delete_annonces.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Supprimer</a>
                    <?php endif; ?>
                    <?php if ($annonces['actif'] == 0 && $_SESSION['is_admin'] == true) : ?>
                        <a class='btn btn-success' href='validate_annonces.php?id=<?= $annonces['id_annonce'] ?>' role='button'>Valider</a>
                    <?php endif; ?>
                </td>
            </tr>
      
    <?php endif; ?>
<?php endforeach; 

                    } else echo 'aucun résultat';
                    ?>




        </tbody>
    </table>
</div>

<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='annonces_form.php' role='button'>Ajouter Annonce</a>
    </div>
</div>

<?php require_once 'footer.php'; ?>
