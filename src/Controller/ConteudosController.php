<?php
declare(strict_types=1);

namespace App\Controller;


use Cake\Datasource\Exception\RecordNotFoundException;

class ConteudosController extends AppController
{
    public function index(){}

    public function getAllConteudos($page = null){
        $this->autoRender = false; // Desativa o auto render
        $this->viewBuilder()->setLayout('ajax');
        if($page == 0){
            $page = 1;
        }

        if(!is_null($page)){
            $conteudos = $this->Conteudos->getAllConteudosAjax($page);

            return $this->response->withType('application/json')->withStringBody(json_encode($conteudos));
        }
    }

    public function view($id = null)
    {
        try {
            $conteudo = $this->Conteudos->get($id, contain: ['Playlists']);
            $this->set(compact('conteudo'));
        }catch (RecordNotFoundException $e) {
            $this->Flash->error(__('O conteúdo não foi encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function getConteudo($id = null){
        $this->request->allowMethod(['get']);
        
        $conteudo = $this->Conteudos->get($id);
        
        if($conteudo){
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'data' => $conteudo
            ]));
        }else{
            return $this->response->withStatus(404)->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'error' => 'Conteúdo não encontrado.'
            ]));
        }
    }

    public function add()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        
        $response = $this->Conteudos->addConteudo($this->request->getData());
        
        // Retorna a resposta com JSON
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    public function edit($id = null)
    {
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $resultado = $this->Conteudos->editConteudo($id, $data);
            return $this->response->withType('application/json')->withStringBody(json_encode($resultado));
        }
    }

    public function delete()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');

        $response = $this->Conteudos->deleteConteudo((int) $id);
        
        // Retorna a resposta com JSON
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }
}
