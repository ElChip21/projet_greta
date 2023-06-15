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

// Récupération d'un utilisateur à partir de son email
function getUserByEmail($email) {
    try {
        $db = connect();
        $query=$db->prepare('SELECT * FROM membres WHERE email= :email');
        $query->execute(['email'=>$email]);
        if ($query->rowCount()){
            // Renvoie toutes les infos de l'utilisateur
            return $query->fetch();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } 
    return false;
}   

// Récupération d'un utilisateur à partir d'un token
function getUserByToken($token) {
    try {
        $db = connect();
        $query=$db->prepare('SELECT * FROM membres WHERE token= :token');
        $query->execute(['token'=>$token]);
        if ($query->rowCount()){
            // Renvoie toutes les infos de l'utilisateur
            return $query->fetch();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } 
    return false;
}   

// Récupération d'un utilisateur à partir d'un id
function getUserById($id) {
    try {
        $db = connect();
        $query=$db->prepare('SELECT * FROM membres WHERE id_membre= :id_membre');
        $query->execute(['id_membre'=>$id]);
        if ($query->rowCount()){
            // Renvoie toutes les infos de l'utilisateur
            return $query->fetch();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } 
    return false;
}

function addUser() {
 
    $email=filter_var(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    if(!getUserByEmail($email)){
        if ($_POST['pwd']===$_POST['pwd2']){
            if(preg_match("/^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$/", $_POST['pwd'])){
                $nom=htmlspecialchars($_POST['nom']);
                $prenom=htmlspecialchars($_POST['prenom']);
                $username=htmlspecialchars($_POST['username']);
                $date_naissance=htmlspecialchars($_POST['date_naissance']);
                $adresse_postale=htmlspecialchars($_POST['adresse_postale']);
                $ville=htmlspecialchars($_POST['ville']);
                $code_postal=htmlspecialchars($_POST['code_postal']);
                $num_telephone=htmlspecialchars($_POST['num_telephone']);
               
                $pwd=password_hash($_POST['pwd'], PASSWORD_DEFAULT);
               
                $token=bin2hex(random_bytes(16));
                try {
                    $db = connect();
                    $query=$db->prepare('INSERT INTO membres (nom,prenom,username,date_naissance, adresse_postale, ville, code_postal, num_telephone, email, pwd, token) VALUES (:nom, :prenom, :username, :date_naissance, :adresse_postale, :ville, :code_postal, :num_telephone, :email, :pwd, :token)');
                    $query->execute(['nom'=> $nom , 'prenom'=> $prenom,'username'=> $username,'date_naissance'=>$date_naissance,'adresse_postale'=>$adresse_postale, 'ville'=>$ville,'code_postal'=>$code_postal, 'num_telephone'=>$num_telephone, 'email'=> $email, 'pwd'=> $pwd, 'token'=> $token]);
                    if ($query->rowCount()){//CHANGER PAR L'ADRESSE LOCALHOST
                        $content="<p><a href='localhost/projet/authentification.test?p=activation& t=$token'>Merci de cliquer sur ce lien pour activer votre compte</a></p>";
                        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                        $headers = array(
                            'MIME-Version' => '1.0',
                            'Content-type' => 'text/html; charset=iso-8859-1',
                            'X-Mailer' => 'PHP/' . phpversion()
                        );
                        mail($email,"Veuillez activer votre compte", $content, $headers);
                        return array("success", "Inscription réussi. Vous allez recevoir un mail pour activer votre compte");
                    }else return array("error", "Problème lors de enregistrement");
                } catch (Exception $e) {
                    return array("error",  $e->getMessage());
                } 
            }else return array("error", "Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial");
        }else return array("error", "Les 2 saisies de mot de passes doivent être identique.");
    }else return array("error", "Un compte existe déjà pour cet email.");
}

function logUser() {
    $email=filter_var(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    $user=getUserByEmail($email);
    if($user){
        if(password_verify($_POST['pwd'], $user['pwd'])){
            if($user['actif']){
                $_SESSION['is_login']=true;
                $_SESSION['is_actif']=$user['actif'];
                $_SESSION['id_membre']=$user['id_membre'];
                $_SESSION['username']=$user['username'];
                $_SESSION['is_admin']=$user['is_admin'];
               return array("success", "Connexion réussie :)
               ");               
            }else return array("error", "Veuillez activer votre compte");
        }else return array("error", "Mauvais identifiants");
    }else return array("error", "Mauvais identifiants");
}
// récupére le chemin de l'avatar
function getAvatar($id) {
    try {
        $db = connect();
        $query=$db->prepare('SELECT `path` FROM avatars WHERE id_membre= :id');
        $query->execute(['id'=>$id]);
        if ($query->rowCount()){
            $avatars=$query->fetchAll(PDO::FETCH_COLUMN,0);
            return $avatars[random_int(0,count($avatars)-1)];
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } 
    return false;
}

// enregistre les chemins des avatars
function addAvatar($id) {
    $cpt=0;
    foreach($_FILES['avatar']['error'] as $k=>$v){
        if(is_uploaded_file($_FILES['avatar']['tmp_name'][$k]) && $v == UPLOAD_ERR_OK) {
            $path="img/".$_FILES['avatar']['name'][$k];
            move_uploaded_file($_FILES['avatar']['tmp_name'][$k],$path);
            try{
                $db=connect();
                $query = $db->prepare("INSERT INTO avatars( id_membre, path) VALUES (:id_membre, :path)");
                $req= $query->execute(['id_membre'=>$id,'path'=>$path]);
                if($req) $cpt++;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
    return $cpt;
}

function activUser() {
    $token=htmlspecialchars($_GET['t']);
    $user=getUserByToken($token);
    if($user){
        if(!$user['actif']){
            try {
                $db = connect();
                $query=$db->prepare('UPDATE membres SET token = NULL, actif = 1 WHERE token= :token');
                    $query->execute(['token'=> $token]);
                    if ($query->rowCount()){
                         return array("success", "Votre compte est activé, vous pouvez vous connecter"); 
                    }else return array("error", "Problème lors de l'activation"); 
            } catch (Exception $e) {
                return array("error",  $e->getMessage());
            }              
        }else return array("error", "Ce compte est déjà actif");
    }else return array("error", "Lien invalide !");
}

function waitReset() {
    $email=filter_var(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    if(getUserByEmail($email)){
      $date_validite_token= date('H:i:s');
        $token= bin2hex(random_bytes(16));
        $date_validite_token= time()+1200;
        try {
            $db = connect();
            $query=$db->prepare('UPDATE membres SET token = :token, date_validite_token = :date_validite_token WHERE email = :email');
            $query->execute(['email'=> $email, 'date_validite_token'=> $date_validite_token , 'token'=> $token]);
            if ($query->rowCount()){
                $content="<p><a href='authentification.test?p=reset&t=$token'>Merci de cliquer sur ce lien pour réinitialiser votre mot de passe</a></p>";
                // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                $headers = array(
                    'MIME-Version' => '1.0',
                    'Content-type' => 'text/html; charset=iso-8859-1',
                    'X-Mailer' => 'PHP/' . phpversion()
                );
                mail($email,"Réinitialisation de mot de passe", $content, $headers);
                return array("success", "Vous allez recevoir un mail pour réinitialiser votre mot de passe".$content);
            }else return array("error", "Problème lors du process de réinitialisation");
        } catch (Exception $e) {
            return array("error",  $e->getMessage());
        }
    }else array("error", "Aucun compte ne correspond à cet email.");
}

function resetPwd() { $token=htmlspecialchars($_POST['token']);
    $user=getUserByToken($token);
    if($user){
        if (time()<$user['date_validite_token']){
            if ($_POST['pwd']===$_POST['pwd2']){
                if(preg_match("/^(?=.\d)(?=.[0-9])(?=.[a-z])(?=.[A-Z])(?=.*[\W]).{8,}$/", $_POST['pwd'])){                  $pwd=password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                    try {
                        $db = connect();
                        $query=$db->prepare('UPDATE users SET token = NULL, pwd = :pwd, actif = 1 WHERE token= :token');
                        $query->execute(['pwd'=> $pwd, 'token'=> $token]);
                        if ($query->rowCount()){
                            $content="<p>Votre mot de passe a été réinitialisé</p>";
                            $headers = array(
                                'MIME-Version' => '1.0',
                                'Content-type' => 'text/html; charset=iso-8859-1',
                                'X-Mailer' => 'PHP/' . phpversion()
                            );
                            mail($user['email'],"Réinitialisation de mot de passe", $content, $headers);
                            return array("success", "Votre mot de passe a bien été réinitialisé");
                        }else return array("error", "Problème lors de la réinitialisation");
                    } catch (Exception $e) {
                        return array("error",  $e->getMessage());
                    } 
                }else return array("error", "Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial");
            }else return array("error", "Les 2 saisies de mot de passe doivent être identiques.");
        }else return array("error", "Le lien n'est plus valide ! Veuillez <a href='?p=forgot'>recommencer</a>");
    }else return array("error", "Les données ont été corrompues ! Veuillez <a href='?p=forgot'>recommencer</a>");
}