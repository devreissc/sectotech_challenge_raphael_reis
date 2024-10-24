<div class="modal fade" id="crudConteudoModal" tabindex="-1" aria-labelledby="crudConteudoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-crud-conteudo-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="crudConteudoForm">
          <input type="hidden" id="conteudo-id" name="id">

          <div class="mb-3">
            <label for="conteudo-playlist" class="form-label">Playlist</label>
            <select class="form-control" id="conteudo-playlist" name="playlist_id">
            </select>
            <input type="hidden" id="selected-playlist-option">
          </div>

          <div class="mb-3">
            <label for="conteudo-title" class="form-label">Title</label>
            <input type="text" class="form-control" id="conteudo-title" name="title">
          </div>

          <div class="mb-3">
            <label for="conteudo-url" class="form-label">URL</label>
            <input type="text" class="form-control" id="conteudo-url" name="url">
          </div>

          <div class="mb-3">
            <label for="conteudo-author" class="form-label">Author</label>
            <input type="text" class="form-control" id="conteudo-author" name="author">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" id="saveConteudoChanges">Salvar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    var CrudConteudoScript = {
      init: function(){
        CrudConteudoScript.modalConfiguration();
        CrudConteudoScript.loadPlaylistsOptions();
      },
      modalConfiguration: function(){
        var id = $('#conteudo-id').val();

        if(id){
          $('.modal-title').html('Editar conteúdo');
        }else{
          $('.modal-title').html('Novo conteúdo');
        }
      },
      loadPlaylistsOptions: function(){
        $.ajax({
          url: '<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'getAllPlaylists']); ?>',
          type: "GET",
          dataType: "json",
          beforeSend: function () {
          },
          success: function (response) {
            if(response.success){
              var htmlOptions = '';
              var selectedPlaylistId = $('#selected-playlist-option').val();
              response.data.forEach(function(playlist) {
                htmlOptions += '<option value="' + playlist.id + '" '+(playlist.id == selectedPlaylistId ? 'selected' : '')+'>' + playlist.title + '</option>';
              });

              $('#conteudo-playlist').append(htmlOptions)
            }
          }
        });
      },
    }
    
    $('#crudConteudoModal').on('hidden.bs.modal', function(){
      $(this).find('#crudConteudoForm').trigger('reset');
    });

    $('#crudConteudoModal').on('shown.bs.modal', function () {
      CrudConteudoScript.init();
    });
  });
</script>