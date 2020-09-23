<?php
//Je défini un tableau pour y stocker les messages d'erreurs
$formErrors = array();
/*la regexp regexpTeamName vérifie que le nom de l'équipe ne contient
pas autres-chose que des chiffres de 0 à 9, des lettres en majuscule avec ou sans accents,
des espaces et les seuls caractéres spéciaux accéptés (' et -)*/
$regexpTeamName = '/^[0-9a-zA-ZÀ-ÖØ-öø-ÿ\'\ \-]+$/';
$teams = new team();
$teamsList = $teams->teamsList();
$categories = new category;
$categoriesList = $categories->categoriesList();
//------------------------------------------------- FORM ADDTEAMS
// Au click sur le bouton du formulaire addTeam si une valeur existe on rentre dans la condition
if(isset($_POST['addTeam'])){
    $photos = new photosTeam();
//J'instancie un nouvelle objet PDO de la class team
    $team = new team();

    if (!empty($_POST['teamCategory'])) {
        $team->id_ap29f_category = htmlspecialchars($_POST['teamCategory']);
    }else {
        $formErrors['teamCategory'] = 'Veuillez choisir la catégorie de l\'équipe dans la liste déroulante.';
    }
/* Je vérifie qu'une valeur existe et n'est pas vide dans le champ teamName.
 Si ce champs est vide, une erreur s'affiche en dessous de celui-ci pour spécifier
 à l'utilisateur qu'il doit renseigner une valeur.*/
    if (!empty($_POST['teamName'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['teamName'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpTeamName)))) {
            /*Si toutes les conditions sont réspéctées, j'hydrate mon objet avec la valeur envoyée 
            en le sécurisant avec htmlspecialchars.
            htmlspecialchars() remplace tous ces caractères par leur équivalent dans la chaîne string.
            Si vous avez besoin que toutes les sous-chaînes en entrée qui sont associées à des entités nommées soient transformées,
            utilisez la fonction htmlentities(). */
            $team->name = htmlspecialchars($_POST['teamName']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['teamName'] = 'Le Nom de l\'équipe n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['teamName'] = 'Veuillez entrer le Nom de l\'équipe.';
    }

    // On verifie que le fichier a bien été envoyé.
    if (!empty($_FILES['photoCard']) && $_FILES['photoCard']['error'] == 0) {
    // On stock dans $fileInfos les informations concernant le chemin du fichier.
    $fileInfos = pathinfo($_FILES['photoCard']['name']);
    // On crée un tableau contenant les extensions autorisées.
    $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
    // On verifie si l'extension de notre fichier est dans le tableau des extension autorisées.
        if (in_array($fileInfos['extension'], $fileExtension)) {
        //On définit le chemin vers lequel uploader le fichier.
            if($team->id_ap29f_category == 1){
                $path = '../assets/img/photos-teams/moto gp/';
            }else if ($team->id_ap29f_category == 2){
                $path = '../assets/img/photos-teams/moto 2/';
            }else {
                $path = '../assets/img/photos-teams/moto 3/';
            }
        //On crée une date pour différencier les fichiers
        $date = date('Y-m-d_H-i-s');
        //On crée le nouveau nom du fichier (celui qu'il aura une fois uploadé)
        $fileNewName = $team->name . '_card_' . $date;
        //On stocke dans une variable le chemin complet du fichier (chemin + nouveau nom + extension une fois uploadé) Attention : ne pas oublier le point
        $teamPhoto = $path . $fileNewName . '.' . $fileInfos['extension'];
        //move_uploaded_files : déplace le fichier depuis son emplacement temporaire ($_FILES['file']['tmp_name']) vers son emplacement définitif ($fileFullPath)
            if (move_uploaded_file($_FILES['photoCard']['tmp_name'], $teamPhoto)) {
                //On définit les droits du fichiers uploadé (Ici : écriture et lecture pour l'utilisateur apache, lecture uniquement pour le groupe et tout le monde)
                chmod($teamPhoto, 0644);
                $photos->photoCard = $teamPhoto;
            } else {
                $formErrors['photoCard'] = 'Votre fichier ne s\'est pas téléversé correctement';
            }
        } else {
        $formErrors['photoCard'] = 'Votre fichier n\'est pas du format attendu';
        }
    } else {
        $formErrors['photoCard'] = 'Veuillez selectionner un fichier';
    }

    // On verifie que le fichier a bien été envoyé.
    if (!empty($_FILES['photoResume']) && $_FILES['photoResume']['error'] == 0) {
    // On stock dans $fileInfos les informations concernant le chemin du fichier.
    $fileInfos = pathinfo($_FILES['photoResume']['name']);
    // On crée un tableau contenant les extensions autorisées.
    $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
    // On verifie si l'extension de notre fichier est dans le tableau des extension autorisées.
        if (in_array($fileInfos['extension'], $fileExtension)) {
        //On définit le chemin vers lequel uploader le fichier
            if($team->id_ap29f_category == 1){
                $path = '../assets/img/team-resume/moto gp/';
            }else if ($team->id_ap29f_category == 2){
                $path = '../assets/img/team-resume/moto 2/';
            }else {
                $path = '../assets/img/team-resume/moto 3/';
            }
        //On crée une date pour différencier les fichiers
        $date = date('Y-m-d_H-i-s');
        //On crée le nouveau nom du fichier (celui qu'il aura une fois uploadé)
        $fileNewName = $team->name . '_detail_' . $date;
        //On stocke dans une variable le chemin complet du fichier (chemin + nouveau nom + extension une fois uploadé) Attention : ne pas oublier le point
        $teamPhotoResume = $path . $fileNewName . '.' . $fileInfos['extension'];
        //move_uploaded_files : déplace le fichier depuis son emplacement temporaire ($_FILES['file']['tmp_name']) vers son emplacement définitif ($fileFullPath)
            if (move_uploaded_file($_FILES['photoResume']['tmp_name'], $teamPhotoResume)) {
                //On définit les droits du fichiers uploadé (Ici : écriture et lecture pour l'utilisateur apache, lecture uniquement pour le groupe et tout le monde)
                chmod($teamPhotoResume, 0644);
                $photos->photoResume = $teamPhotoResume;
            } else {
                $formErrors['photoResume'] = 'Votre fichier ne s\'est pas téléversé correctement';
            }
        } else {
        $formErrors['photoResume'] = 'Votre fichier n\'est pas du format attendu';
        }
    } else {
    $formErrors['photoResume'] = 'Veuillez selectionner un fichier';
    }
    
    if (!empty($_POST['teamDescription'])) {
        $team->description = htmlspecialchars($_POST['teamDescription']);
    }else {
        $formErrors['teamDescription'] = 'Veuillez entrer une description.';
    }

    if (!empty($_FILES['teamLogo']) && $_FILES['teamLogo']['error'] == 0) {
        // On stock dans $fileInfos les informations concernant le chemin du fichier.
        $fileInfos = pathinfo($_FILES['teamLogo']['name']);
        // On crée un tableau contenant les extensions autorisées.
        $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
        // On verifie si l'extension de notre fichier est dans le tableau des extension autorisées.
            if (in_array($fileInfos['extension'], $fileExtension)) {
            //On définit le chemin vers lequel uploader le fichier
                $path = '../assets/img/logo-team/';
            //On crée une date pour différencier les fichiers
            $date = date('Y-m-d_H-i-s');
            //On crée le nouveau nom du fichier (celui qu'il aura une fois uploadé)
            $fileNewName = $team->name . '_logo_' . $date;
            //On stocke dans une variable le chemin complet du fichier (chemin + nouveau nom + extension une fois uploadé) Attention : ne pas oublier le point
            $logoPhoto = $path . $fileNewName . '.' . $fileInfos['extension'];
            //move_uploaded_files : déplace le fichier depuis son emplacement temporaire ($_FILES['file']['tmp_name']) vers son emplacement définitif ($fileFullPath)
                if (move_uploaded_file($_FILES['teamLogo']['tmp_name'], $logoPhoto)) {
                    //On définit les droits du fichiers uploadé (Ici : écriture et lecture pour l'utilisateur apache, lecture uniquement pour le groupe et tout le monde)
                    chmod($logoPhoto, 0644);
                    $team->logoTeam = $logoPhoto;
                } else {
                    $formErrors['teamLogo'] = 'Votre fichier ne s\'est pas téléversé correctement';
                }
            } else {
            $formErrors['teamLogo'] = 'Votre fichier n\'est pas du format attendu';
            }
        } else {
        $formErrors['teamLogo'] = 'Veuillez selectionner un fichier';
        }
    /*Après toutes les vérifications, si le tableau formErrors est vide.
    Je vérifie si l’équipe existe déjà grâce a la méthode checkTeamsExist.
    Si la méthode renvoie 0, l'équipe n'existe pas je peut commencer ma transaction. */
    if(empty($formErrors)){
        if(!$team->checkTeamsExist()){
            /*Try sert à faciliter la saisie d'une exception potentielle.
            Catch permet d'attrapper cette exception. */
            try {
            /*Une transaction permet d'inserer des valeurs dans plusieurs tables en meme temps, ici dans les tables team et photosTeam. */
                $team->beginTransaction();
                //J'appelle la méthode addTeam.
                $team->addTeam();
                //je récupere le dernier id inserer et hydrate la clé étrangére de mon objet photos.
                $photos->id_ap29f_teams = $team->getLastInsertId();
                //J'appelle la méthode addphotos.
                $photos->addPhotos();
                //Je sauvegarde le résultat avec commit.
                $team->commit();
                //J'informe l'utilisateur du succés de la transaction.
                $formMessageSuccess = 'L\'ÉQUIPE A BIEN ETE ENREGISTRÉE';
            }catch(Exception $e) {
                //En cas d'erreur, j'annule une transaction et restaure l'autocommit.
                $team->rollBack();
                //J'informe l'utilisateur de l'echec de la transaction.
                $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
            }
        }else {
            //J'informe l'utilisateur que l'équipe existe déjà.
            $formMessageFail = 'ERREUR! L\'ÉQUIPE EXISTE DÉJÀ.';
        }
        
    }
}







