<div class="conteudos index content">
    <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Conteúdos') ?></h3>
    
    <div id="tabela-conteudos"></div>
    <div>
        <nav>
            <ul class="pagination" id="pagination-links"></ul>
        </nav>
    </div>
</div>

<script>
    $(document).ready(function(){
        var ConteudosIndes = {
            init: function(){
                ConteudosIndes.getAllConteudos();
            },
            getAllConteudos: function(page = 1){
                alert('1');
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
                        if(response.success){
                            var html = '<table>';
                            html += '<tr><th>ID</th><th>Playlist</th><th>Título</th><th>URL</th><th>Autor</th><th>Data de criação</th><th>Última atualização</th><th>Ações</th></tr>';
                            response.data.forEach(function(conteudo) {
                                html += '<tr>';
                                html += '<td>' + conteudo.id + '</td>';
                                html += '<td>' + conteudo.playlist.title + '</td>';
                                html += '<td>' + conteudo.title + '</td>';
                                html += '<td>' + conteudo.url + '</td>';
                                html += '<td>' + conteudo.author + '</td>';
                                html += '<td>' + conteudo.created_at + '</td>';
                                html += '<td>' + conteudo.updated_at + '</td>';
                                html += '<td><a href="javascript:;" class="btn btn-primary view-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Visualizar</a>'
                                    + '<a href="javascript:;" class="btn btn-secondary edit-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Editar</a>'
                                    + '<a href="javascript:;" class="btn btn-danger delete-conteudo mx-1" data-conteudo-id="' + conteudo.id + '">' + 'Excluir</a>'
                                    + '</td>';
                                html += '</tr>';
                            });
                            html += '</table>';

                            // Insere o HTML gerado na div
                            $('#tabela-conteudos').html(html);

                            $('#pagination-links').empty();
                            var link = '';
                            // Cria links de paginação
                            for (var i = 1; i <= response.pagination.pages; i++) {
                                link = '<li class="page-item ' + (response.pagination.current_page == i ? 'active' : '') + '"><a href="javascript:;" class="pagination-link page-link" data-page="' + i + '">' + i + '</a></li>';
                                $('#pagination-links').append(link);
                            }

                            ConteudosIndes.utilitarios();
                        }else {
                            $('#tabela-conteudos').html('<p>Nenhum conteúdo encontrado.</p>');
                            $('#pagination-links').empty();
                        }
                    }
                })
            },
            utilitarios: function(){
                alert('2');
            }
        }

        ConteudosIndes.init();
    });
</script>