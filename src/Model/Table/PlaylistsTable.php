<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use ArrayObject;


class PlaylistsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('playlists');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Conteudos', [
            'foreignKey' => 'playlist_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }
    
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

    /**
    *    https://book.cakephp.org/5/en/orm/retrieving-data-and-resultsets.html#map-reduce
    *
    *    Função para modificar o campo create_at e updated_at para o padrão "d/m/Y H:i"
    */
    public function afterFindFunction($playlists)
    {
        $mapper = function ($playlist, $key, $mapReduce) {
            if (!empty($playlist->created_at)) {
                $playlist->created_at = $playlist->created_at->format('d/m/Y H:i');
            }
            if (!empty($playlist->updated_at)) {
                $playlist->updated_at = $playlist->updated_at->format('d/m/Y H:i');
            }
            $mapReduce->emit($playlist);
        };

        $reducer = function ($playlist, $key, $mapReduce) {
            $mapReduce->emit($playlist);
        };

        return $playlists->mapReduce($mapper, $reducer)->toArray();
    }

    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    {
        // Atualiza o campo updated_at ao editar uma playlist
        if (!$entity->isNew()) {
            $entity->updated_at = date('Y-m-d H:i:s');
        }
    }

    public function getAllPlaylists(){
        $playlists = $this->find();
        return [
            'success' => true,
            'data' => $this->afterFindFunction($playlists)
        ];
    }

    public function getAllPlaylistsAjax($page = 1, $offset = 0){
        $limit = 10;

        if($page > 2){
            $offset = ($page-1) * $limit;
        }elseif($page == 2){
            $offset = $limit;
        }

        $playlists = $this->find()->limit($limit)->offset($offset);
        
        $quantityPlaylists = $this->find()->count();
        $totalPages = ceil($quantityPlaylists / $limit);
        $hasNextPage = false;
        $hasPreviusPage = false;

        if($page <= $totalPages && $page > 0){
            $hasPreviusPage = true;
        }

        if($page <= $totalPages && $page > 0 && $page < $totalPages){
            $hasNextPage = true;
        }

        if(!empty($playlists) && $page <= $totalPages){
            return [
                'success' => true,
                'message' => 'Playlists encontradas.',
                'data' => $this->afterFindFunction($playlists),
                'pagination' => [
                    'current_page' => $page,
                    'pages' => $totalPages,
                    'hasNextPage' => $hasNextPage,
                    'hasPreviusPage' => $hasPreviusPage,
                ]
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Não foram encontradas playlists.'
            ];
        }
    }

    public function addPlaylist($data = []){
        $playlist = $this->newEmptyEntity();
        $playlist = $this->patchEntity($playlist, $data);
        
        if ($this->save($playlist)) {
            return [
                'success' => true,
                'data' => $playlist,
                'message' => 'Playlist adicionada com sucesso'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao adicionar a playlist, por favor, recarregue a página e tente novamente'
            ];
        }
    }

    public function deletePlaylist(int $id){
        $playlist = $this->get($id);

        if($this->delete($playlist)){
            return [
                'success' => true,
                'message' => 'Playlist excluída com sucesso'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao excluir a playlist, por favor, recarregue a página e tente novamente'
            ];
        }
    }

    public function editPlaylist($id = null, $data = []){
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
