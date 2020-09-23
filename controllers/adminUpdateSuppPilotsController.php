<?php
$pilot = new pilot;

if(isset($_POST['deletelign'])){
    $pilot->id = htmlspecialchars($_POST['recipient-name']);
    $pilot->deletePilotById();
    $formMessageSuccess = 'LE PILOTE A ETE SUPPRIME';
}

$listPilotsByName = $pilot->displayListNamePilots();


