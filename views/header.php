<header>
    <div id="banniere">
        <!--bouton-nav ici-->       
        <a href="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>index.php"><h1 class="titleBanniere">MOTO PADDOCK</h1></a>
        <picture>
            <source media="(min-width: 760px)" srcset="../assets/img/banniere/banniere-principal-md.jpg">
            <img src="assets/img/banniere/banniere-principal-xl.jpg">
        </picture>
    </div>
</header>
