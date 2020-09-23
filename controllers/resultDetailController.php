<?php
if(!empty($_GET['id'])){
    $result = new score();
    $result->id = $_GET['id'];

    $race = new race();
    $race->id = $_GET['id'];

    $raceName = $race->displayRaceNameById();
    $infosResult = $result->displayResultById();
}else {
    Header('location: ../index.php');
}