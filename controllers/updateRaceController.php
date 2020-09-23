<?php
$regexpName = '/^[A-ÿ\'\ \-\_]+$/'; 
$regexpDate = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
if (isset($_GET['id'])){
    $updatedate = new dateRace();
    $updatedate->id = htmlspecialchars($_GET['id']);
    $dateRace = new race();
    $dateRace->id = htmlspecialchars($_GET['id']);
    $displayDatesRace = $dateRace->displayWeekEn();

}
if(isset($_POST['updateDateRace'])){
    //instancier notre requete de la class patients
    if (!empty($_POST['dateStart'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['dateStart'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpDate)))) {
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $updatedate->dateStart = $_POST['dateStart'];
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
            if(checkdate($dateExplode[1],$dateExplode[2],$dateExplode[0])){
                $updatedate->dateEnd = $_POST['dateEnd'];
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
    if(empty($formErrors)){
        //on appelle la methode de notre addTeam pour creer un nouveau team dans la base de données
        if($updatedate->updateDateRace()){
            $formMessageSuccess = 'LES DATES DU WEEK-END DE COURSE ONT BIEN ETE MODIFIÉ';
        }else {
            $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
        } 
    }
}