<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


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

    public function getAllPlaylists(){
        return $this->find();
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
        $playlists->toArray();
        if(!empty($playlists)){
            return [
                'success' => true,
                'message' => 'Playlists encontradas.',
                'data' => $playlists,
                'pagination' => [
                    'current_page' => $page,
                    'pages' => ceil($quantityPlaylists / $limit)
                ]
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Não foram encontradas playlists.'
            ];
        }
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
