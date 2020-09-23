<?php
$regexpDate = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
$users = new user;
$usersList = $users->usersList();
$articles = new article;
$articlesList = $articles->articlesList();
//------------------------------------------------- FORM ARTICLE
if(isset($_POST['addArticle'])){
    $photoArticle = new photoPresentation();
    $article = new article();
    $linkConnexion = new connexion();

    if (!empty($_POST['title'])) {
        $article->title = htmlspecialchars($_POST['title']);
    }else {
        $formErrors['title'] = 'Veuillez entrer le tittre de l\'article.';
    }

    if (!empty($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $fileInfos = pathinfo($_FILES['photo']['name']);
        $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
            if (in_array($fileInfos['extension'], $fileExtension)) {
                $path = '../assets/img/articles/';
            $date = date('Y-m-d_H-i-s');
            $fileNewName = $article->title . '_articlesPresentation_' . $date;
            $articlePicture = $path . $fileNewName . '.' . $fileInfos['extension'];
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $articlePicture)) {
                    chmod($articlePicture, 0644);
                    $photoArticle->link = $articlePicture;
                } else {
                    $formErrors['photo'] = 'Votre fichier ne s\'est pas téléversé correctement';
                }
            } else {
            $formErrors['photo'] = 'Votre fichier n\'est pas du format attendu';
            }
        } else {
        $formErrors['photo'] = 'Veuillez selectionner un fichier';
    }
    
    if (!empty($_POST['content'])) {
        $article->content = htmlspecialchars($_POST['content']);
    }else {
        $formErrors['content'] = 'Veuillez entrer le contenu de l\'article.';
    }
    if (!empty($_POST['publishDate'])) {
        if (filter_var($_POST['publishDate'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpDate)))) {
            //on explode $_post['birthdate] car checkdate verifie chaque partie differement
            $dateExplode = explode('-', $_POST['publishDate']);
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $article->publicationDate = $_POST['publishDate'];
            }else{
                $formErrors['publishDate'] = 'Veuillez renseigner une date au format : jj/mm/aaaa.';
            }       
        }else {
            $formErrors['publishDate'] = 'La date de publication n\'est pas valide.';
        }
    }else {
        $formErrors['publishDate'] = 'Veuillez entrer la date de publication.';
    }
    if (!empty($_POST['editDate'])) {
        $article->lastEditDate = htmlspecialchars($_POST['editDate']);      
    }else {
        $formErrors['editDate'] = 'Veuillez entrer la date de derniere modification au format YYYY/mm/dd hh:mm:ss';
    }
    if (!empty($_POST['category'])) {
        $article->id_ap29f_category = htmlspecialchars($_POST['category']);      
    }else {
        $formErrors['category'] = 'Veuillez choisir la catégorie dans la liste déroulante.';
    }
    if (!empty($_POST['user'])) {
        $article->id_ap29f_users = htmlspecialchars($_POST['user']);      
    }else {
        $formErrors['user'] = 'Veuillez choisir l\'auteur dans la liste déroulante.';
    }
   
    if(empty($formErrors)){
        if(!$article->checkArticlesExistByTitle()){
            try {
                $article->beginTransaction();
                $photoArticle->addPhotoPresentation();
                $linkConnexion->id_ap29f_photos = $article->getLastInsertId();
                $article->addArticle();
                $linkConnexion->id_ap29f_articles = $article->getLastInsertId();
                $linkConnexion->addConnexion();
                //sauvegarde le résultat avec commit
                $article->commit();
                $formMessageSuccess = 'L\'ARTICLE A BIEN ETE ENREGISTRÉ';
            }catch(Exception $e) {
                $article->rollBack();
                $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
            }
        }else {
            $formMessageFail = 'ERREUR! L\'ARTICLE EXISTE DÉJÀ.';
        }
    }
}

