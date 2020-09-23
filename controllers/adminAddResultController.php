<?php
$race = new race;
$raceList = $race->displayListRace();

$pilot = new pilot();
$pilotslist = $pilot->displayListPilotsByCategory();

if(isset($_POST['addScore'])){
    $score = new score();
    if (!empty($_POST['race'])) {
        foreach ($_POST['score'] as $key => $value){
            $score->id_ap29f_race = htmlspecialchars($_POST['race']); 
            $score->id_ap29f_pilots = htmlspecialchars($key); 
            $score->value = htmlspecialchars($value);
            $score->addScore();
            $formMessageSuccess = 'les scores ont étés enregistrés';
        }
    }else {
        $formErrors['race'] = 'Veuillez choisir un grand prix dans la liste déroulante.';
    }
}