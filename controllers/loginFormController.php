<?php
$regexpPseudo = '/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\ \-\_]+$/';

//verification formulaire login
if(isset($_POST['btn-login'])){
    $user = new user();
    if (!empty($_POST['mail'])) {
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $user->mail = htmlspecialchars($_POST['mail']);
        }else {
            $formErrors['mail'] = 'Votre mail n\'est pas valide, veuillez utiliser le format : motoPaddock@gmail.com';
        }
    }else{
        $formErrors['mail'] = 'Veuillez entrer votre adresse mail.';
    }
    if (empty($_POST['password'])) {
        $formErrors['password'] = 'Veuillez entrer votre mot de passe.';
    }
    if(empty($formErrors)){
        //On récupère le hash de l'utilisateur
        $hash = $user->getUserPasswordHash();
        //Si le hash correspond au mot de passe saisi
        if(password_verify($_POST['password'], $hash)){
            //On récupère son profil
            $userProfil = $user->getUserProfile();
            //On met en session ses informations
            $_SESSION['profile']['id'] = $userProfil->id;
            $_SESSION['profile']['username'] = $userProfil->username;
            $_SESSION['profile']['mail'] = $userProfil->mail;
            $_SESSION['profile']['id_ap29f_roles'] = $userProfil->id_ap29f_roles;
            //On redirige vers une autre page.
            header('location:../index.php?action=loginIsOk');
            exit();
        }else{
            $formErrors['password'] = $formErrors['mail'] = 'Le mot de passe et/ou l\'adresse mail est incorrecte.';
        }
    }
}

//verification formulaire register
if(isset($_POST['btn-register'])){
    $user = new user();
    $isPasswordOk = true;
    if (!empty($_POST['username'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['username'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpPseudo)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $user->username = htmlspecialchars($_POST['username']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['username'] = 'Votre pseudo n\'est pas valide, ne pas utiliser de caractéres spéciaux autres que - et _.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['username'] = 'Veuillez entrer votre pseudo.';
    }
    //verification mail
    if (!empty($_POST['mail'])) {
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $user->mail = htmlspecialchars($_POST['mail']);
        }else {
            $formErrors['mail'] = 'Votre mail n\'est pas valide, veuillez utiliser le format : motoPaddock@gmail.com';
        }
    }else {
        $formErrors['mail'] = 'Veuillez entrer votre adresse mail.';
    }
    //verification password
    if(empty($_POST['password'])){
        $formErrors['password'] = 'Veuillez entrer votre mot de passe.';
        $isPasswordOk = false;
    }
    if(empty($_POST['verifyPassword'])){
        $formErrors['verifyPassword'] = 'Veuillez entrer de nouveau votre mot de passe.';
        $isPasswordOk = false;
    }
    //Si les vérifications des mots de passe sont ok
    if($isPasswordOk){
        if($_POST['verifyPassword'] == $_POST['password']){
            //On hash le mot de passe avec la méthode de PHP
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }else{
            $formErrors['password'] = $formErrors['verifyPassword'] = 'Les mots de passe saisis ne sont pas identiques.';
        }
    }

    if(empty($formErrors)){
        $isOk = true;
        //On vérifie si le pseudo est libre
        if($user->checkDispoByFieldName(['username'])){
            $formErrors['username'] = 'Désolé, ce nom d\'utilisateur est déjà utilisé.';
            $isOk = false;
        }
        //On vérifie si le mail est libre
        if($user->checkDispoByFieldName(['mail'])){
            $formErrors['mail'] = 'Désolé, cette adresse mail est déjà utilisée.';
            $isOk = false;
        }
        //Si c'est bon on ajoute l'utilisateur
        if($isOk){
            $user->addUser();
            $formMessageSuccess = 'Votre inscription est validé.';
        }
    }
}
//Traitement de la demande AJAX
if(isset($_POST['fieldValue'])){
    //On vérifie que l'on a bien envoyé des données en POST
    if(!empty($_POST['fieldValue']) && !empty($_POST['fieldName'])){
        //On inclut les bons fichiers car dans ce contexte ils ne sont pas connu.
        include_once '../models/dataBase.php';
        include_once '../models/users.php';
        $user = new user();
        $input = htmlspecialchars($_POST['fieldName']);
        $user->$input = htmlspecialchars($_POST['fieldValue']);
        //Le echo sert à envoyer la réponse au JS
        echo $user->checkDispoByFieldName([htmlspecialchars($_POST['fieldName'])]);
    }else{
        echo 2;
    }
}