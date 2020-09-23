<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/dateRace.php';
require_once '../models/race.php';
require_once '../controllers/updateRaceController.php';
include 'menu.php';
include 'header.php';
?>
<?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
<section class="container updateForm">
    <div class="row justify-content-center">
        <?php if(isset($formMessageSuccess)){ ?>
            <div class="alert alert-success" role="alert">
                <?= $formMessageSuccess ?>
            </div>
        <?php } ?>
        <?php if(isset($formMessageFail)){ ?>
            <div class="alert alert-danger" role="alert">
                <?= $formMessageFail ?>
            </div>
        <?php } ?>
        <!--------------------------------------------------------------nav admin-->
        <?php include 'navAdminUpDel.php' ?>
        <!-- action=  $_SERVER['REQUEST_URI'] renvoie vers le meme url -->
        <form class="text-center col-12" method="POST" id="formDateRace" action="<?= $_SERVER['REQUEST_URI'] ?>">
            <h1 class=" text-center adminTitle">modifier les dates d'un week-end de course</h1>
            <div class="form-group">
                <label for="dateStart">Date de début :</label>
                <input id="dateStart" type="date" name="dateStart" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['dateStart']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['dateStart']) ? $_POST['dateStart'] : $displayDatesRace->dateStart ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['dateStart']) ? $formErrors['dateStart'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="dateEnd">Date de fin :</label>
                <input id="dateEnd" type="date" name="dateEnd" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['dateEnd']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['dateEnd']) ? $_POST['dateEnd'] : $displayDatesRace->dateEnd ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['dateEnd']) ? $formErrors['dateEnd'] : '' ?></p>
            </div>
            <input type="submit" class="btn btn-primary" name="updateDateRace" value="Modifier"></input>
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