<?php
if (isset($_GET['id'])){
    $articleUpdate = new article();
    $articleUpdate->id = htmlspecialchars($_GET['id']);
    
    $displayArticleInfos = $articleUpdate->displayUpdateArticle();
}

if(isset($_POST['updateArticle'])){
    if (!empty($_POST['title'])) {
        $articleUpdate->title = htmlspecialchars($_POST['title']);
    }else {
        $formErrors['title'] = 'Veuillez entrer le tittre de l\'article.';
    }
    if (!empty($_POST['content'])) {
        $articleUpdate->content = htmlspecialchars($_POST['content']);
    }else {
        $formErrors['content'] = 'Veuillez entrer le contenu de l\'article.';
    }
if(empty($formErrors)){
        //on appelle la methode de notre addPatient pour creer un nouveau patient dans la base de données
        if($articleUpdate->updateArticle()){
            $formMessageSuccess = 'L\'ARTICLE A BIEN ETE MODIFIÉ';
        }else {
            $formMessageFail = 'UNE ERREUR EST SURVENUE PANDANT L\'ENREGISTREMENT.VEUILLEZ CONATCER LE SERVICE INFORMATIQUE.';
        } 
    }
}