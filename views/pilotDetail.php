<?php
session_start();
require_once '../models/dataBase.php';  
require_once '../models/pilots.php';
require_once '../controllers/pilotDetailController.php';
include 'menu.php';
include 'header.php'; 
?>
<!--body pilotDetail page-->
<?php if(!isset($contentNotExist)){ ?>
    <section id="pilotDetail" class="container">
        <div class="row">
            <img src="<?= $infosPilot->photo ?>" alt="pilot-img" class="col-12 col-md-6">
            <div class="col-12 col-md-6 identity-pilot">
                <ul>
                    <li>Nom : <?= $infosPilot->firstname ?></li>
                    <li>Numero :<?= $infosPilot->number ?></li>
                    <li>Team : <?= $infosPilot->teamName ?></li>
                    <li>Pays : <?= $infosPilot->country ?></li>
                    <li>Naissance : <?= $infosPilot->birthDateFr ?></li>
                    <li>Taille : <?= $infosPilot->size ?></li>
                    <li>Poids : <?= $infosPilot->weight ?></li>
                </ul>
            </div>
            <div class="col-12">
                <p><?= html_entity_decode($infosPilot->description) ?></p>
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


