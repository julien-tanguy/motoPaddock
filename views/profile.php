<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/users.php';
require_once '../controllers/profileController.php';
include 'menu.php';
include 'header.php'; 
?>
<section id="profilePage" class="container-fluid">
        <?php if(isset($formMessageSuccess)){ ?>
            <div class="alert alert-success text-center" role="alert">
                <?= $formMessageSuccess ?>
            </div>
        <?php } ?>
    <div class="pageTitle ">
        <h1>MON COMPTE</h1>
    </div>
    <?php if(isset($_SESSION['profile'])){ ?>
    <div class="row justify-content-center m-0">
        <div class="nav-user col-sm-2 col-md-4 col-lg-2 text-center">
            <ul class="nav row">
                <li class="col-12">
                    <button type="button" class="btn btn-dark mt-5" onclick="userChoice('clickInfo')">Mes informations</button>
                </li>
                <li class="col-12">
                    <button type="button" class="btn btn-dark" onclick="userChoice('clickUpdate')">Modifier</button>
                </li>
                <li class="col-12">
                    <button type="button" class="btn btn-dark" onclick="userChoice('clickDelete')">Supprimer mon compte</button>
                </li>
            </ul>
        </div>
        <div class="col-md-8">
            <div class="jumbotron <?= isset($_POST['btn-updateInfos']) || isset($_POST['btn-updatePassword'])  ? 'hide' : '' ?>" id="info-user">
                <div>
                    <h1 class="text-center">Mes informations</h1>
                    <p>Pseudo : <?= $_SESSION['profile']['username'] ?></p>
                    <p>Adresse mail associé à votre compte : <?= $_SESSION['profile']['mail'] ?></p>
                    <div class="text-center">
                        <a class="btn btn-dark btn-user" href="/index.php?action=disconnect">Deconnexion</a>
                    </div>
                </div>
            </div>
            <div class="jumbotron <?= isset($_POST['btn-updateInfos']) || isset($_POST['btn-updatePassword']) ? '' : 'hide' ?>" id="update-user">
                <h1 class="text-center">Modifier mes informations</h1>
                <form class="text-center col-12 mb-5" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class="form-group">
                        <label for="username">Pseudo :</label>
                        <input id="username" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['username']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['username']) ? $_POST['username'] : $_SESSION['profile']['username'] ?>" type="text" name="username" />
                        <!--message d'erreur-->
                        <p class="errorForm"><?= isset($formErrors['username']) ? $formErrors['username'] : '' ?></p>
                    </div>
                    <input type="submit" name="btn-updateInfo" class="btn-user btn btn-dark" value="modifier votre pseudo" />
                </form>
                <form class="text-center col-12" method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class="form-group">
                        <label for="oldPassword">Ancien mot de passe :</label>
                        <input type="oldPassword" name="oldPassword" id="oldPassword" placeholder="Ancien mot de passe" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['oldPassword']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['oldPassword']) ? $_POST['oldPassword'] : '' ?>"/>
                        <!--message erreur-->
                        <p class="errorForm"><?= isset($formErrors['oldPassword']) ? $formErrors['oldPassword'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe :</label>
                        <input type="password" name="password" id="password" placeholder="Mot de passe" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['password']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>"/>
                        <!--message erreur-->
                        <p class="errorForm"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                    </div>
                    <div class="form-group">
                        <label for="verifyPassword">Confirmer nouveau mot de passe :</label>
                        <input type="password" name="verifyPassword" id="verifyPassword" placeholder="Saisir à nouveau" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['verifyPassword']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['verifyPassword']) ? $_POST['verifyPassword'] : '' ?>" />
                        <p class="errorForm"><?= isset($formErrors['verifyPassword']) ? $formErrors['verifyPassword'] : '' ?></p>
                    </div>
                    <input type="submit" name="btn-updatePassword" class="btn-user btn btn-dark" value="modifier le mot de passe" />
                </form>
            </div>
            <div class="jumbotron hide text-center"  id="delete-user">
                <h1>Supprimer mon compte</h1>
                <p><i class="fas fa-exclamation-triangle fa-2x"></i> Êtes-vous sûr de vouloir supprimer votre compte? Cette opération est irreversible!</p>
                <button class="btn btn-danger btn-user" data-toggle="modal" data-target="#deleteModal" data-id="<?= $_SESSION['profile']['id'] ?>">Supprimer mon compte</button>
            </div>
        </div>
    </div>
    <?php }else{ ?>
        <div class="jumbotron <?= isset($_POST['btn-updateInfos']) || isset($_POST['btn-updatePassword'])  ? 'hide' : '' ?>" id="info-user">
                <div class="text-center">
                    <h1>VOUS DEVEZ ÊTRE CONNÉCTÈ POUR ACCÉDER A CETTE PAGE</h1>
                    <p>Pour créer un compte ou vous connecter cliquer <a href="loginform.php">ICI</a></p>
                    <p>Pour revenir à l'accueil cliquer <a href="../index.php">ICI</a></p>
                </div>
            </div>
    <?php } ?>
</section>
<?php include 'modalSuppression.php' ?>
<!--footer-->
<?php include 'footer.php' ?>