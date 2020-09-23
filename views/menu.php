<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/dataBase.php'; 
require_once $_SERVER['DOCUMENT_ROOT'].'/models/category.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controllers/menuController.php'; 
?>
<!DOCTYPE html>
<html lang="fr" dir='ltr'>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-widht, initial-scale, shrink to fit=no"/>
        <link rel="shortcut icon" href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>assets/img/banniere/favicon.ico" type="image/x-icon" />
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
        <!--FONT barlow-->
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300&display=swap" rel="stylesheet" />
        <!--FONT titre-->
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" />
        <!--CSS-->
        <!-- assets/css/style.css -->
        <link type="text/css" rel="stylesheet" href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>assets/css/style.css" />
        <title>Moto Paddock</title>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row principalMenu ">
            <div class="navbar" id="slideMenu">
                <ul id="menuNav">
                    <?php if(!isset($_SESSION['profile'])){ //Si l'utilisateur n'est pas connecté ?>
                        <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/loginForm.php">Connexion/Inscription</a></li>
                    <?php }else{ //Si la personne est connectée?>
                        <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/profile.php">Mon compte</a></li>
                        <li><a href="/index.php?action=disconnect">Deconnexion</a></li>
                    <?php } ?> 
                    <!-- icone a reutiliser pour profil <i class="fas fa-user-circle fa-2x"></i> -->
                    <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>index.php">Accueil</a></li>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/classementHome.php" class="menu-classements">Classements</a></li>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/resultsHome.php">Resultats</a></li>
                    <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/articles.php">Articles</a></li>
                    <li><a href="#" class="menu-pilotes" onclick="underMenu(this)">Pilotes<span><i class="fas fa-arrow-circle-down fa-1x"></i></span></a>
                        <ul id="underMenu-pilotes" class="hide">
                            <?php foreach($categoriesList as $categoryDetail) { ?>
                                <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/pilotsHome.php?id=<?= $categoryDetail->id ?>"><?= $categoryDetail->name ?></a></li>
                            <?php } ?>
                        </ul></li>
                    <li><a href="#" class="menu-teams" onclick="underMenu(this)">Teams<span><i class="fas fa-arrow-circle-down fa-1x "></i></span></a>
                        <ul id="underMenu-teams" class="hide">
                            <?php foreach($categoriesList as $categoryDetail) { ?>
                                <li><a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/teamsHome.php?id=<?= $categoryDetail->id ?>"><?= $categoryDetail->name ?></a></li>
                            <?php } ?>
                        </ul></li>
                    <?php if(isset($_SESSION['profile']) && $_SESSION['profile']['id_ap29f_roles'] == 1){ ?>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" id="underAdminMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            admin
                        </a>
                        <div class="dropdown-menu bg-light" aria-labelledby="underAdminMenu">
                            <a class="dropdown-item text-dark" href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/adminAddPilots.php">ajouter</a>
                            <a class="dropdown-item text-dark" href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>views/adminUpdateSuppPilots.php">modifier/supprimer</a>
                        </div></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <!--btn-nav-->
    <div class="toggle-btn-nav" id="nav-btn" onclick="slideMenuOption()">
        <span></span>
    </div>