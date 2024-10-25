<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        $plugin = $this->request->getParam('plugin');
        $controller = $this->request->getParam('controller');
        $action = $this->request->getParam('action');

        $linkUrl = $plugin . '/' . $controller . '/' . $action;
        
        $this->set(compact('linkUrl'));
    }
    
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
    }
}
