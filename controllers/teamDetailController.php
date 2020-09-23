<?php
if($_GET['id']){
    $teams = new team;
    $teams->id = $_GET['id'];
    $pilots = new pilot();
    $pilots->id = $_GET['id'];
    if($teams->checkTeamsExistById()){
        $infosTeam = $teams->detailTeams();
        $pilotsByTeam = $pilots->displayPilotsDetailTeam();
    }else{
        $contentNotExist = 'OUPS... CETTE PAGE N\'EXISTE PAS!';
    }
    
}else {
    Header('location: ../index.php');
}
