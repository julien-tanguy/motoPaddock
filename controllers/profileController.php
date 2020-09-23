<?php
$regexpPseudo = '/^[a-zA-ZÀ-ÖØ-öø-ÿ0-9\ \-\_]+$/';
$formErrors=[];
//verification formulaire qui permet de changer le pseudo
if(isset($_POST['btn-updateInfo'])){
    $user = new user();
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

    if(empty($formErrors)){
        $isOk = true;
        //On vérifie si le pseudo est libre
        if($user->checkDispoByFieldName(['username'])){
            $formErrors['username'] = 'Désolé, ce nom d\'utilisateur est déjà utilisé.';
            $isOk = false;
        }

        //Si c'est bon on update le pseudo
        if($isOk){
            var_dump($isOk);
            $user->id =$_SESSION['profile']['id'];
            $user->updateInfoUser();
            $_SESSION['profile']['username'] = $user->username;
            $formMessageSuccess = 'Votre pseudo à bien été modifié';
            // header('Location:profile.php');
            // exit;
        }
    }
}

//verification formulaire qui permet de changer mot de passe
if(isset($_POST['btn-updatePassword'])){
    $user = new user();
    $isPasswordOk = true;
    $user->mail = $_SESSION['profile']['mail'];
     //On récupère le hash de l'utilisateur
     $hash = $user->getUserPasswordHash();
     //Si le hash correspond au mot de passe saisi
    if(password_verify($_POST['oldPassword'], $hash)){
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
                $user->id = $_SESSION['profile']['id'];
                $user->updatepasswordUser();
                $formMessageSuccess = 'Votre mot de passe à bien été modifié';
            }else{
                $formErrors['password'] = $formErrors['verifyPassword'] = 'Les mots de passe saisis ne sont pas identiques.';
            }
        }
    }
}

//supprimer un utilisateur
if(isset($_POST['deletelign'])){
    $user = new user();
    $user->id = htmlspecialchars($_POST['recipient-name']);
    $user->deleteUserById();
    //On détruit la session de l'utilisateur qui supprime son compte
    session_destroy();
    //Et on le redirige vers l'accueil
    header('location:../index.php?action=deleteIsOk');
    exit();
}