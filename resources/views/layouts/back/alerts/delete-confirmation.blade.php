<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <form action="" method="POST" class="delete-form">
            @method('delete')
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Êtes vous sûr de vouloir supprimer cette ligne ?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger yes-delete-btn">Oui, sûr!</button>
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
        $('#modal-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var link = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.delete-form').attr({'action' : link})
        })
    });
</script>
