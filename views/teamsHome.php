<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/teams.php';
require_once '../models/category.php';
require_once '../controllers/teamsHomeController.php';
include 'menu.php';
include 'header.php'; 
?>
<?php if(!isset($contentNotExist)){ ?>
    <section id="teamsPage" class="container-fluid">
        <div class="row m-0">
            <div class="pageTitle col-6 m-0">
                <h1>TEAMS</h1>
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
        <div class="row justify-content-center m-0 mt-3">
            <?php foreach($teamsList as $teamDetail) { ?>
            <div class="card col-md-5 col-sm-12 teams">
                <a href="teamDetail.php?id=<?= $teamDetail->idTeam ?>">
                    <div class="picture-teams">
                        <img src="<?= $teamDetail->photoCard ?>" alt="team-img">
                    </div>
                    <div class="card-body text-center">
                        <h2 class="card-title"><?= $teamDetail->name ?></h2>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
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