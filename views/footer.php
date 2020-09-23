        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-6 text-center linksFooter">
                        <p><a href="#" title="liens-confidentialité">Conditions d'utilisation</a>
                        <a href="#" title="utilisation-cookies">Utilisation des cookies</a>
                        <a href="https://julien-tanguy.github.io/cv-julien-tanguy/" title="liens-vers-mon-cv">auteur du site</a></p>
                    </div>
                    <div class="row col-6 justify-content-center">
                        <a href="#" title="liens-facebook"><i class="fab fa-facebook fa-3x"></i></a>
                        <a href="#" title="liens-twitter"><i class="fab fa-twitter fa-3x"></i></a>
                    </div>
                </div>
            </div>
        </footer>
        <!--JS/JQ-BOOTSTRAP-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <!--JS/TINYMCE-->
        <script src="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>assets/js/tinymce/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea', plugins: 'advlist link image lists' });</script>
        <script type="text/javascript" src="<?= $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' ? '' : '../' ?>assets/js/main.js"></script>
    </body>
</html>