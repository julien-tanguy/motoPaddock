<?php
//!afficher un article par son id
if($_GET['id']){
    $articles = new article();
    $articles->id = $_GET['id'];
    if($articles->checkArticlesExistById()){
        $infosArticle = $articles->displayArticle();
    }else{
        $contentNotExist = 'OUPS... CETTE PAGE N\'EXISTE PAS!';
    }
}else {
    Header('location: ../index.php');
}

//!inserer un commentaires dans la base de données
if(!empty($_POST['sendComment'])){
    if(!empty($_POST['comment'])){
        $comment = new comment();
        $comment->id_ap29f_articles = $_GET['id'];
        $comment->id_ap29f_users = $_SESSION['profile']['id'];
        $comment->content = $_POST['comment'];
        $comment->addComment();
    }
}

//!afficher les commentaires liés a son article
if($_GET['id']){
    $comment = new comment();
    $comment->id = $_GET['id'];
    $displayComments = $comment->displaycommentByIdArticle();
}