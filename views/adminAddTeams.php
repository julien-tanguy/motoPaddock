<?php
session_start(); 
require_once '../models/dataBase.php';
require_once '../models/teams.php';
require_once '../models/category.php';
require_once '../models/photosTeams.php';
require_once '../controllers/adminAddTeamsController.php';
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
        <!--form Teams-->
        <form class="text-center col-12" method="POST" id="formTeams" enctype="multipart/form-data" action="adminAddTeams.php">
        <h1 class="text-center adminTitle">Ajouter une team</h1>
            <div class="form-group">
                <label for="teamCategory">Catégorie : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamCategory']) ? 'is-invalid' : 'is-valid') : '' ?>" name="teamCategory" id="teamCategory">
                    <option disabled selected>Selectionner une catégorie</option>
                    <?php 
                    foreach($categoriesList as $categoryList){ 
                        ?><option <?= (isset($_POST['teamCategory']) && $_POST['teamCategory'] == $categoryList) ? 'selected' : '' ?> value="<?php echo $categoryList->id ?>"><?= $categoryList->name; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['teamCategory'])) { ?>
                        <p class="errorForm"><?= $formErrors['teamCategory'] ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="teamName">Nom équipe :</label>
                <input id="teamName" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamName']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['teamName']) ? $_POST['teamName'] : '' ?>" type="text" name="teamName" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['teamName']) ? $formErrors['teamName'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="photoCard">Ajouter une petite photo de presentation :</label>
                <input id="photoCard" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['photoCard']) ? 'is-invalid' : 'is-valid') : '' ?>" type="file" name="photoCard" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['photoCard']) ? $formErrors['photoCard'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="photoResume">Ajouter une grande photo de résumé :</label>
                <input id="photoResume" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['photoResume']) ? 'is-invalid' : 'is-valid') : '' ?>" type="file" name="photoResume" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['photoResume']) ? $formErrors['photoResume'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="teamDescription">Description :</label>
                <textarea id="teamDescription" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamDescription']) ? 'is-invalid' : 'is-valid') : '' ?>" name="teamDescription" ><?= isset($_POST['teamDescription']) ? $_POST['teamDescription'] : '' ?></textarea>
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['teamDescription']) ? $formErrors['teamDescription'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="teamLogo">Image du logo du team :</label>
                <input id="teamLogo" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamLogo']) ? 'is-invalid' : 'is-valid') : '' ?>" type="file" name="teamLogo" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['teamLogo']) ? $formErrors['teamLogo'] : '' ?></p>
            </div>
            <input type="submit" class="btn btn-primary" name="addTeam" value="Ajouter"/>
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