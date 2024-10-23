<?php if (!empty($playlists)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($playlists as $playlist): ?>
                <tr>
                    <td><?= h($playlist->id) ?></td>
                    <td><?= h($playlist->title) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhuma playlist encontrada.</p>
<?php endif; ?>