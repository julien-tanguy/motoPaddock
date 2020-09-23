<?php
if(!empty($_GET['id'])){
    $ladder = new score();
    $ladder->id = $_GET['id'];
    $infosLadder = $ladder->displayGeneralLadder();
}else {
    Header('location: ../index.php');
}