<?php
$regexpName = '/^[A-ÿ\'\ \-\_]+$/'; 
$regexpDate = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
//------------------------------------------------- FORM addRace 
$championshipChoice = new championship();
$championshipList = $championshipChoice->championships();

if(isset($_POST['addRace'])){
    $datesRaces = new dateRace();
    if (!empty($_POST['dateStart'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['dateStart'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpDate)))) {
            $dateExplode = explode('-', $_POST['dateStart']);
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $datesRaces->dateStart = $_POST['dateStart'];
            }else{
                $formErrors['dateStart'] = 'Veuillez renseigner une date au format : jj/mm/aaaa.';
            }
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['dateStart'] = 'La date n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['dateStart'] = 'Veuillez entrer une date de début.';
    }
    if (!empty($_POST['dateEnd'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['dateEnd'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpDate)))) {
            $dateExplode = explode('-', $_POST['dateEnd']);
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $datesRaces->dateEnd = $_POST['dateEnd'];
            }else{
                $formErrors['dateEnd'] = 'Veuillez renseigner une date au format : jj/mm/aaaa.';
            }
            
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['dateEnd'] = 'La date n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['dateEnd'] = 'Veuillez entrer une date de fin.';
    }

    $race = new race();
    if (!empty($_POST['raceName'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['raceName'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpName)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $race->name = htmlspecialchars($_POST['raceName']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['raceName'] = 'Le nom n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['raceName'] = 'Veuillez entrer le nom du grand prix.';
    }
    if (!empty($_POST['circuitName'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['circuitName'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpName)))) {
            //si tout est ok, stocker la valeur dans dans une variable
            $race->circuit = htmlspecialchars($_POST['circuitName']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['circuitName'] = 'Le nom du circuit n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['circuitName'] = 'Veuillez entrer le nom du circuit.';
    }

    // On verifie que le fichier a bien été envoyé.
    if (!empty($_FILES['circuitPhoto']) && $_FILES['circuitPhoto']['error'] == 0) {
        // On stock dans $fileInfos les informations concernant le chemin du fichier.
        $fileInfos = pathinfo($_FILES['circuitPhoto']['name']);
        // On crée un tableau contenant les extensions autorisées.
        $fileExtension = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];
        // On verifie si l'extension de notre fichier est dans le tableau des extension autorisées.
            if (in_array($fileInfos['extension'], $fileExtension)) {
            //On définit le chemin vers lequel uploader le fichier
                $path = '../assets/img/circuits/';
            //On crée une date pour différencier les fichiers
            $date = date('Y-m-d_H-i-s');
            //On crée le nouveau nom du fichier (celui qu'il aura une fois uploadé)
            $fileNewName = $race->name . '_picture_' . $date;
            //On stocke dans une variable le chemin complet du fichier (chemin + nouveau nom + extension une fois uploadé) Attention : ne pas oublier le point
            $racePicture = $path . $fileNewName . '.' . $fileInfos['extension'];
            //move_uploaded_files : déplace le fichier depuis son emplacement temporaire ($_FILES['file']['tmp_name']) vers son emplacement définitif ($fileFullPath)
                if (move_uploaded_file($_FILES['circuitPhoto']['tmp_name'], $racePicture)) {
                    //On définit les droits du fichiers uploadé (Ici : écriture et lecture pour l'utilisateur apache, lecture uniquement pour le groupe et tout le monde)
                    chmod($racePicture, 0644);
                    $race->photo = $racePicture;
                } else {
                    $formErrors['circuitPhoto'] = 'Votre fichier ne s\'est pas téléversé correctement';
                }
            } else {
            $formErrors['circuitPhoto'] = 'Votre fichier n\'est pas du format attendu';
            }
        } else {
        $formErrors['circuitPhoto'] = 'Veuillez selectionner un fichier';
    }
    
    if (!empty($_POST['championship'])) {
        $race->id_ap29f_championship = htmlspecialchars($_POST['championship']);
    }else {
        $formErrors['championship'] = 'Veuillez choisir un championnat dans la liste déroulante.';
    }

    if(empty($formErrors)){
        if(!$race->checkRacesExist()){
            try {
                $race->beginTransaction();
                $datesRaces->addDateRace();
                $race->id_ap29f_dateRace = $race->getLastInsertId();
                $race->addRace();
                //sauvegarde le résultat avec commit
                $race->commit();
                $formMessageSuccess = 'LA COURSE A BIEN ETE ENREGISTRÉE';
            }catch(Exception $e) {
                $race->rollBack();
                $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
            }
        }else {
            $formMessageFail = 'ERREUR! LA COURSE EXISTE DÉJÀ.';
        }
    }
}