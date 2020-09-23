<?php
$race = new race();
$raceToDelete = new dateRace();

if(isset($_POST['deletelign'])){
    $raceToDelete->id = htmlspecialchars($_POST['recipient-name']);
    $raceToDelete->deleteRaceByIdDateRace();
    $formMessageSuccess = 'LA COURSE A ETE SUPPRIMÉE';
}

$listRacesByName = $race->displayListNameRaces();