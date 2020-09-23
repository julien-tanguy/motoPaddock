<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/teams.php';
require_once '../models/pilots.php';
require_once '../controllers/teamDetailController.php';
include 'menu.php'; 
?>
<?php if(!isset($contentNotExist)){ ?>
    <section id="teamDetail" class="container-fluid">
        <div class="row team-resume">
            <img src="<?= $infosTeam->photoResume ?>" alt="team-img" class="resume-img col-12">
            <h1 class="text-center col-12 nameTeam"><img src="<?= $infosTeam->logoTeam ?>" alt="team-logo" class="logo" /> | <?= $infosTeam->teamName ?></h1>
            <p class="text-center col-12"> Pilotes :</br>
                <?php foreach($pilotsByTeam as $pilotDetail) { echo $pilotDetail->number . ' | ' . $pilotDetail->firstname . ' ' . $pilotDetail->lastname ?></br> <?php } ?>
            </p>
        </div>
        <div class="container"> 
            <div class="row teamDescription">
                <p class="col"><?= html_entity_decode($infosTeam->teamDescription) ?></p>
            </div>
        </div>
    </section>
<?php }else{ ?>
    <section class="contentNotExist container m-auto">
        <div class="view m-auto">
            <div class="mask flex-center rgba-stylish-strong">
                <p class="white-text"><?= $contentNotExist ?></p>
            </div>
            <img src="../assets/img/content/contentNotExist.jpg" class="img-fluid" alt="illustration not exist">
        </div>
    </section>
<?php } ?>
<!--footer-->
<?php include 'footer.php' ?>