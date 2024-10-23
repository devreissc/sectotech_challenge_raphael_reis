<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Conteudo $conteudo
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Conteudo'), ['action' => 'edit', $conteudo->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Conteudo'), ['action' => 'delete', $conteudo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conteudo->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Conteudos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Conteudo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="conteudos view content">
            <h3><?= h($conteudo->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Playlist') ?></th>
                    <td><?= $conteudo->hasValue('playlist') ? $this->Html->link($conteudo->playlist->title, ['controller' => 'Playlists', 'action' => 'view', $conteudo->playlist->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($conteudo->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($conteudo->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= h($conteudo->author) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($conteudo->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($conteudo->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($conteudo->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>