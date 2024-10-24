<?php
declare(strict_types=1);

namespace App\Controller;

class PlaylistsController extends AppController
{
    public function index(){}

    public function getAllPlaylists($page = 0){
        $this->autoRender = false; // Desativa o auto render
        $this->viewBuilder()->setLayout('ajax');

        if($page > 0){
            $playlists = $this->Playlists->getAllPlaylistsAjax($page);
            return $this->response->withType('application/json')->withStringBody(json_encode($playlists));
        }else{
            $playlists = $this->Playlists->getAllPlaylists();
            return $this->response->withType('application/json')->withStringBody(json_encode($playlists));
        }
    }

    public function view($id = null)
    {
        $playlist = $this->Playlists->get($id, contain: ['Conteudos']);
        $this->set(compact('playlist'));
    }

    public function add()
    {
        $playlist = $this->Playlists->newEmptyEntity();

        if ($this->request->is('post')) 
        {
            $playlist = $this->Playlists->addPlaylist($this->request->getData());

            if ($playlist) 
            {
                $this->Flash->success(__('Playlist criada com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Erro ao criar a playlist. Por favor, tente novamente.'));
        }

        $this->set(compact('playlist'));
    }

    public function edit($id = null)
    {   
        $this->autoRender = false;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $resultado = $this->Playlists->edit($id, $data);
            return $this->response->withType('application/json')->withStringBody(json_encode($resultado));
        }
    }

    public function delete()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post', 'delete']);
        $id = $this->request->getData('id');
        $playlist = $this->Playlists->get($id);

        if ($this->Playlists->delete($playlist)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'message' => 'Playlist excluída com sucesso'
            ]));
        } else {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Erro ao excluir Playlist, por favor, recarregue a página e tente novamente'
            ]));
        }
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