<?php
session_start();
require_once '../models/dataBase.php'; 
require_once '../models/race.php';
require_once '../models/dateRace.php';
require_once '../controllers/adminUpdateSuppRacesController.php';
include 'menu.php';
include 'header.php'; 
?>
<?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
<section class="container updateMenu">
    <div class="row justify-content-center">
        <?php if(isset($formMessageSuccess)){ ?>
            <div class="alert alert-success" role="alert">
                <?= $formMessageSuccess ?>
            </div>
        <?php } ?>
        <?php include 'navAdminUpDel.php' ?>
        <table class="text-center table table-striped col-md-10 col-sm-12">
            <thead>
                <tr>
                    <th>dates de la course</th>
                    <th>grand prix</th>
                    <th>championnat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($listRacesByName as $raceByName){ ?>
                <tr>
                    <td><?= $raceByName->dateFrStart . ' - ' . $raceByName->dateFrEnd ?></td>
                    <td><?= $raceByName->raceName ?></td>
                    <td><?= $raceByName->champName ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm "><a class="text-white" href="updateRace.php?id=<?= $raceByName->raceDate ?>"><i class="fas fa-pen"></i></a></button>
                        <button type="button" class="btn btn-danger btn-sm "><i class="fas fa-trash" data-toggle="modal" data-target="#deleteModal" data-id="<?= $raceByName->raceDate?>"></i></button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- la modale de suppression-->
    <?php include 'modalSuppression.php' ?>
</section>
<?php }else{ ?>
    <section class="contentNotExist container m-auto">
        <div class="view m-auto">
            <div class="mask flex-center rgba-stylish-strong">
                <p class="white-text">CETTE PAGE N'EST PAS ACCESSIBLE</p>
            </div>
            <img src="../assets/img/content/contentNotExist.jpg" class="img-fluid" alt="illustration not exist">
        </div>
    </section>
<?php } ?>
<?php include 'footer.php' ?>