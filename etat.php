<?php
session_start();
require_once 'functions.php';



    // Connection à la BDD
   $etat=getEtats();
 


?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='etat.php' class='btn btn-secondary m-2 active' role='button'>Etats</a>

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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Etats</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>libelle_etat</th>
                <th scope='col'>description_etat</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($etat as $etats) : ?>
                <tr>
                    <td><?= $etats['id_etat'] ?></td>
                    <td><?= htmlentities($etats['libelle_etat']) ?></td>
                    <td><?= htmlentities($etats['description_etat']) ?></td>
                    <td>
                        <a class='btn btn-primary' href='etat_form.php?id=<?= $etats['id_etat'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete_etat.php?id=<?= $etats['id_etat'] ?>' role='button'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='etat_form.php' role='button'>Ajouter Etat</a>
    </div>
</div>

<?php require_once 'footer.php' ?>
