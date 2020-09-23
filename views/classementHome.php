<?php
session_start();
include 'menu.php';
include 'header.php';
?>
<!--body classementHome page-->
<section id="classementHome" class="container-fluid">
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>CLASSEMENTS</h1>
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
        <div class="card col-md-9 col-sm-12">
            <img class="card-img" title="photo des pilotes du moto GP" src="../assets/img/banniere/Grille-MotoGP.jpg" alt="grille-motoGp" />
            <a href="classementDetail.php?id=1"><div class="card-img-overlay">
                <h2 class="card-title">MOTO GP</h2>
            </div></a>
        </div>
        <div class="card col-md-9 col-sm-12">
            <img class="card-img disabled" title="photo des pilotes du moto 2" src="../assets/img/banniere/grille-moto2.jpg" alt="grille-moto2" />
            <div class="card-img-overlay">
                <h2 class="card-title">MOTO 2</h2>
                <h2 class="card-title">Prochainement...</h2>
            </div>
        </div>
        <div class="card col-md-9 col-sm-12">
            <img class="card-img disabled" title="photo des pilotes du moto 3" src="../assets/img/banniere/grille-moto3.jpg" alt="grille-moto3" />
            <div class="card-img-overlay">
                <h2 class="card-title">MOTO 3</h2>
                <h2 class="card-title">Prochainement...</h2>
            </div>
        </div>
    </div>
</section>
<!--footer-->
<?php include 'footer.php' ?>