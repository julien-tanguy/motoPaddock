<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/articles.php';
require_once '../controllers/updateArticleController.php';
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
        <form class="text-center col-12" method="POST" id="formArticle" action="updateArticle.php?id=<?= $_GET['id'] ?>">
        <h1 class=" text-center adminTitle">Modifier un article</h1>
            <div class="form-group">
                <label for="title">Titre :</label>
                <input id="title" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['title']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['title']) ? $_POST['title'] : $displayArticleInfos->title ?>" type="text" name="title" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['title']) ? $formErrors['title'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="content">Contenu :</label>
                <textarea id="content" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['content']) ? 'is-invalid' : 'is-valid') : '' ?>" name="content"><?= isset($_POST['content']) ? $_POST['content'] : $displayArticleInfos->content ?></textarea>
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['content']) ? $formErrors['content'] : '' ?></p>
            </div>
            <input type="submit" class="btn btn-primary" name="updateArticle" value="Modifier"></input>
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