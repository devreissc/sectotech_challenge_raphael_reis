<div class="modal fade" id="crudPlaylistModal" tabindex="-1" aria-labelledby="crudPlaylistModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crudPlaylistModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="crudPlaylistForm">
          <input type="hidden" id="playlist-id" name="id">

          <div class="mb-3">
            <label for="playlist-title" class="form-label">Título</label>
            <input type="text" class="form-control" id="playlist-title" name="title">
          </div>
          <div class="mb-3">
            <label for="playlist-description" class="form-label">Descrição</label>
            <textarea class="form-control" id="playlist-description" name="description"></textarea>
          </div>
          <div class="mb-3">
            <label for="playlist-author" class="form-label">Autor</label>
            <input type="text" class="form-control" id="playlist-author" name="author">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="savePlaylistChanges">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    var CrudPlaylistScript = {
      init: function(){
        CrudPlaylistScript.modalConfiguration();
      },
      modalConfiguration: function(){
        var id = $('#conteudo-id').val();

        if(id){
          $('.modal-title').html('Editar playlist');
        }else{
          $('.modal-title').html('Novo playlist');
        }
      },
    }
    
    $('#crudPlaylistModal').on('hidden.bs.modal', function(){
      $(this).find('#crudPlaylistForm').trigger('reset');
    });

    $('#crudPlaylistModal').on('shown.bs.modal', function () {
      CrudPlaylistScript.init();
    });
  });
</script>