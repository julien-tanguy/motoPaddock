<?php 
session_start();
require_once 'models/dataBase.php';
require_once 'models/articles.php';
require_once 'controllers/indexController.php';
include 'views/menu.php';
include 'views/header.php'; 
?>
<section id="recent-articles" class="container-fluid">
    <?php if(isset($_GET['action']) && $_GET['action'] == 'loginIsOk'){ ?>
        <div class="alert alert-success text-center" role="alert">
            <p>Vous êtes connecté</p>
        </div>
    <?php } ?>
    <?php if(isset($_GET['action']) && $_GET['action'] == 'deleteIsOk'){ ?>
        <div class="alert alert-warning text-center" role="alert">
            <p>Votre compte a été supprimé</p>
        </div>
    <?php } ?>
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>ACCUEIL</h1>
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
    <div class="row justify-content-center m-0">
        <div id="carouselRecentArticles" class="carousel slide col-md-10 col-sm-12" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselRecentArticles" data-slide-to="0" class="active"></li>
                <li data-target="#carouselRecentArticles" data-slide-to="1"></li>
                <li data-target="#carouselRecentArticles" data-slide-to="2"></li>
                <li data-target="#carouselRecentArticles" data-slide-to="3"></li>
            </ol>
                <div class="carousel-inner">
                <?php $count = 0;
                foreach($lastArticles as $articlePresentation){ ?>
                    <div class="carousel-item <?= $count == 0 ? 'active' : ' '?>">
                        <img src="<?= $articlePresentation->link ?>" alt="article-img">
                        <a href="views/articleDetail.php?id=<?= $articlePresentation->idArticles ?>">
                        <div class="carousel-caption">
                            <h2><?= $articlePresentation->title ?></h2>
                            <p class="d-none d-md-block">Auteur : <?= $articlePresentation->username ?></p>
                        </div>
                        </a>
                    </div>
                <?php $count++;  } ?>
            </div>
            <a class="carousel-control-prev" href="#carouselRecentArticles" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselRecentArticles" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="container-fluid more-articles">
            <a href="views/articles.php">Plus d'articles</a>
        </div>
        <div class="col-sm-12 col-md-5 accueilClassementsLink accueilNavItem">
            <div class="accueilNavItemContent">
                <a href="views/classementHome.php"><h2>Classements</h2></a>
                <p>Consulter le classement du championnat moto Gp.</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 accueilResultsLink accueilNavItem">
            <div class="accueilNavItemContent">
                <a href="views/resultsHome.php"><h2>Résultats</h2></a>
                <p>Suivez les résultats du dernier grand prix.</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 accueilPilotsLink accueilNavItem">
            <div class="accueilNavItemContent">
                <a href="views/pilotsHome.php?id=1"><h2>Pilotes</h2></a>
                <p>Tous sur les pilotes du championnat.</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 accueilTeamsLink accueilNavItem">
            <div class="accueilNavItemContent">
                <a href="views/teamsHome.php?id=1"><h2>Teams</h2></a>
                <p>Tous sur les équipes du moto Gp.</p>
            </div>
        </div>
    </div>
</section>
<!--footer-->
<?php include 'views/footer.php' ?>
        

        