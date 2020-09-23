<?php
$regexpTeamName = '/^[0-9a-zA-ZÀ-ÖØ-öø-ÿ\'\ \-\_\,]+$/';
$formErrors = array();
if (isset($_GET['id'])){
    $team = new team;
    $team->id = htmlspecialchars($_GET['id']);
    $teamUpdate = $team->detailTeams();
}
if(isset($_POST['updateTeam'])){
    //instancier notre requete de la class patients
    if (!empty($_POST['teamName'])) {
        //si une valeur existe, verifier qu'elle soit en accord avec la regexp
        if (filter_var($_POST['teamName'], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $regexpTeamName)))) {
            /*Si toutes les conditions sont réspéctées, j'hydrate mon objet avec la valeur envoyée 
            en le sécurisant avec htmlspecialchars.*/
            $team->name = htmlspecialchars($_POST['teamName']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
        }else {
            $formErrors['teamName'] = 'Le Nom de l\'équipe n\'est pas valide.';
        }
        //si aucune valeur n'est entrée, afficher le message d'erreur suivant :
    }else {
        $formErrors['teamName'] = 'Veuillez entrer le Nom de l\'équipe.';
    }
    if (!empty($_POST['teamDescription'])) {
        $team->description = htmlspecialchars($_POST['teamDescription']);
        //si une valeur existe mais qu'elle est non conforme a la regexp, afficher le message d'erreur suivant : 
    }else {
        $formErrors['teamDescription'] = 'Veuillez entrer une description.';
    }
    if(empty($formErrors)){
        //on appelle la methode de notre updatePilot pour modifier un pilote dans la base de données
        if($team->updateTeam()){
            $formMessageSuccess = 'LE TEAM A BIEN ETE MODIFIÉ';
        }else {
            $formMessageFail = 'UNE ERREUR EST SURVENUE PENDANT L\'ENREGISTREMENT. VEUILLEZ CONTACTER LE SERVICE INFORMATIQUE.';
        } 
    }
}