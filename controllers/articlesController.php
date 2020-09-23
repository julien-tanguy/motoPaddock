<?php
//!afficher les articles sous forme de card de presentation
$cardsArticles = new article();

//!pagination
if (isset($_GET['page'])){
    $page = $_GET['page'];
}else {
    unset($_SESSION['search']);
    $page = 1;
}
$limitArray = ['limit'=>6];
$limitArray['offset'] = ($page * $limitArray['limit']) - $limitArray['limit'];
if(isset($_POST['searchArticle'])) {
    // ternaire de remplissage de variable ()
    //si $_POST['teamCategory'] existe, si $_POST['teamCategory'] = allArticles alors value = 0 sinon value = $_POST['teamCategory'], sinon 0
    $idSearch = (isset($_POST['teamCategory']) ? ($_POST['teamCategory'] == 'allArticles' ? 0 : $_POST['teamCategory']) : 0);
    $_SESSION['search'] = $idSearch;
}

if(isset($_SESSION['search'])){
    $cardArticles = $cardsArticles->displayCardsArticle($limitArray, $_SESSION['search']);
    $pageNumber = ceil(count($cardsArticles->displayCardsArticle(array(),$_SESSION['search'])) / $limitArray['limit']);
}else {
    $cardArticles = $cardsArticles->displayCardsArticle($limitArray);
    $pageNumber = ceil(count($cardsArticles->displayCardsArticle()) / $limitArray['limit']);
}

//!afficher la liste des catégories pour le champ de recherches
$category = new category();
$categoriesList = $category->categoriesList();
