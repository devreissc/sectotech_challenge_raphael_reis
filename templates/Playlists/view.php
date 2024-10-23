<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Playlist'), ['action' => 'edit', $playlist->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Playlist'), ['action' => 'delete', $playlist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $playlist->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Playlists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Playlist'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="playlists view content">
            <h3><?= h($playlist->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($playlist->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($playlist->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Author') ?></th>
                    <td><?= h($playlist->author) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($playlist->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($playlist->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($playlist->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Conteudos') ?></h4>
                <?php if (!empty($playlist->conteudos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Playlist Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Author') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($playlist->conteudos as $conteudo) : ?>
                        <tr>
                            <td><?= h($conteudo->id) ?></td>
                            <td><?= h($conteudo->playlist_id) ?></td>
                            <td><?= h($conteudo->title) ?></td>
                            <td><?= h($conteudo->url) ?></td>
                            <td><?= h($conteudo->author) ?></td>
                            <td><?= h($conteudo->created_at) ?></td>
                            <td><?= h($conteudo->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Conteudos', 'action' => 'view', $conteudo->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Conteudos', 'action' => 'edit', $conteudo->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Conteudos', 'action' => 'delete', $conteudo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $conteudo->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>