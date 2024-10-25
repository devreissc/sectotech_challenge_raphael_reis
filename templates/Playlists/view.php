<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card p-4" style="border-radius: 8px; min-height: calc(100vh - 380px);" >
                    <div class="row d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-2 px-4 mb-4 border-bottom">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <span class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis fs-2"><?=__('Título: ') .  h($playlist->title) ?></span>
                        </div>
                        <div class="col-auto col-md-auto mb-2 justify-content-center mb-md-0">
                            <a href="javascript:;" class="btn btn-secondary edit-playlist mx-1 text-right fs-4" data-playlist-id="<?= h($playlist->id) ?>">Editar</a>
                            <a href="javascript:;" class="btn btn-danger delete-playlist mx-1 text-right fs-4" data-playlist-id="<?= h($playlist->id) ?>">Excluir</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-xxl-4 col-md-12 col-sm-12 table-responsive p-4">
                            <table>
                                <tr>
                                    <th><?= __('Id') ?></th>
                                    <td><?= $this->Number->format($playlist->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Título') ?></th>
                                    <td><?= h($playlist->title) ?></td>
                                </tr>
                                
                                <tr>
                                    <th><?= __('Descrição') ?></th>
                                    <td><?= h($playlist->description) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Autor') ?></th>
                                    <td><?= h($playlist->author) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Criado em') ?></th>
                                    <td><?= h($playlist->created_at) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Atualizado em') ?></th>
                                    <td><?= h($playlist->updated_at) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-8 col-xxl-8 col-md-12 col-sm-12  p-4" >
                            <p class="d-flex align-items-center mb-md-4 me-md-auto link-body-emphasis fs-3"><?= __('Conteúdo relacionados') ?></p>
                            <?php if (!empty($playlist->conteudos)) : ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th><?= __('Id') ?></th>
                                                <th><?= __('Título') ?></th>
                                                <th><?= __('Url') ?></th>
                                                <th><?= __('Autor') ?></th>
                                                <th class="text-center"><?= __('Cadastrado em') ?></th>
                                                <th class="text-center"><?= __('Atualizado em') ?></th>
                                                <th class="text-center"><?= __('Ações') ?></th>
                                            </tr>
                                        </thead>
                                        <?php foreach ($playlist->conteudos as $conteudo) : ?>
                                        <tr>
                                            <td><?= h($conteudo->id) ?></td>
                                            <td><?= h($conteudo->title) ?></td>
                                            <td><?= h($conteudo->url) ?></td>
                                            <td><?= h($conteudo->author) ?></td>
                                            <td class="text-center"><?= h($conteudo->created_at) ?></td>
                                            <td class="text-center"><?= h($conteudo->updated_at) ?></td>
                                            <td class="text-center">
                                                <a href="javascript:;" class="btn btn-primary view-conteudo mx-1" data-conteudo-id="<?= $conteudo->id ?>">Visualizar</a>
                                                <a href="javascript:;" class="btn btn-secondary edit-conteudo mx-1" data-conteudo-id="<?= $conteudo->id ?>">Editar</a>
                                                <a href="javascript:;" class="btn btn-danger delete-conteudo mx-1" data-conteudo-id="<?= $conteudo->id ?>">Excluir</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="fs-5">Não há conteúdos relacionados</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $this->element('scripts/playlistIndexScript') ?>
<?php echo $this->element('modais/modal_edit_playlist'); ?>
<?php echo $this->element('scripts/conteudoIndexScript') ?>
<?php echo $this->element('modais/modal_edit_conteudo'); ?>