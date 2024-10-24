<div class="playlists index content">
    <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Playlists') ?></h3>
    
    <div id="tabela-playlists"></div>
    <div>
        <nav>
            <ul class="pagination" id="pagination-links"></ul>
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
                            $('#tabela-playlists').html('<p>Nenhuma playlist encontrada.</p>');
                            $('#pagination-links').empty();
                        }
                    }
                });
            },
            utilitarios: function(){
                $('.pagination-link').off('click').on('click', function(event){
                    event.preventDefault(); // Evita o comportamento padrão do link
                    var clickedPage = $(this).data('page');

                    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=' + clickedPage;
                    history.pushState({page: clickedPage}, '', newUrl);

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
                            }else{
                                PlaylistIndex.showErrorMessage('Erro', 'Erro ao atualizar playlist.');
                            }
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 404) {
                                PlaylistIndex.showErrorMessage('Erro', 'Playlist não encontrada.');
                            } else {
                                PlaylistIndex.showErrorMessage('Erro', 'Erro ao carregar playlist.');
                            }
                        }
                    });
                });
                
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
                            PlaylistIndex.showErrorMessage('Erro', 'Erro ao editar a Playlist.');
                        }
                    });
                });

                $('.delete-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');
                    var urlRequest = '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'delete']) ?>';

                    PlaylistIndex.confirmDeleteOrUpdate('Tem certeza que deseja excluir esse registro?', urlRequest, playlistId);
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
                                PlaylistIndex.showSuccessMessage('Sucesso!', 'Playlist atualizada.');
                            } else {
                                PlaylistIndex.showErrorMessage('Erro!', 'Erro ao atualizar a Playlist');
                            }

                            $('#editPlaylistModal').modal('hide');
                            PlaylistIndex.reloadPlaylists();
                        },
                        error: function() {
                            PlaylistIndex.showErrorMessage('Erro!', 'Erro ao atualizar a Playlist');
                        }
                    });
                });
            },
            confirmDeleteOrUpdate: function(modalTitle = '', url = '', data = []){
                Swal.fire({
                    title: modalTitle,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    denyButtonText: "Não",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        PlaylistIndex.requestDeleteOrUpdate(url, data);
                    } else if (result.isDenied) {
                        PlaylistIndex.showInfoMessage("Operação cancelada");
                    }
                });
            },
            requestDeleteOrUpdate: function(url, data) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { id: data },
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            PlaylistIndex.showSuccessMessage('Sucesso!', response.message);
                        } else {
                            PlaylistIndex.showErrorMessage('Erro!', response.message);
                        }
                        PlaylistIndex.reloadPlaylists();
                    },
                    error: function() {
                        PlaylistIndex.showErrorMessage('Erro!', 'Erro na requisição.');
                    }
                });
            },
            showSuccessMessage: function(title, message) {
                Swal.fire(title, message, 'success');
            },
            showErrorMessage: function(title, message) {
                Swal.fire(title, message, 'error');
            },
            showInfoMessage: function(message) {
                Swal.fire('Informação', message, 'info');
            },
            reloadPlaylists: function() {
                setTimeout(function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const paramsPage = urlParams.get('page') || 1;
                    PlaylistIndex.getAllPlaylists(paramsPage);
                }, 1000);
            }
        }

        PlaylistIndex.init();
        
    });
</script>

<?= $this->element('modais/modal_edit_playlist'); ?>