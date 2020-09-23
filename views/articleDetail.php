<?php
session_start(); 
require_once '../models/dataBase.php';
require_once '../models/articles.php';
require_once '../models/comments.php';
require_once '../controllers/articleDetailController.php';
include 'menu.php';
include 'header.php'; 
?>
<!--body article page-->
<?php if(!isset($contentNotExist)){ ?>
    <section class="article-content container">
        <div class="row">
            <h1 class="text-center col-12"><?= $infosArticle->title ?></h1>
            <div class="col-12 articleContentDetail">
                <?= html_entity_decode($infosArticle->content) ?>
            </div>
            <div class="row authorArticle">
                <p><i class="fas fa-tag"></i> : <?= $infosArticle->categoryName ?></p>
                <p><i class="fas fa-user-edit"></i> : <?= $infosArticle->authorName ?></p>
                <p><i class="fas fa-clock"></i> : <?= $infosArticle->editDateFr ?></p>
            </div>
        </div>
        <div class="text-center mb-4">
            <a class="btn btn-primary btn-back" href="articles.php">Retour aux articles</a>
        </div>
        <h2>Partager</h2>
        <div class="row shareArticle justify-content-center">
            <a href="#"><i class="fab fa-facebook-f fa-3x"></i></a>
            <a href="#"><i class="fab fa-twitter fa-3x"></i></a>
            <a href="#"><i class="fab fa-whatsapp fa-3x"></i></a>
            <a href="#"><i class="fas fa-paper-plane fa-3x"></i></a>
            <a href="#"><i class="fab fa-linkedin-in fa-3x"></i></a>
        </div>
    </section>
    <!-- ESPACE COMMENTAIRES-->
    <section class="spaceComment container" id="comments">
        <h2>Commentaires</h2>
        <?php if(isset($_SESSION['profile'])){ ?>
            <div class="row sendAndDisplay justify-content-center">
                <form method="POST" class="text-center" >
                    <label for="comment">Poster un commentaire :</label>
                    <input type="text" name="comment" id="comment" placeholder="Votre commentaire...."/>
                    <input type="submit" name="sendComment" class="btn btn-primary" value="Poster" />
                </form>
            </div>
        <?php }else{ ?>
            <div class="row sendAndDisplay justify-content-center text-white">
                <div class="col-12">
                    <p class="text-center">Connécté vous pour poster un commentaire.</p> 
                </div>
                <a href="loginForm.php" class="btn btn-primary btn-back m-0">se connecter</a>
            </div>
        <?php } ?>
        <?php foreach($displayComments as $commentArticle) { ?>
            <div class="row sendAndDisplay justify-content-center text-white">
                <div class="col-3">
                    <p class="text-center"><?= $commentArticle->authorComment ?></p> 
                </div>
                <div class="col-3">
                    <p class="text-center"><?= $commentArticle->date ?></p> 
                </div>
                <div class="col-6">
                    <p class="text-center"><?= $commentArticle->commentContent ?></p> 
                </div>
            </div>
        <?php } ?>
    </section>
<?php }else{ ?>
    <section class="contentNotExist container m-auto">
        <div class="view m-auto">
            <div class="mask flex-center rgba-stylish-strong">
                <p class="white-text"><?= $contentNotExist ?></p>
            </div>
            <img src="../assets/img/content/contentNotExist.jpg" class="img-fluid" alt="illustration not exist">
        </div>
    </section>
<?php } ?>
<!--footer-->
<?php include 'footer.php' ?>