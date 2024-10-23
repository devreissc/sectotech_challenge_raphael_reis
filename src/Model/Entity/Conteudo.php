<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Conteudo Entity
 *
 * @property int $id
 * @property int $playlist_id
 * @property string $title
 * @property string $url
 * @property string|null $author
 * @property \Cake\I18n\DateTime|null $created_at
 * @property \Cake\I18n\DateTime|null $updated_at
 *
 * @property \App\Model\Entity\Playlist $playlist
 */
class Conteudo extends Entity
{
    protected array $_accessible = [
        'playlist_id' => true,
        'title' => true,
        'url' => true,
        'author' => true,
        'created_at' => true,
        'updated_at' => true,
        'playlist' => true,
    ];
}
