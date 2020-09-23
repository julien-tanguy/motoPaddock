<?php
session_start();
require_once '../models/dataBase.php';
require_once '../models/race.php';
require_once '../models/pilots.php';
require_once '../models/score.php';
require_once '../controllers/adminAddResultController.php';
include 'menu.php';
include 'header.php';
?>
<?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
<section id="AddArticles" class="container AddForms">
    <div class="row justify-content-center">
        <?php if(isset($formMessageSuccess)){ ?>
            <div class="alert alert-success" role="alert">
                <?= $formMessageSuccess ?>
            </div>
        <?php } ?>
        <?php include 'navAdminAdd.php' ?>
        <form class="text-center col-12" method="POST" id="formArticle" enctype="multipart/form-data" action="adminAddResult.php">
        <h1 class=" text-center adminTitle">Ajouter un résultat</h1>
            <div class="form-group">
                <label for="race">Course : </label>
                <select class="form-control" name="race" id="race">
                    <option disabled selected>Selectionner une course</option>
                    <?php 
                    foreach($raceList as $nameRace){ 
                        ?><option <?= (isset($_POST['race']) && $_POST['race'] == $raceList) ? 'selected' : '' ?> value="<?php echo $nameRace->raceId ?>"><?= $nameRace->raceName; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['race'])) { ?>
                        <p class="errorForm"><?= $formErrors['race'] ?></p>
                <?php } ?>
            </div>
            <div class="form-group row">
                
                <?php 
                //Je stock les score dans un tableau associatif qui a pour clé associative l' ID du pilote
                foreach($pilotslist as $namePilot){ 
                ?><p class="col-6 text-left"><?= $namePilot->firstname . ' ' . $namePilot->lastname ?></p>
                    <select class="col-6" name="score[<?= $namePilot->idPilot  ?>]" id="score">
                    <option value="0">0 point</option>
                    <option value="25">25 points</option>
                    <option value="20">20 points</option>
                    <option value="16">16 points</option>
                    <option value="13">13 points</option>
                    <option value="11">11 points</option>
                    <option value="10">10 points</option>
                    <option value="9">9 points</option>
                    <option value="8">8 points</option>
                    <option value="7">7 points</option>
                    <option value="6">6 points</option>
                    <option value="5">5 points</option>
                    <option value="4">4 points</option>
                    <option value="3">3 points</option>
                    <option value="2">2 points</option>
                    <option value="1">1 point</option>
                </select><?php
                } ?>
            </div>
            <input class="btn btn-primary" type="submit" value="valider" name="addScore" />
        </form>
    </div>
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