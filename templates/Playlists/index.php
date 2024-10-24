<div class="playlists index content">
    <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Playlists') ?></h3>
    <div id="tabela-playlists"></div>
    <div>
        <nav>
            <ul class="pagination" id="pagination-links">
                
            </ul>
        </nav>
    </div>
</div>

<script>
    $(document).ready(function(){
        var PlaylistIndex = {
            init: function(){
                PlaylistIndex.getAllPlaylists();
            },
            getAllPlaylists: function(page = 1){
                $.ajax({
                    url: '<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'getAllPlaylists']);?>/'+page,
                    type: "GET",
                    dataType: "json",
                    data: {
                        page: page
                    },
                    beforeSend: function () {
                    },
                    success: function (response) {
                        if(response.success){
                            // Cria o HTML para exibir as playlists
                            var html = '<table>';
                            html += '<tr><th>ID</th><th>Title</th><th>Autor</th><th>Descrição</th><th>Data de criação</th><th>Última atualização</th><th>Ações</th></tr>';
                            response.data.forEach(function(playlist) {
                                html += '<tr>';
                                html += '<td>' + playlist.id + '</td>';
                                html += '<td>' + playlist.title + '</td>';
                                html += '<td>' + playlist.author + '</td>';
                                html += '<td>' + playlist.description + '</td>';
                                html += '<td>' + playlist.created_at + '</td>';
                                html += '<td>' + playlist.updated_at + '</td>';
                                html += '<td><a href="javascript:;" class="btn btn-primary view-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Visualizar</a>'
                                    + '<a href="javascript:;" class="btn btn-secondary edit-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Editar</a>'
                                    + '<a href="javascript:;" class="btn btn-danger delete-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Excluir</a>'
                                    + '</td>';
                                html += '</tr>';
                            });
                            html += '</table>';

                            // Insere o HTML gerado na div
                            $('#tabela-playlists').html(html);

                            $('#pagination-links').empty();
                            var link = '';
                            // Cria links de paginação
                            for (var i = 1; i <= response.pagination.pages; i++) {
                                link = '<li class="page-item ' + (response.pagination.current_page == i ? 'active' : '') + '"><a href="javascript:;" class="pagination-link page-link" data-page="' + i + '">' + i + '</a></li>';
                                $('#pagination-links').append(link);
                            }

                            PlaylistIndex.utilitarios();
                        }else {
                            alert(response.message);
                            $('#tabela-playlists').html('<p>Nenhuma playlist encontrada.</p>');
                            $('#pagination-links').empty();
                        }
                        console.log(response);
                    }
                });

                
            },
            utilitarios: function(){
                $('.pagination-link').off('click').on('click', function(event){
                    event.preventDefault(); // Evita o comportamento padrão do link
                    var clickedPage = $(this).data('page');
                    PlaylistIndex.getAllPlaylists(clickedPage); // Chama a função para carregar a página selecionada
                });
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
                $('.delete-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');

                    PlaylistIndex.swal('deleteOrUpdate', 'Tem certeza que deseja excluir esse registro?',null,null,'<?= $this->Url->build(['controller' => 'playlists', 'action' => 'delete']) ?>', playlistId);
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
            swal: function(type = 'deleteorupdate', modalTitle = '', message = '', context = 'success', url = '', data = []){
                if(type != 'deleteOrUpdate'){
                    Swal.fire(modalTitle, message, context);
                }else{
                    Swal.fire({
                        title: modalTitle,
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Sim",
                        denyButtonText: "Não",
                        cancelButtonText: "Cancelar"
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: url,
                                    type: 'post',
                                    data: {
                                        id: data
                                    },
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                                    },
                                    success: function(response) {
                                        if (response.success) { 
                                            PlaylistIndex.swal(null, 'Sucesso!', response.message);
                                        } else {
                                            PlaylistIndex.swal(null, 'Erro!', response.message,'error');
                                        }

                                        $('#editPlaylistModal').modal('hide');
                                        setTimeout(function() { 
                                            location.reload();
                                        }, 1000);
                                    },
                                    error: function() {
                                        PlaylistIndex.swal(null, 'Erro!', response.message,'error');
                                    }
                                });
                            } else if (result.isDenied) {
                                Swal.fire("Operação cancelada", "", "info");
                            }
                    });
                }
            }
        }

        PlaylistIndex.init();
        
    });
</script>

<?= $this->element('modais/modal_edit_playlist'); ?>