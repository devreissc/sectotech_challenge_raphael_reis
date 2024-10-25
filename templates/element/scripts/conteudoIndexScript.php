<script>
    $(document).ready(function(){
        var isView = false;
        var ConteudosIndex = {
            init: function(){
                ConteudosIndex.checkUrl();
                $('#tabela-conteudos').html('');
            },
            checkUrl: function(){
                const path = window.location.pathname;
                const pathParts = path.split('/');

                if (pathParts.includes('view')) {
                    isView = true;
                    
                } else {
                    ConteudosIndex.reloadConteudos();
                }

                ConteudosIndex.utilitarios();
            },
            getAllConteudos: function(page = 1){
                $.ajax({
                    url: '<?php echo $this->Url->build(['controller' => 'conteudos', 'action' => 'getAllConteudos']); ?>/'+page,
                    type: "GET",
                    dataType: "json",
                    data: {
                        page: page
                    },
                    beforeSend: function () {
                    },
                    success: function(response){
                        console.log(response);
                        if(response.success && response.pagination.current_page <= response.pagination.pages){
                            var html = '<table class="table">';
                            html += '<tr class="table-dark"><th>ID</th><th>Playlist</th><th>Título</th><th>URL</th><th>Autor</th><th class="text-center">Data de criação</th><th class="text-center">Última atualização</th><th class="text-center">Ações</th></tr>';
                            response.data.forEach(function(conteudo) {
                                html += '<tr>';
                                html += '<td>' + conteudo.id + '</td>';
                                html += '<td>' + conteudo.playlist.title + '</td>';
                                html += '<td>' + conteudo.title + '</td>';
                                html += '<td>' + conteudo.url + '</td>';
                                html += '<td>' + conteudo.author + '</td>';
                                html += '<td class="text-center">' + conteudo.created_at + '</td>';
                                html += '<td class="text-center">' + conteudo.updated_at + '</td>';
                                html += '<td class="text-center"><a href="javascript:;" class="btn btn-primary view-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Visualizar</a>'
                                    + '<a href="javascript:;" class="btn btn-secondary edit-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Editar</a>'
                                    + '<a href="javascript:;" class="btn btn-danger delete-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Excluir</a>'
                                    + '</td>';
                                html += '</tr>';
                            });
                            html += '</table>';

                            $('#tabela-conteudos').html(html);


                            // Cria links de paginação
                            $('#pagination-links').empty();
                            var link = '';
                            if(response.pagination.hasPreviusPage && response.pagination.current_page > 1){
                                link = '<li class="page-item"><a href="javascript:;" class="pagination-link page-link" data-page="' + (parseInt(response.pagination.current_page)-1) + '">' + '<' + '</a></li>';
                                $('#pagination-links').append(link);
                            }
                            
                            for (var i = 1; i <= response.pagination.pages; i++) {
                                link = '<li class="page-item ' + (response.pagination.current_page == i ? 'active' : '') + '"><a href="javascript:;" class="pagination-link page-link" data-page="' + i + '">' + i + '</a></li>';
                                $('#pagination-links').append(link);
                            }

                            if(response.pagination.hasNextPage && response.pagination.current_page < response.pagination.pages){
                                link = '<li class="page-item"><a href="javascript:;" class="pagination-link page-link" data-page="' + (parseInt(response.pagination.current_page)+1) + '">' + '>' + '</a></li>';
                                $('#pagination-links').append(link);
                            }
                            

                            ConteudosIndex.utilitarios();


                        }else{
                            $('#tabela-conteudos').html('<p class="fs-4">Nenhum conteúdo encontrado.</p><a class="fs-4 btn btn-primary p-2" href="<?php echo $this->Url->build(['controller' => 'conteudos', 'action' => 'index']) ?>">Voltar para o início</a>');
                            $('#pagination-links').empty();
                        }
                    }
                })
            },
            utilitarios: function(){
                $('#add-conteudo').off('click').on('click', function(event){
                    event.preventDefault();
                    $('#crudConteudoModal').modal('show');
                });

                $('.pagination-link').off('click').on('click', function(event){
                    event.preventDefault(); // Evita o comportamento padrão do link
                    var clickedPage = $(this).data('page');

                    if(clickedPage == 0){
                        clickedPage = 1;
                    }

                    const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?page=' + clickedPage;
                    history.pushState({page: clickedPage}, '', newUrl);

                    ConteudosIndex.getAllConteudos(clickedPage); // Chama a função para carregar a página selecionada
                });

                $('.edit-conteudo').unbind().click(function(){
                    var conteudoId = $(this).data('conteudo-id');

                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'conteudos', 'action' => 'getConteudo']) ?>/'+conteudoId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response){
                            $('#conteudo-id').val(response.data.id);
                            $('#conteudo-title').val(response.data.title);
                            $('#conteudo-url').val(response.data.url);
                            $('#conteudo-author').val(response.data.author);
                            $('#selected-playlist-option').val(response.data.playlist_id);
                            $('#crudConteudoModal').modal('show');
                        },
                        error: function() {
                            GlobalScript.showErrorMessage('Erro', 'Erro ao editar a Conteúdo.');
                        }
                    });
                });

                $('#saveConteudoChanges').off('click').on('click', function(event){
                    event.preventDefault();
                    var id = $('#conteudo-id').val();
                    var urlRequest = '<?php echo $this->Url->build(['controller' => 'conteudos', 'action' => 'add']) ?>';
                    var message = 'Tem certeza que deseja salvar esse conteúdo?';

                    if(id){
                        urlRequest = '<?php echo $this->Url->build(['controller' => 'conteudos', 'action' => 'edit']) ?>/'+id;
                        message = 'Tem certeza que deseja salvar as alterações?';
                    }

                    var dataConteudo = $('#crudConteudoForm').serialize();

                    ConteudosIndex.confirmOperation(message, urlRequest, dataConteudo, 'addOrEdit');
                });

                $('.delete-conteudo').unbind().click(function(){
                    var conteudoId = $(this).data('conteudo-id');
                    var urlRequest = '<?= $this->Url->build(['controller' => 'conteudos', 'action' => 'delete']) ?>';

                    ConteudosIndex.confirmOperation('Tem certeza que deseja excluir esse registro?', urlRequest, {id: conteudoId}, 'delete');
                });

                $('.view-conteudo').unbind().click(function(){
                    var conteudoId = $(this).data('conteudo-id');
                    $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'conteudos', 'action' => 'getConteudo']) ?>/'+conteudoId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response){
                            if(response.success){
                                window.location.href = '<?= $this->Url->build(['controller' => 'conteudos', 'action' => 'view']) ?>/' + conteudoId;
                            }else{
                                GlobalScript.showErrorMessage('Erro', 'Erro ao atualizar o conteúdo.');
                            }
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 404) {
                                GlobalScript.showErrorMessage('Erro', 'Conteúdo não encontrado.');
                            } else {
                                GlobalScript.showErrorMessage('Erro', 'Erro ao carregar o conteúdo.');
                            }
                        }
                    });
                });
            },
            confirmOperation: function(modalTitle = '', url = '', data = [], functionTriggered = ''){
                Swal.fire({
                    title: modalTitle,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    denyButtonText: "Não",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        ConteudosIndex.requestOperation(url, data, functionTriggered);
                    } else if (result.isDenied) {
                        GlobalScript.showInfoMessage("Operação cancelada");
                    }
                });
            },
            requestOperation: function(url, dataConteudo, functionTriggered) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: dataConteudo,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            GlobalScript.showSuccessMessage('Sucesso!', response.message);
                        } else {
                            GlobalScript.showErrorMessage('Erro!', response.message);
                        }

                        if(!isView){
                            ConteudosIndex.reloadConteudos(1000);
                        }else{
                            if(functionTriggered == 'delete'){
                                setTimeout(function() {
                                    window.history.back();
                                }, 1000);
                            }else{
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        }
                    },
                    error: function() {
                        GlobalScript.showErrorMessage('Erro!', 'Erro na requisição.');
                    }
                });

                $('#crudConteudoModal').modal('hide');
            },
            reloadConteudos: function(timeout = 0) {
                setTimeout(function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const paramsPage = urlParams.get('page') || 1;
                    ConteudosIndex.getAllConteudos(paramsPage);
                }, timeout);
            }
        }

        ConteudosIndex.init();
    });
</script>