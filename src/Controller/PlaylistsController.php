<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

class PlaylistsController extends AppController
{
    public function index(){}

    public function getAllPlaylists($page = null){
        $this->autoRender = false; // Desativa o auto render
        $this->viewBuilder()->setLayout('ajax');

        if(!is_null($page)){
            if($page == 0){
                $page = 1;
            }
            $playlists = $this->Playlists->getAllPlaylistsAjax($page);
            return $this->response->withType('application/json')->withStringBody(json_encode($playlists));
        }else{
            $playlists = $this->Playlists->getAllPlaylists();
            return $this->response->withType('application/json')->withStringBody(json_encode($playlists));
        }
    }

    public function view($id = null)
    {
        try {
            $playlist = $this->Playlists->get($id, contain: ['Conteudos']);
            $this->set(compact('playlist'));
        }catch (RecordNotFoundException $e) {
            // Exibe uma mensagem de erro e redireciona o usuário
            $this->Flash->error(__('A playlist não foi encontrada.'));
            return $this->redirect(['action' => 'index']); // Redireciona para a lista de playlists
        }
        
    }

    public function add()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);

        $response = $this->Playlists->addPlaylist($this->request->getData());

        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    public function edit($id = null)
    {   
        $this->autoRender = false;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $resultado = $this->Playlists->editPlaylist($id, $data);
            return $this->response->withType('application/json')->withStringBody(json_encode($resultado));
        }
    }

    public function delete()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');
        $response = $this->Playlists->deletePlaylist((int)$id);

        // Retorna a resposta com JSON
        return $this->response->withType('application/json')->withStringBody(json_encode($response));
    }

    public function getPlaylist($id = null){
        $this->request->allowMethod(['get']);
        
        $playlist = $this->Playlists->get($id);
        
        if($playlist){
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'data' => $playlist
            ]));
        }else{
            return $this->response->withStatus(404)->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'error' => 'Playlist não encontrada.'
            ]));
        }
    }
}