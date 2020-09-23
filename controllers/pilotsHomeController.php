<?php
//AJOUTER UNE VERIFICATION POUR S'ASSURERE QUE $ID ESXISTE DANS LA DB 
if(isset($_GET['id'])){
    $cardPilot = new pilot;
    $cardPilot->id = $_GET['id'];
    $cardsPilots = $cardPilot->displayCardsPilots();
}else {
    Header('location: ../index.php');
    exit;
}

         
