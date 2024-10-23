<div class="playlists index content">
    <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Playlists') ?></h3>
    <div id="tabela-playlists"></div>
</div>

<script>
    $(document).ready(function(){
        var PlaylistIndex = {
            init: function(){
                PlaylistIndex.utilitarios();
                PlaylistIndex.getAllPlaylists();
            },
            getAllPlaylists: function(){
                $.ajax({
                    url: '<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'getAllPlaylists']);?>',
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        alert('carregando...');
                    },
                    success: function (response) {
                        if(response.success){
                            // Cria o HTML para exibir as playlists
                            var html = '<table>';
                            html += '<tr><th>ID</th><th>Title</th></tr>';
                            response.data.forEach(function(playlist) {
                                html += '<tr>';
                                html += '<td>' + playlist.id + '</td>';
                                html += '<td>' + playlist.title + '</td>';
                                html += '</tr>';
                            });
                            html += '</table>';

                            // Insere o HTML gerado na div
                            $('#tabela-playlists').html(html);
                        }else {
                            alert(response.message);
                            $('#tabela-playlists').html('<p>Nenhuma playlist encontrada.</p>');
                        }
                        console.log(response);
                    }
                });
            },
            utilitarios: function(){
                $('.view-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');
                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'getPlaylist']) ?>/'+playlistId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response){
                            if(response.success){
                                window.location.href = '<?= $this->Url->build(['controller' => 'Playlists', 'action' => 'view']) ?>/' + playlistId;
                            }
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 404) {
                                alert('Playlist não encontrada.');
                            } else {
                                alert('Erro ao carregar playlist.');
                            }
                        }
                    });
                }),
                $('.edit-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');

                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'getPlaylist']) ?>/'+playlistId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                            $('#playlist-id').val(response.data.id);
                            $('#playlist-title').val(response.data.title);
                            $('#playlist-description').val(response.data.description);
                            $('#playlist-author').val(response.data.author);
                            $('#editPlaylistModal').modal('show');
                        },
                        error: function() {
                            alert('erro');
                        }
                    });
                });

                $('#savePlaylistChanges').unbind().click(function(){
                    var dataPlaylist = $('#editPlaylistForm').serialize();

                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'edit']) ?>/' + $('#playlist-id').val(),
                        type: 'post',
                        data: dataPlaylist,
                        dateType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) { 
                                alert('Playlist atualizada');
                            } else {
                                alert('Failed to update playlist.');
                            }

                            $('#editPlaylistModal').modal('hide');
                            location.reload();
                        },
                        error: function() {
                            alert('Erro ao atualizar Playlist');
                        }
                    });
                });
            },
        }

        PlaylistIndex.init();
        
    });
</script>

<?= $this->element('modais/modal_edit_playlist'); ?>