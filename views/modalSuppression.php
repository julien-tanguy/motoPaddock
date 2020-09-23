<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirmez-vous la suppression ?</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label"></label>
                        <input type="hidden" class="form-control" name="recipient-name" id="recipient-name" value="" />
                    </div>
                    <div class="text-center">
                        <input type="submit" name="deletelign" value="Supprimer" class="btn btn-danger inputModal" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>