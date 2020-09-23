<?php
session_start();
require_once '../models/dataBase.php';
require_once '../models/dateRace.php';
require_once '../models/race.php';
require_once '../models/championship.php';
require_once '../controllers/adminAddRaceController.php';
include 'menu.php';
include 'header.php';
?>
<?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
<section id="AddTeams" class="container AddForms">
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
        <?php include 'navAdminAdd.php' ?>
        <!--------------------------------------------------------------form dateRace-->   
        <form class="text-center col-12" method="POST" id="formAddRace" enctype="multipart/form-data" action="adminAddRace.php">
            <h1 class=" text-center adminTitle">Ajouter un d'un week-end de course</h1>
            <div class="form-group">
                <label for="dateStart">Date de début :</label>
                <input id="dateStart" type="date" name="dateStart" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['dateStart']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['dateStart']) ? $_POST['dateStart'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['dateStart']) ? $formErrors['dateStart'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="dateEnd">Date de fin :</label>
                <input id="dateEnd" type="date" name="dateEnd" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['dateEnd']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['dateEnd']) ? $_POST['dateEnd'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['dateEnd']) ? $formErrors['dateEnd'] : '' ?></p>
            </div>        
            <div class="form-group">
                <label for="raceName">Nom du grand prix :</label>
                <input id="raceName" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['raceName']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['raceName']) ? $_POST['raceName'] : '' ?>" type="text" name="raceName" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['raceName']) ? $formErrors['raceName'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="circuitName">Nom du circuit :</label>
                <input id="circuitName" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['circuitName']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['circuitName']) ? $_POST['circuitName'] : '' ?>" type="text" name="circuitName" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['circuitName']) ? $formErrors['circuitName'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="circuitPhoto">Ajouter photo circuit :</label>
                <input id="circuitPhoto" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['circuitPhoto']) ? 'is-invalid' : 'is-valid') : '' ?>"  type="file" name="circuitPhoto" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['circuitPhoto']) ? $formErrors['circuitPhoto'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="championship">Championnat : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['championship']) ? 'is-invalid' : 'is-valid') : '' ?>" name="championship" id="championship">
                    <option disabled selected>Selectionner un championnat</option>
                    <?php 
                    foreach($championshipList as $championship){ 
                        ?><option <?= (isset($_POST['championship']) && $_POST['championship'] == $championship) ? 'selected' : '' ?> value="<?php echo $championship->id ?>"><?= $championship->name; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['championship'])) { ?>
                        <p class="errorForm"><?= $formErrors['championship'] ?></p>
                <?php } ?>
            </div>
            
            <input type="submit" class="btn btn-primary" name="addRace" value="Ajouter"></input>
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