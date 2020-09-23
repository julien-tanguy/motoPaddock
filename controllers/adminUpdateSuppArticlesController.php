<?php
$article = new article;
$connexion = new connexion();
$photo = new photoPresentation();

if(isset($_POST['deletelign'])){
    $connexion->id = htmlspecialchars($_POST['recipient-name']);

    //recupere les id des photos dans la table idPhotos par l\'id 
    $arrayIdPhotos = $connexion->getPhotosIdInIdPhotos();
    $article->id = htmlspecialchars($_POST['recipient-name']);
    try {
        $article->beginTransaction();
        $connexion->deleteconnexionById();
        $article->deleteArticleById();
        //supprimer les photos dont les id sont dans le tableau arrayIdPhoto
        $photo->deletePhotosById($arrayIdPhotos);
        //sauvegarde le résultat avec commit
        $article->commit();
        $formMessageSuccess = 'L\'ARTICLE A ETE SUPPRIMÉ';
    }catch(Exception $e) {
        $article->rollBack();
        $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
    }
}

$listArticlesByName = $article->displayListNameArticles();