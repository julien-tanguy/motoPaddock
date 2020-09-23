
<?php
session_start();
require_once '../models/dataBase.php';
require_once '../models/articles.php';
require_once '../models/idPhotos.php';
require_once '../models/users.php';
require_once '../models/photos.php';
require_once '../controllers/adminAddArticlesController.php';
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
        <?php if(isset($formMessageFail)){ ?>
            <div class="alert alert-danger" role="alert">
                <?= $formMessageFail ?>
            </div>
        <?php } ?>
        <?php include 'navAdminAdd.php' ?>
        <!--------------------------------------------------------------form photo articles-->
        <form class="text-center col-12" method="POST" id="formArticle" enctype="multipart/form-data" action="adminAddArticles.php">
        <h1 class=" text-center adminTitle">Ajouter un article</h1>
            <div class="form-group">
                <label for="title">Titre :</label>
                <input id="title" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['title']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['title']) ? $_POST['title'] : '' ?>" type="text" name="title" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['title']) ? $formErrors['title'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="photo">Ajouter une photo de présentation :</label>
                <input id="photo" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['photo']) ? 'is-invalid' : 'is-valid') : '' ?>" type="file" name="photo" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['photo']) ? $formErrors['photo'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="content">Contenu :</label>
                <textarea id="content" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['content']) ? 'is-invalid' : 'is-valid') : '' ?>" name="content"><?= isset($_POST['content']) ? $_POST['content'] : '' ?></textarea>
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['content']) ? $formErrors['content'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="publishDate">Date de publication :</label>
                <input id="publishDate" type="date" name="publishDate" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['publishDate']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['publishDate']) ? $_POST['publishDate'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['publishDate']) ? $formErrors['publishDate'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="editDate">Date de derniere modification :</label>
                <input id="editDate" type="datetime-local" name="editDate" class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['editDate']) ? 'is-invalid' : 'is-valid') : '' ?>" value="<?= isset($_POST['editDate']) ? $_POST['editDate'] : '' ?>" />
                <!--message d'erreur-->
                <p class="errorForm"><?= isset($formErrors['editDate']) ? $formErrors['editDate'] : '' ?></p>
            </div>
            <div class="form-group">
                <label for="category">Catégorie : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['category']) ? 'is-invalid' : 'is-valid') : '' ?>" name="category" id="category">
                    <option disabled selected>Selectionner une catégorie</option>
                    <?php 
                    foreach($categoriesList as $categoryList){ 
                        ?><option <?= (isset($_POST['category']) && $_POST['category'] == $categoryList) ? 'selected' : '' ?> value="<?php echo $categoryList->id ?>"><?= $categoryList->name; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['category'])) { ?>
                        <p class="errorForm"><?= $formErrors['category'] ?></p>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="user">Auteur : </label>
                <select class="form-control <?= count($formErrors) > 0 ? (isset($formErrors['user']) ? 'is-invalid' : 'is-valid') : '' ?>" name="user" id="user">
                    <option disabled selected>Selectionner un auteur</option>
                    <?php 
                    foreach($usersList as $user){ 
                        ?><option <?= (isset($_POST['user']) && $_POST['user'] == $user) ? 'selected' : '' ?> value="<?php echo $user->id ?>"><?= $user->username; ?></option><?php
                    } ?>
                </select>
                <?php if(isset($formErrors['user'])) { ?>
                        <p class="errorForm"><?= $formErrors['user'] ?></p>
                <?php } ?>
            </div>
            <input type="submit" class="btn btn-primary" name="addArticle" value="Ajouter"></input>
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