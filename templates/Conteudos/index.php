<section class="">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col col-6 d-flex align-items-center mb-3">
                <h1 class="text-dark font-bold"><?php echo __('Conteúdos') ?></h1>
            </div>
            
            <div class="col-auto mb-3 justify-content-end">
                <a href="javascript:;" id="add-conteudo" style="font-size: larger;" class="btn btn-2 btn-primary text-white btn-block px-4 py-2 me-3 text-nowrap"><?= __('Novo Conteúdo') ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card p-4" style="border-radius: 8px; min-height: calc(100vh - 380px);" >
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <div id="tabela-conteudos"></div>
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

<?php echo $this->element('scripts/conteudoIndexScript') ?>
<?php echo $this->element('modais/modal_edit_conteudo'); ?>