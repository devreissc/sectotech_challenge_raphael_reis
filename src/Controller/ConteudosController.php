<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Conteudos Controller
 *
 * @property \App\Model\Table\ConteudosTable $Conteudos
 */
class ConteudosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Conteudos->getAllConteudos();
        $conteudos = $this->paginate($query);

        $this->set(compact('conteudos'));
    }

    /**
     * View method
     *
     * @param string|null $id Conteudo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conteudo = $this->Conteudos->get($id, contain: ['Playlists']);
        $this->set(compact('conteudo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
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

    /**
     * Edit method
     *
     * @param string|null $id Conteudo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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

    /**
     * Delete method
     *
     * @param string|null $id Conteudo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conteudo = $this->Conteudos->get($id);
        if ($this->Conteudos->delete($conteudo)) {
            $this->Flash->success(__('The conteudo has been deleted.'));
        } else {
            $this->Flash->error(__('The conteudo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
