<div class="playlists index content">
    <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Playlists') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('author') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($playlists as $playlist): ?>
                <tr>
                    <td><?= $this->Number->format($playlist->id) ?></td>
                    <td class="playlist-title"><?= h($playlist->title) ?></td>
                    <td><?= h($playlist->description) ?></td>
                    <td><?= h($playlist->author) ?></td>
                    <td><?= h($playlist->created_at) ?></td>
                    <td><?= h($playlist->updated_at) ?></td>
                    <td class="actions">
                        <button class="btn btn-sm view-playlist" data-playlist-id="<?= $playlist->id ?>">Visualizar</button>
                        <?= $this->Html->link(__('Visualizar'), ['action' => 'view', $playlist->id]) ?>
                        <button class="edit-playlist" data-playlist-id="<?= $playlist->id ?>">Editar</button>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $playlist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playlist->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<script>
    $(document).ready(function(){
        var PlaylistIndex = {
            init: function(){
                PlaylistIndex.utilitarios();
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