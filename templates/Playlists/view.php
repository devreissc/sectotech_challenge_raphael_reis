<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card p-4" style="border-radius: 8px; min-height: calc(100vh - 380px);" id="playlist-container">
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $this->element('scripts/playlistIndexScript') ?>
<?php echo $this->element('modais/modal_edit_playlist'); ?>
<?php echo $this->element('scripts/conteudoIndexScript') ?>
<?php echo $this->element('modais/modal_edit_conteudo'); ?>

<script>
    $(document).ready(function() {
        var playlistId = <?= json_encode($id) ?>;
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Playlists', 'action' => 'getPlaylist']) ?>/' + playlistId,
            method: 'GET',
            dataType: 'html',
            success: function(response) {
                $('#playlist-container').html(response);
            },
            error: function() {
                $('#playlist-container').html('<p>Erro ao carregar a playlist.</p>');
            }
        });
    });
</script>