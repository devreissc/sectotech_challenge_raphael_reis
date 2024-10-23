<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Conteudo> $conteudos
 */
?>
<div class="conteudos index content">
    <?= $this->Html->link(__('New Conteudo'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Conteudos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('playlist_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('author') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($conteudos as $conteudo): ?>
                <tr>
                    <td><?= $this->Number->format($conteudo->id) ?></td>
                    <td><?= $conteudo->hasValue('playlist') ? $this->Html->link($conteudo->playlist->title, ['controller' => 'Playlists', 'action' => 'view', $conteudo->playlist->id]) : '' ?></td>
                    <td><?= h($conteudo->title) ?></td>
                    <td><?= h($conteudo->url) ?></td>
                    <td><?= h($conteudo->author) ?></td>
                    <td><?= h($conteudo->created_at) ?></td>
                    <td><?= h($conteudo->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $conteudo->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $conteudo->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $conteudo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conteudo->id)]) ?>
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