<?php 
session_start();
require_once '../models/dataBase.php';
include '../models/pilots.php';
include '../controllers/pilotsHomeController.php';
include 'menu.php';
include 'header.php';
?>
<section id="pilotsHome" class="container-fluid">
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>PILOTES</h1>
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
    <!--card article-->
    <div class="row justify-content-center m-0 mt-3">
        <?php foreach($cardsPilots as $pilotCardDetail) { ?>
            <div class="card col-md-5 col-lg-3 col-sm-12 pilot">
                <a href="pilotDetail.php?id=<?= $pilotCardDetail->idPilot ?>">
                    <div class="picture-pilot">
                        <img src="<?= $pilotCardDetail->photo ?>" alt="pilot-img">
                    </div>
                    <!-- Card content -->
                    <div class="card-body text-center">
                        <!-- Title -->
                        <h2 class="card-title"><?= $pilotCardDetail->number . ' | ' . $pilotCardDetail->firstname . ' ' . $pilotCardDetail->lastname ?></h2>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</section>
<!--footer-->
<?php include 'footer.php' ?>