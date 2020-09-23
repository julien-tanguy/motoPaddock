<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/teams.php';
require_once '../controllers/updateTeamController.php';
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
        <!--form teams-->
        <form class="text-center col-12" method="POST" id="formTeams" action="updateTeam.php?id=<?= $team->id ?>">
        <h1 class="text-center adminTitle">Modifier une team</h1>
            <div class="form-group">
                <label for="teamName">Nom équipe :</label>
                <input id="teamName" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamName']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['teamName']) ? $_POST['teamName'] : $teamUpdate->teamName ?>" type="text" name="teamName" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['teamName']) ? $formErrors['teamName'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="teamDescription">Description :</label>
                <textarea id="teamDescription" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['teamDescription']) ? 'is-invalid' : 'is-valid') : '' ?>" name="teamDescription" ><?= isset($_POST['teamDescription']) ? $_POST['teamDescription'] : $teamUpdate->teamDescription ?></textarea>
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['teamDescription']) ? $formErrors['teamDescription'] : '' ?></p>
            </div>
            <input type="submit" class="btn btn-primary" name="updateTeam" value="modifier"/>
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