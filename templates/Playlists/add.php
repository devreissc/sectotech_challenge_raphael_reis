<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            Informações da Playlist
        </h1>
    </div>
    <div class="col-12">
        <?= $this->Form->create(null, ['url' => ['controller' => 'playlists', 'action' => 'add'], 'class' => 'needs-validation', 'novalidate' => true]) ?>
            <div class="row my-2">
                <div class="col-12">
                    <label class="form-label"><?php echo __('Título') ?></label>
                    <input name="title" type="text" class="form-control" id="frm-playlist-title" required>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-12">
                    <label class="form-label"><?php echo __('Descrição') ?></label>
                    <textarea name="description" type="text" class="form-control" id="frm-playlist-description" required></textarea>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-12">
                    <label class="form-label"><?php echo __('Autor') ?></label>
                    <input name="author" type="text" class="form-control" id="frm-playlist-author" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-primary mt-3" type="submit">Salvar</button>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>