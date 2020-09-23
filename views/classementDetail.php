<?php 
session_start();
require_once '../models/dataBase.php';  
require_once '../models/score.php';
require_once '../controllers/classementDetailController.php'; 
include 'menu.php';
include 'header.php';
?>
<!--body classementDetail page-->
<section id="classementDetail" class="container-fluid">
    <div class="row m-0">
        <div class="pageTitle col-6 m-0">
            <h1>CLASSEMENTS MOTO GP</h1>
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
    <?php if(!empty($infosLadder)){ ?>
    <div class="row justify-content-center m-0">
        <table class="text-center table table-striped col-md-10 col-sm-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>pilote</th>
                    <th>team</th>
                    <th>points</th>
                </tr>
            </thead>
            <?php $count = 1;
                foreach($infosLadder as $detailLadder){ ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $detailLadder->pilFirst . ' ' . $detailLadder->pilLast ?></td>
                    <td><?= $detailLadder->teamName ?></td>
                    <td><?= $detailLadder->sumValues ?></td>
                </tr>
                <?php $count ++;
                } ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
        <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
            <p class="text-center">Aucun résultat à afficher, une erreur est survenue.</p>
        </div>
    <?php } ?>
</section>
<!--footer-->
<?php include 'footer.php' ?>