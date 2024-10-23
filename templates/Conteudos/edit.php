<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Conteudo $conteudo
 * @var string[]|\Cake\Collection\CollectionInterface $playlists
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $conteudo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $conteudo->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Conteudos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="conteudos form content">
            <?= $this->Form->create($conteudo) ?>
            <fieldset>
                <legend><?= __('Edit Conteudo') ?></legend>
                <?php
                    echo $this->Form->control('playlist_id', ['options' => $playlists]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('url');
                    echo $this->Form->control('author');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
