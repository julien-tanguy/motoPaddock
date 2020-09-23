<?php
session_start();
require_once '../models/dataBase.php';  
require_once '../models/score.php';
require_once '../models/race.php';
require_once '../controllers/resultDetailController.php'; 
include 'menu.php';
include 'header.php';
?>
<!--body resultDetail page-->
<section id="resultDetail" class="container-fluid p-0">
    <div class="pageTitle">
        <h1><?= $raceName->raceName ?></h1>
    </div>
    <div class="row justify-content-center text-center m-0">
        <button type="button" class="btn btn-primary btn-lg col-3" id="result-mgp-btn" onclick="resultChoice('clickMotoGp')">MOTO GP</button>
        <button type="button" class="btn btn-primary btn-lg col-3" id="result-m2-btn" onclick="resultChoice('clickMoto2')" disabled>MOTO 2</button>
        <button type="button" class="btn btn-primary btn-lg col-3" id="result-m3-btn" onclick="resultChoice('clickMoto3')" disabled>MOTO 3</button>
    </div>
    <?php if(!empty($infosResult)){ ?>
    <div class="row justify-content-center m-0" id="result-mgp">
        <table class="text-center table table-striped col-md-10 col-sm-12">
            <thead>
                <tr>
                    <th>#</th>
                    <th>pilote</th>
                    <th>team</th>
                    <th>points</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach($infosResult as $detailResult){ ?>
                <tr>
                    <td><?= $count ?></td>
                    <td><?= $detailResult->pilFirst . ' ' . $detailResult->pilLast ?></td>
                    <td><?= $detailResult->teamName ?></td>
                    <td><?= $detailResult->value ?></td>
                </tr>
            <?php $count ++;
                } ?>
            </tbody>
        </table>         
    </div>
    <?php }else{ ?>
        <div class="alert alert-primary text-center mt-5 mb-5" role="alert">
            <p class="text-center">Aucun résultat à afficher, cette course n'est pas encore disputée.</p>
        </div>
    <?php } ?>
</section>
<!--footer-->
<?php include 'footer.php' ?>