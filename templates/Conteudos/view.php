<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card p-4" style="border-radius: 8px; min-height: calc(100vh - 380px);" >
                    <div class="row d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 px-4 mb-4 border-bottom">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <span class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis fs-2"><?= __('Título: ') . h($conteudo->title) ?></span>
                        </div>
                        <div class="col-auto col-md-auto mb-2 justify-content-center mb-md-0">
                            <a href="javascript:;" class="btn btn-secondary edit-conteudo mx-1 text-right fs-4" data-conteudo-id="<?= h($conteudo->id) ?>">Editar</a>
                            <a href="javascript:;" class="btn btn-danger delete-conteudo mx-1 text-right fs-4" data-conteudo-id="<?= h($conteudo->id) ?>">Excluir</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive p-4">
                            <table>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <td><?= $this->Number->format($conteudo->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Título') ?></th>
                                    <td><?= h($conteudo->title) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Playlist') ?></th>
                                    <td><?= $conteudo->hasValue('playlist') ? $this->Html->link($conteudo->playlist->title, ['controller' => 'Playlists', 'action' => 'view', $conteudo->playlist->id]) : '' ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('URL') ?></th>
                                    <td><?= h($conteudo->url) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Autor') ?></th>
                                    <td><?= h($conteudo->author) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Criado em') ?></th>
                                    <td><?= h($conteudo->created_at) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Atualizado em') ?></th>
                                    <td><?= h($conteudo->updated_at) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $this->element('scripts/conteudoIndexScript') ?>
<?php echo $this->element('modais/modal_edit_conteudo'); ?>