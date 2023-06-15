<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <title>Authentification</title>
<!--<link rel="stylesheet" href="http://localhost/projet/authentification/asset/style.css">-->
</head>
<body>
<?php if (!empty($message)) : ?>
    <div class='row'>
        <div class='alert alert-<?=$message[0]?>'>
            <?= $message[1] ?>
        </div>
    </div>
<?php endif; ?>