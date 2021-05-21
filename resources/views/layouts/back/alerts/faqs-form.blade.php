<div class="modal fade" id="faq-add-title" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="" method="POST" class="delete-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Ajouter un titre</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="title">Entrez le titre</label>
                            <input type="text" name="title" class="form-control">
                            <input type="hidden" name="page_id" value="">
                            <input type="hidden" name="position" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(function() {
        $('#faq-add-title').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget) // Button that triggered the modal
            // $('#page_title').html(button.data('modal_title'));
            const link      = button.data('route') // Extract info from data-* attributes
            const page_id   = button.data('page_id') // Extract info from data-* attributes
            const position  = button.data('position') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('form').attr("action", link);
            $("input[name='page_id']").attr("value",page_id);
            $("input[name='position']").attr("value",position);
            var modal = $(this)
            // modal.find('.delete-form').attr({'action' : link})
        })
    });
</script>
