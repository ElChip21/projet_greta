<?php

require_once 'functions.php';



    // Connection à la BDD
   $categorie=getCategories();
 


?>

<?php require_once 'header.php' ?>

<a href='index.php' class='btn btn-secondary m-2 active' role='button'>Accueil</a>
<a href='categories.php' class='btn btn-secondary m-2 active' role='button'>categories</a>

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
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>catégories</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>nom_categorie</th>
                <th scope='col'>description_categorie</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorie as $categories) : ?>
                <tr>
                    <td><?= $categories['id_categorie'] ?></td>
                    <td><?= htmlentities($categories['nom_categorie']) ?></td>
                    <td><?= htmlentities($categories['description_categorie']) ?></td>
                    <td>
                        <a class='btn btn-primary' href='categorie_form.php?id=<?= $categories['id_categorie'] ?>' role='button'>Modifier</a>
                        <a class='btn btn-danger' href='delete_categories.php?id=<?= $categories['id_categorie'] ?>' role='button'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='categorie_form.php' role='button'>Ajouter Catégorie</a>
    </div>
</div>

<?php require_once 'footer.php' ?>
