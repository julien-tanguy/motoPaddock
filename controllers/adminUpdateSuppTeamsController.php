<?php
$team = new team;

/*Si le POST deletelign existe on rentre dans la condition */
if(isset($_POST['deletelign'])){
    //J'hydrate mon objet avec le recipient-name passé dans la modal de confirmation de suppression.
    $team->id = htmlspecialchars($_POST['recipient-name']);
    //j'appelle ma méthode deleteTeamById
    $team->deleteTeamById();
    $formMessageSuccess = 'LA TEAM A ETE SUPPRIMÉ';
}

$listTeamsByName = $team->displayListTeamPilots();