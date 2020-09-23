<!--header + menu-->
<?php
session_start();
require_once '../models/dataBase.php'; 
require_once '../models/pilots.php';
require_once '../models/teams.php';
require_once '../controllers/adminAddPilotsController.php';
include 'menu.php';
include 'header.php';
?>
<?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
<section id="AddPilots" class="container AddForms">
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
        <?php include 'navAdminAdd.php' ?>
        <!--------------------------------------------------------------form pilot-->
        <form class="text-center col-12" method="POST" id="formPilot" enctype="multipart/form-data" action="adminAddPilots.php">
        <h1 class=" text-center adminTitle">Ajouter un pilote</h1>
            <div class="form-group">
                <label for="file">photo du pilotes : </label>
                <input class="form-control" type="file" name="file" id="file" />
            </div>
            <!--message d'erreur-->
            <p class="errorForm"><?= isset($formErrors['file']) ? $formErrors['file'] : '' ?></p>
            <div class="form-group">
                <label for="lastname">Nom :</label>
                <input id="lastname" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['lastname']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>" type="text" name="lastname" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['lastname']) ? $formErrors['lastname'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="firstname">Prénom :</label>
                <input id="firstname" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['firstname']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>" type="text" name="firstname" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['firstname']) ? $formErrors['firstname'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="birthdate">Date de naissance :</label>
                <input id="birthdate" type="date" name="birthdate" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['birthdate']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['birthdate']) ? $_POST['birthdate'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['birthdate']) ? $formErrors['birthdate'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="number">numéro de course :</label>
                <input id="number" type="number" name="number" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['number']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['number']) ? $_POST['number'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['number']) ? $formErrors['number'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="country">Pays de naissance : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['country']) ? 'is-invalid' : 'is-valid') : '' ?>" name="country" id="country">
                    <option disabled selected>Selectionner un pays</option>
                    <?php 
                    foreach($countries as $index => $countrie){ 
                        ?><option <?= (isset($_POST['country']) && $_POST['country'] == $countrie) ? 'selected' : '' ?> value="<?php echo $countrie ?>"><?= $countrie; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['country'])) { ?>
                        <p class="errorForm"><?= $formErrors['country'] ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="size">taille :</label>
                <input id="size" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['size']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['size']) ? $_POST['size'] : '' ?>" type="text" name="size" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['size']) ? $formErrors['size'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="weight">poid :</label>
                <input id="weight" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['weight']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['weight']) ? $_POST['weight'] : '' ?>" type="text" name="weight" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['weight']) ? $formErrors['weight'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="description">description :</label>
                <textarea id="description" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['description']) ? 'is-invalid' : 'is-valid') : '' ?>" name="description"><?= isset($_POST['description']) ? $_POST['description'] : '' ?></textarea>
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['description']) ? $formErrors['description'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="pilotTeam">Team : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['pilotTeam']) ? 'is-invalid' : 'is-valid') : '' ?>" name="pilotTeam" id="pilotTeam">
                    <option disabled selected>Selectionner team</option>
                    <?php 
                    foreach($teamsList as $team){ 
                        ?><option <?= (isset($_POST['pilotTeam']) && $_POST['pilotTeam'] == $team) ? 'selected' : '' ?> value="<?php echo $team->id ?>"><?= $team->name; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['pilotTeam'])) { ?>
                        <p class="errorForm"><?= $formErrors['pilotTeam'] ?></p>
                <?php } ?>
            </div>
            <input type="submit" class="btn btn-primary" name="addPilot" value="Ajouter"></input>
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