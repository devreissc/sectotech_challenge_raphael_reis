<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Conteudos Model
 *
 * @property \App\Model\Table\PlaylistsTable&\Cake\ORM\Association\BelongsTo $Playlists
 *
 * @method \App\Model\Entity\Conteudo newEmptyEntity()
 * @method \App\Model\Entity\Conteudo newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Conteudo> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Conteudo get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Conteudo findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Conteudo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Conteudo> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Conteudo|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Conteudo saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Conteudo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conteudo>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conteudo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conteudo> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conteudo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conteudo>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Conteudo>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Conteudo> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ConteudosTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('conteudos');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('Playlists', [
            'foreignKey' => 'playlist_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('playlist_id')
            ->notEmptyString('playlist_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 150)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('author')
            ->maxLength('author', 150)
            ->allowEmptyString('author');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['playlist_id'], 'Playlists'), ['errorField' => 'playlist_id']);

        return $rules;
    }

    public function getAllConteudos(){
        return $this->find();
    }

    public function getConteudosByPlaylistId($playlistId)
    {
        return $this->find('all')->where(['playlist_id' => $playlistId])->orderByDesc('created_at');
    }
}
