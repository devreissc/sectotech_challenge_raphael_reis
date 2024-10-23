<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use function PHPUnit\Framework\isEmpty;

/**
 * Playlists Model
 *
 * @property \App\Model\Table\ConteudosTable&\Cake\ORM\Association\HasMany $Conteudos
 *
 * @method \App\Model\Entity\Playlist newEmptyEntity()
 * @method \App\Model\Entity\Playlist newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Playlist> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Playlist get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Playlist findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Playlist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Playlist> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Playlist|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Playlist saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Playlist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Playlist>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Playlist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Playlist> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Playlist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Playlist>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Playlist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Playlist> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PlaylistsTable extends Table
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

        $this->setTable('playlists');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Conteudos', [
            'foreignKey' => 'playlist_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 200)
            ->allowEmptyString('description');

        $validator
            ->scalar('author')
            ->maxLength('author', 150)
            ->requirePresence('author', 'create')
            ->notEmptyString('author');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }

    public function getAllPlaylists(){
        return $this->find();
    }

    // Adiciona Playlist
    public function addPlaylist($data = []){
        $playlist = $this->newEmptyEntity();
        $playlist = $this->patchEntity($playlist, $data);
        if ($this->save($playlist)) {
            return $playlist;
        }else{
            return null;
        }
    }

    public function edit($id = null, $data = []){
        if(is_null($id) || empty($data)){
            return [
                'success' => false,
                'message' => 'Erro, os dados necessários para realizar a atualização não foram encontrados'
            ];
        }else{
            $playlist = $this->get($id);
            $playlist = $this->patchEntity($playlist, $data);

            if ($this->save($playlist)) {
                return [
                    'success' => true,
                    'message' => 'Playlist atualizada com sucesso.',
                    'data' => $playlist
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar a playlist.'
                ];
            }
        }
    }
}
