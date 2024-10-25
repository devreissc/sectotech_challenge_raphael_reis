<section>
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col col-6 d-flex align-items-center mb-3">
                <h1 class="text-dark font-bold"><?php echo __('Playlists') ?></h1>
            </div>
            
            <div class="col-auto mb-3 justify-content-end">
                <a href="javascript:;" id="add-playlist" style="font-size: larger;" class="btn btn-2 btn-primary text-white btn-block px-4 py-2 me-3 text-nowrap"><?= __('Nova Playlist') ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card p-4" style="border-radius: 8px; min-height: calc(100vh - 380px);" >
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <div id="tabela-playlists"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <nav>
                    <ul class="pagination" id="pagination-links"></ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        var PlaylistIndex = {
            init: function(){
                PlaylistIndex.reloadPlaylists();
                $('#tabela-playlists').html();
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
                            var html = '<table class="table">';
                            html += '<thead class="table-dark"><tr><th>ID</th><th>Título</th><th>Autor</th><th>Descrição</th><th class="text-center">Data de criação</th><th class="text-center">Última atualização</th><th class="text-center">Ações</th></tr></thead><tbody>';
                            response.data.forEach(function(playlist) {
                                html += '<tr>';
                                html += '<td>' + playlist.id + '</td>';
                                html += '<td>' + playlist.title + '</td>';
                                html += '<td>' + playlist.author + '</td>';
                                html += '<td>' + playlist.description + '</td>';
                                html += '<td class="text-center">' + playlist.created_at + '</td>';
                                html += '<td class="text-center">' + playlist.updated_at + '</td>';
                                html += '<td class="text-center"><a href="javascript:;" class="btn btn-primary view-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Visualizar</a>'
                                    + '<a href="javascript:;" class="btn btn-secondary edit-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Editar</a>'
                                    + '<a href="javascript:;" class="btn btn-danger delete-playlist mx-1" data-playlist-id="' + playlist.id + '">' + 'Excluir</a>'
                                    + '</td>';
                                html += '</tr>';
                            });
                            html += '</tbody></table>';

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
                $('#add-playlist').off('click').on('click', function(event){
                    event.preventDefault();
                    $('#crudPlaylistModal').modal('show');
                });

                $('.edit-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');

                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'getPlaylist']) ?>/'+playlistId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response){
                            $('#playlist-id').val(response.data.id);
                            $('#playlist-title').val(response.data.title);
                            $('#playlist-description').val(response.data.description);
                            $('#playlist-author').val(response.data.author);
                            $('#crudPlaylistModal').modal('show');
                        },
                        error: function() {
                            GlobalScript.showErrorMessage('Erro', 'Erro ao editar a Playlist.');
                        }
                    });
                });

                $('#savePlaylistChanges').off('click').on('click', function(event){
                    event.preventDefault();

                    var id = $('#playlist-id').val();
                    var urlRequest = '<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'add']) ?>';
                    var message = 'Tem certeza que deseja salvar essa playlist?';

                    if(id){
                        urlRequest = '<?php echo $this->Url->build(['controller' => 'playlists', 'action' => 'edit']) ?>/'+id;
                        message = 'Tem certeza que deseja salvar as alterações?';
                    }

                    var dataPlaylist = $('#crudPlaylistForm').serialize();

                    PlaylistIndex.confirmOperation(message, urlRequest, dataPlaylist);
                });

                $('.delete-playlist').unbind().click(function(){
                    var playlistId = $(this).data('playlist-id');
                    var urlRequest = '<?= $this->Url->build(['controller' => 'playlists', 'action' => 'delete']) ?>';

                    PlaylistIndex.confirmOperation('Tem certeza que deseja excluir esse registro?', urlRequest, {id: playlistId});
                });

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
                                GlobalScript.showErrorMessage('Erro', 'Erro ao atualizar playlist.');
                            }
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 404) {
                                GlobalScript.showErrorMessage('Erro', 'Playlist não encontrada.');
                            } else {
                                GlobalScript.showErrorMessage('Erro', 'Erro ao carregar playlist.');
                            }
                        }
                    });
                });
            },
            confirmOperation: function(modalTitle = '', url = '', data = []){
                Swal.fire({
                    title: modalTitle,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    denyButtonText: "Não",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        PlaylistIndex.requestOperation(url, data);
                    } else if (result.isDenied) {
                        GlobalScript.showInfoMessage("Operação cancelada");
                    }
                });
            },
            requestOperation: function(url, dataPlaylist) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: dataPlaylist,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            GlobalScript.showSuccessMessage('Sucesso!', response.message);
                        } else {
                            GlobalScript.showErrorMessage('Erro!', response.message);
                        }
                        PlaylistIndex.reloadPlaylists(1000);
                    },
                    error: function() {
                        GlobalScript.showErrorMessage('Erro!', 'Erro na requisição.');
                    }
                });

                $('#crudPlaylistModal').modal('hide');
            },
            reloadPlaylists: function(timeout = 0) {
                setTimeout(function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const paramsPage = urlParams.get('page') || 1;
                    PlaylistIndex.getAllPlaylists(paramsPage);
                }, timeout);
            }
        }

        PlaylistIndex.init();
        
    });
</script>

<?= $this->element('modais/modal_edit_playlist'); ?>