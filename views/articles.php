<?php
session_start();
require_once '../models/dataBase.php'; 
require_once '../models/articles.php';
require_once '../models/category.php';
require_once '../controllers/articlesController.php';
include 'menu.php';
include 'header.php' 
?>
<!--body article page-->
<section id="recent-articles" class="container-fluid">
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>NEWSROOM</h1>
        </div>
        <div class="sessionLink col-6 m-0">
            <?php if(isset($_SESSION['profile'])){ ?>
                <ul class="navbar justify-content-end">
                    <li class="dropdown users-menu">
                        <a href="#" class="dropdown-toggle" id="underAdminMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-2x"></i><span class="ml-3"></span><?= $_SESSION['profile']['username'] ?></a>
                        <div class="dropdown-menu bg-light" aria-labelledby="underAdminMenu">
                            <a class="dropdown-item text-dark" href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/profile.php">mon compte</a>
                            <a class="dropdown-item text-dark" href="/index.php?action=disconnect">Deconnexion</a>
                        </div>
                    </li>
                </ul>
            <?php }else{ ?>
                <div class="users-menu text-right pt-3">
                    <a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/loginForm.php">Connexion/Inscription</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row m-0 mt-5 mb-5">
        <form action="articles.php" method="POST" class="form-inline mx-auto">
            <div class="form-group  m-3">
                <select class="form-control selectSearch" name="teamCategory" id="teamCategory">
                    <option disabled selected>Rechercher un article</option>
                    <option value="allArticles">Tous les articles</option>
                    <?php 
                    foreach($categoriesList as $categoryName){ 
                        ?><option value="<?= $categoryName->id; ?>"><?= $categoryName->name; ?></option><?php
                    } ?>
                </select>
            </div>
            <input type="submit" name="searchArticle" value="rechercher" class="inputSearch btn btn-primary m-3">
        </form>
    </div>
    <!--card article-->
    <div class="row justify-content-center m-0 mb-5">
        <?php foreach($cardArticles as $article) { ?>
            <div class="card col-md-5 col-lg-3 col-sm-12 article">
                <a href="articleDetail.php?id=<?= $article->idArticles ?>">
                    <!-- Card image -->
                    <div class="picture-art">
                        <img class="img-fluid" src="<?= $article->link ?>" alt="article-img">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><?= $article->title ?></h2>
                        <hr />
                        <p class="resume-art">Date de publication : <?= $article->publicationDate ?>.</p>
                        <p class="resume-art">Auteur : <?= $article->username ?>.</p>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
    <!--pagination-->
    <div class="pagination justify-content-center mb-3">
        <?php
            for ($i = 1; $i <= $pageNumber; $i++) {?>
                <a href="articles.php?page=<?= $i ?>" class="btn <?= $i == $_GET['page'] ? 'btn-primary rounded-circle' : '' ?>"><?= $i ?></a>
        <?php } ?>
    </div>
</section>
<!--footer-->
<?php include 'footer.php' ?>