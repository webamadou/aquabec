<div class="modal fade" id="modal-validation">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" class="delete-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="header-title"></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="px-3 py-4">
                                <div class="col-12">
                                    <input class="form-check-input form-control" name="validated" type="radio" value="1" id="defaultCheck1"><br>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="badge badge-success form-check-label" for="defaultCheck1">
                                        <i class="fa fa-check"></i> Valider la publication
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="px-3 py-4">
                                <div class="col-12">
                                    <input class="form-check-input form-control" name="validated" type="radio" value="2" id="defaultCheck0"><br>
                                </div>
                                <div class="col-12 mt-4">
                                    <label class="badge badge-danger form-check-label" for="defaultCheck0">
                                        <i class="fa fa-ban"></i> Rejeter la publication
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 py-3" id="rejection_reasons_wrapper">
                            <textarea name="rejection_reasons" id="rejection_reasons" class="form-control" cols="30" rows="10" placeholder="Préciser les raisons si la publication doit être rejetée."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger yes-delete-btn">Confirmer!</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $(function() {
        $('#modal-validation').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            $('form').attr("action","google.com");
            $('#header-title').html(button.data('modal_title'));
            var link = button.data('route') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.delete-form').attr({'action' : link})
        })
    });
</script>
