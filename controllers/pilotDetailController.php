<?php
if(!empty($_GET['id'])){
    $pilot = new pilot();
    $pilot->id = $_GET['id'];
    if($pilot->checkPilotExistById()){
        $infosPilot = $pilot->detailPilots();
    }else{
        $contentNotExist = 'OUPS... CETTE PAGE N\'EXISTE PAS!';
    }
}else {
    Header('location: ../index.php');
}
