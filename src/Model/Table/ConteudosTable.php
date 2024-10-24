<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use ArrayObject;

class ConteudosTable extends Table
{
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

    public function afterFindFunction($conteudos)
    {
        $mapper = function ($conteudo, $key, $mapReduce) {
            if (!empty($conteudo->created_at)) {
                $conteudo->created_at = $conteudo->created_at->format('d/m/Y H:i');
            }
            if (!empty($conteudo->updated_at)) {
                $conteudo->updated_at = $conteudo->updated_at->format('d/m/Y H:i');
            }
            $mapReduce->emit($conteudo);
        };

        $reducer = function ($conteudo, $key, $mapReduce) {
            $mapReduce->emit($conteudo);
        };

        return $conteudos->mapReduce($mapper, $reducer)->toArray();
    }

    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    {
        // Atualiza o campo updated_at ao editar um conteúdo 
        if (!$entity->isNew()) {
            $entity->updated_at = date('Y-m-d H:i:s');
        }
    }

    public function getAllConteudos(){
        return $this->find();
    }

    public function getConteudosByPlaylistId($playlistId)
    {
        $conteudosByPlaylistId = $this->find('all')->where(['playlist_id' => $playlistId])->orderByDesc('created_at');
        return $this->afterFindFunction($conteudosByPlaylistId);
    }

    public function getAllConteudosAjax($page = 1){
        $limit = 10;
        $offset = 0;

        if($page > 2){
            $offset = ($page-1) * $limit;
        }elseif($page == 2){
            $offset = $limit;
        }

        $conteudos = $this->find()->select([
            'id',
            'title',
            'url',
            'author',
            'created_at',
            'updated_at',
            'playlist_id',
            'Playlists.title'
        ])->contain(['Playlists'])->limit($limit)->offset($offset);

        $quantityConteudos = $this->find()->count();
        
        if(!empty($conteudos)){
            return [
                'success' => true,
                'message' => 'Conteúdos encontradas.',
                'data' => $this->afterFindFunction($conteudos),
                'pagination' => [
                    'current_page' => $page,
                    'pages' => ceil($quantityConteudos / $limit)
                ]
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Não foi encontrado nenhum conteúdo.'
            ];
        }
    }

    public function editConteudo($id = null, $data = []){
        if(is_null($id) || empty($data)){
            return [
                'success' => false,
                'message' => 'Erro, os dados necessários para realizar a atualização não foram encontrados'
            ];
        }else{
            $conteudo = $this->get($id);
            $conteudo = $this->patchEntity($conteudo, $data);

            if ($this->save($conteudo)) {
                return [
                    'success' => true,
                    'message' => 'Conteúdo atualizado com sucesso.',
                    'data' => $conteudo
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erro ao atualizar o conteúdo.'
                ];
            }
        }
    }

    public function addConteudo($data = []){
        $conteudo = $this->newEmptyEntity();
        $conteudo = $this->patchEntity($conteudo, $data);
        
        if ($this->save($conteudo)) {
            return [
                'success' => true,
                'data' => $conteudo,
                'message' => 'Conteúdo adicionado com sucesso'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao adicionar o conteúdo, por favor, recarregue a página e tente novamente'
            ];
        }
    }

    public function deleteConteudo(int $id){
        $conteudo = $this->get($id);

        if($this->delete($conteudo)){
            return [
                'success' => true,
                'message' => 'Conteúdo excluído com sucesso'
            ];
        }else{
            return [
                'success' => false,
                'message' => 'Erro ao excluir o conteúdo, por favor, recarregue a página e tente novamente'
            ];
        }
    }
}
