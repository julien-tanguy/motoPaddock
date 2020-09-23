<?php 
session_start();
include_once '../models/dataBase.php';
include_once '../models/users.php';
include_once '../controllers/loginFormController.php'; 
?>
<!--header + menu-->
<?php include 'menu.php' ?>
<?php include 'header.php' ?>
<!--body form conection/inscription-->
    <div class="container loginForm">
        <?php if(isset($formMessageSuccess)){ ?>
            <div class="alert alert-success text-center" role="alert">
                <?= $formMessageSuccess ?>
            </div>
        <?php } ?>
        <div class="row text-center">
            <h1 class="col-12">Rejoignez la communauté moto paddock!</h1>
        </div>
        <div class="row justify-content-center text-center">
            <a class="col-4" id="login-btn" href="#login" onclick="loginChoice('clickLogin')">Connexion</a>
            <a class="col-4" id="register-btn" href="#register" onclick="loginChoice('clickRegister')">Inscription</a>
        </div>
        <!--form login-->
        <div class="row <?php  if(isset($_POST['btn-login']) || count($_POST) == 0) {
                    echo '';
                }else {
                    echo 'hide';
                } ?>"  id="loginDiv"> 
            <form method="POST" action="loginForm.php">
            <label for="mail">Adresse mail :</label>
                <input type="email" name="mail" id="mail" placeholder="Votre mail" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['mail']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['mail']) ? $_POST['mail'] : '' ?>" />
                <!--message erreur-->
                <p class="errorForm"><?= isset($formErrors['mail']) ? $formErrors['mail'] : '' ?></p>
                <label for="password">mot de passe :</label>
                <input type="password" name="password" id="password" placeholder="mot de passe" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['password']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>"/>
                <!--message erreur-->
                <p class="errorForm"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                <div class="text-center">
                    <input type="submit" name="btn-login" class="btn btn-primary" value="Connexion" />
                </div>
            </form>
        </div>
        <!--form register-->
        <div class="row <?= isset($_POST['btn-register']) ? '' : 'hide' ?>" id="register">
            <form method="POST" action="loginForm.php">
                <label for="username">Votre pseudo :</label>
                <input type="text" name="username" id="username" placeholder="Votre pseudo" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['username']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" onblur="checkDisponibility(this)"/>
                <!--message erreur-->
                <p class="errorForm"><?= isset($formErrors['username']) ? $formErrors['username'] : '' ?></p>
                <label for="mail">Adresse mail :</label>
                <input type="email" name="mail" id="mail" placeholder="Votre mail" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['mail']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['mail']) ? $_POST['mail'] : '' ?>" onblur="checkDisponibility(this)"/>
                <!--message erreur-->
                <p class="errorForm"><?= isset($formErrors['mail']) ? $formErrors['mail'] : '' ?></p>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" placeholder="mot de passe" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['password']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['password']) ? $_POST['password'] : '' ?>"/>
                <!--message erreur-->
                <p class="errorForm"><?= isset($formErrors['password']) ? $formErrors['password'] : '' ?></p>
                <label for="verifyPassword">Entrer a nouveau votre mot de passe :</label>
                <input type="password" name="verifyPassword" id="verifyPassword" placeholder="saisir à nouveau" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['verifyPassword']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['verifyPassword']) ? $_POST['verifyPassword'] : '' ?>" />
                <p class="errorForm"><?= isset($formErrors['verifyPassword']) ? $formErrors['verifyPassword'] : '' ?></p>
                <div class="text-center">
                    <input type="submit" name="btn-register" class="btn btn-primary" value="Inscription" />
                </div>
            </form>
        </div>
    </div>
<!--footer-->
<?php include 'footer.php' ?>


        