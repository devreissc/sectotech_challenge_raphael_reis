<?php
declare(strict_types=1);

namespace App\Controller;

class ConteudosController extends AppController
{
    public function index(){}

    public function getAllConteudos($page = 1){
        $this->autoRender = false; // Desativa o auto render
        $this->viewBuilder()->setLayout('ajax');

        $conteudos = $this->Conteudos->getAllConteudosAjax($page);
        return $this->response->withType('application/json')->withStringBody(json_encode($conteudos));
    }

    public function view($id = null)
    {
        $conteudo = $this->Conteudos->get($id, contain: ['Playlists']);
        $this->set(compact('conteudo'));
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
        $conteudo = $this->Conteudos->newEmptyEntity();
        if ($this->request->is('post')) {
            $conteudo = $this->Conteudos->patchEntity($conteudo, $this->request->getData());
            if ($this->Conteudos->save($conteudo)) {
                $this->Flash->success(__('The conteudo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conteudo could not be saved. Please, try again.'));
        }
        $playlists = $this->Conteudos->Playlists->find('list', limit: 200)->all();
        $this->set(compact('conteudo', 'playlists'));
    }

    public function edit($id = null)
    {
        $conteudo = $this->Conteudos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conteudo = $this->Conteudos->patchEntity($conteudo, $this->request->getData());
            if ($this->Conteudos->save($conteudo)) {
                $this->Flash->success(__('The conteudo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conteudo could not be saved. Please, try again.'));
        }
        $playlists = $this->Conteudos->Playlists->find('list', limit: 200)->all();
        $this->set(compact('conteudo', 'playlists'));
    }

    public function delete()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');
        $conteudo = $this->Conteudos->get($id);

        if ($this->Conteudos->delete($conteudo)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'message' => 'Conteúdo excluída com sucesso'
            ]));
        } else {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Erro ao excluir o Conteúdo, por favor, recarregue a página e tente novamente'
            ]));
        }
    }
}
