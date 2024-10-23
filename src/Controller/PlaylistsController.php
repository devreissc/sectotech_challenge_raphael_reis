<?php
declare(strict_types=1);

namespace App\Controller;

class PlaylistsController extends AppController
{
    public function index()
    {
        $query = $this->Playlists->getAllPlaylists();
        $playlists = $this->paginate($query);

        $this->set(compact('playlists'));
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
            $resultado = $this-> Playlists->edit($id, $data);
            return $this->response->withType('application/json')->withStringBody(json_encode($resultado));
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $playlist = $this->Playlists->get($id);

        if ($this->Playlists->delete($playlist)) {
            $this->Flash->success(__('The playlist has been deleted.'));
        } else {
            $this->Flash->error(__('The playlist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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