<?php
/*Je verifie qu'un id est bien pacé en GET sinon, l'utilisateur est redirigé vers l'accueil */
if($_GET['id']){
    /*J'instancie mon objet teams de la class team et hydrate l'id de la catégorie 
    de l'objet pour pouvoir afficher les detail de l'équipe */
    /* J'instancie mon objet category pour povoir check si la catégorie existe.
    si oui, les cards sont affiché, sinon le contenu contentNotExist s'affiche */
    $teams = new team();
    $teams->id = $_GET['id'];
    $category = new category;
    $category->id = $_GET['id'];
    if($category->checkcategoryExistById()){
        $teamsList = $teams->teamsCard();
    }else{
        $contentNotExist = 'OUPS... CETTE PAGE N\'EXISTE PAS!';
    }
}else {
    Header('location: ../index.php');
    exit;
}