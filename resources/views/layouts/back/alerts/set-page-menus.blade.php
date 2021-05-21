<div class="modal fade" id="modal-validation">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" class="delete-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Le menu de la page <span id="page_title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="header-title"></h4>
                    <div class="col-12 my-2"><hr size="3"></div>
                    <div class="row">
                        <div class="col-12 row">
                            <label class="col-12" for="menu_id"> Selectionnez les menus </label>
                            @foreach( \App\Models\Menu::where('visible',1)->pluck('name','id') as $key => $item )
                                <label for="menu_{{$key}}" class="form-control col-4"> {{$item}} <input type="checkbox" name="menu_{{$key}}" id="menu_{{$key}}" > </label>
                            @endforeach
                            <!-- </select> -->
                        </div>
                        <!-- <div class="col-12">
                            <label class="" for="name"> Donnez un nom a la page dans le menu </label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary yes-delete-btn">Confirmer!</button>
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
            $('#header-title').html(button.data('modal_title'));
            var link = button.data('route') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            $('form').attr("action", link);
            var modal = $(this)
            modal.find('.delete-form').attr({'action' : link})
        })
    });
</script>
