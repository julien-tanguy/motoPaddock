//slide menu reveal
function slideMenuOption () {
    var slideMenu = document.getElementById('slideMenu');
    var navBtn = document.getElementById('nav-btn');
    var pilotes = document.getElementById('underMenu-pilotes');
    var teams = document.getElementById('underMenu-teams');
    //si il contient slide menu, le menu est ouvert, fermer le menu et animation bouton
    if (slideMenu.classList.contains('slideMenu')) {
        slideMenu.classList.add('rangeMenu');
        slideMenu.classList.remove('slideMenu');
        navBtn.classList.remove('transformBtn');
        //si on ferme le menu est qu'un sous menu est ouvert, on le ferme aussi
            if (pilotes.classList.contains('hide') == false){
                pilotes.classList.add('hide');
            }else if (teams.classList.contains('hide') == false){
                    teams.classList.add('hide');
            }
    //sinon, soit le menu est fermé, soit aucune classe existe encore (premier passage sur la page) donc on ouvre le menu et lancer animation bouton
    }else {
        slideMenu.classList.remove('rangeMenu');
        slideMenu.classList.add('slideMenu');
        navBtn.classList.add('transformBtn');
    }
}
//ouvrir sous menu slide menu
function underMenu(element) {
    var pilotes = document.getElementById('underMenu-pilotes');
    var teams = document.getElementById('underMenu-teams');
    if (element.getAttribute('class') == 'menu-teams') {
        teams.classList.toggle('hide');
        if (pilotes.classList.contains('hide') == false){
            pilotes.classList.add('hide');
        }
    }else if (element.getAttribute('class') == 'menu-pilotes') {
        pilotes.classList.toggle('hide');
        if (teams.classList.contains('hide') == false){
            teams.classList.add('hide');
        }
    }
}
//masquer et afficher la div correspondante (connexion ou inscription)
function loginChoice(action) {
    var login = document.getElementById('loginDiv');
    var register = document.getElementById('register');

    switch(action) {
        case 'clickLogin' : 
        register.classList.add('hide');
        login.classList.remove('hide');
        break;
        case 'clickRegister' : 
        login.classList.add('hide');
        register.classList.remove('hide');
        break;
    }
}

//choix du tableau a afficher selon la catégorie dans resultDetail
function resultChoice(action) {
    var motoGp = document.getElementById('result-mgp');
    var moto2 = document.getElementById('result-m2');
    var moto3 = document.getElementById('result-m3');

    switch(action) {
        case 'clickMotoGp' :
        motoGp.classList.remove('hide'); 
        moto2.classList.add('hide');
        moto3.classList.add('hide');
        break;
        case 'clickMoto2' : 
        moto2.classList.remove('hide'); 
        motoGp.classList.add('hide');
        moto3.classList.add('hide');
        break;
        case 'clickMoto3' : 
        moto3.classList.remove('hide'); 
        moto2.classList.add('hide');
        motoGp.classList.add('hide');
        break;
        default:
        motoGp.classList.remove('hide'); 
        moto2.classList.add('hide');
        moto3.classList.add('hide');
        break;
    }
}
//choix du tableau a afficher selon dans le profil utilisateur
function userChoice(action) {
    var info = document.getElementById('info-user');
    var update = document.getElementById('update-user');
    var del = document.getElementById('delete-user');

    switch(action) {
        case 'clickInfo' :
        info.classList.remove('hide'); 
        update.classList.add('hide');
        del.classList.add('hide');
        break;
        case 'clickUpdate' : 
        update.classList.remove('hide'); 
        info.classList.add('hide');
        del.classList.add('hide');
        break;
        case 'clickDelete' : 
        del.classList.remove('hide'); 
        update.classList.add('hide');
        info.classList.add('hide');
        break;
        default:
        info.classList.remove('hide'); 
        update.classList.add('hide');
        del.classList.add('hide');
        break;
    }
}
//! JQUERY POUR LA SUPRESSION
// fonction jquery recuperer sur bootstrap
//permet de passer en POST l'id voulu.
$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Bouton qui a déclenché le modal
    var recipient = button.data('id') // Extraire les informations des attributs data- *
    //Mettre à jour le contenu du modal. Nous utiliserons jQuery ici
    var modal = $(this)
    modal.find('#recipient-name').val(recipient);
  });

//! AJAX VERIFICATION
function checkDisponibility(input){
    //Instanciation de l'objet XMLHttpRequest permettant de faire de l'AJAX
    var request = new XMLHttpRequest();
    //Les données sont envoyés en POST et c'est le controlleur qui va les traiter
    request.open('POST', '../controllers/loginFormController.php', true);
    //Au changement d'état de la demande d'AJAX
    request.onreadystatechange = function () {
        //Si on a bien fini de recevoir la réponse de PHP (4) et que le code retour HTTP est ok (200)
        if (request.readyState == 4 && request.status == 200) {
            if(request.responseText == 1){ //Dans le cas ou la valeur dans le champ est déjà en BDD
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }else if(request.responseText == 2){ //Dans le cas où le champ est vide
                input.classList.remove('is-valid','is-invalid');
            }else{ //Dans le cas ou la valeur dans le champ n'est pas en BDD
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            }
        };        
    }
    // Pour dire au serveur qu'il y a des données en POST à lire dans le corps
    request.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    //Les données envoyées en POST. Elles sont séparées par un &
    request.send('fieldValue=' + input.value + '&fieldName=' + input.name);
}

