<?php 
session_start();
require_once '../models/dataBase.php';
require_once '../models/race.php';
require_once '../controllers/resultsHomeController.php';
include 'menu.php';
include 'header.php';
?>
<!--body resultsHome page-->
<section id="resultsHome" class="container-fluid">
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>RÉSULTATS</h1>
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
        <?php foreach($racesList as $race) { ?>
        <div class="card col-sm-12 col-md-5 racePresentation">
            <img class="card-img" title="circuit de jerez" src="<?= $race->photo ?>" alt="jerez-Gp">
            <a href="resultDetail.php?id=<?= $race->raceId ?>">
                <div class="card-img-overlay">
                    <h2 class="card-title"><?= $race->raceName ?></h2>
                    <p class="card-text"><?= $race->circuit ?></p>
                    <p class="card-text"><?= $race->dateFrStart . ' - ' . $race->dateFrEnd ?></p>
                </div>
            </a>
        </div>
        <?php } ?>
    </div>
</section>
<!--footer-->
<?php include 'footer.php' ?>
