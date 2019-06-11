<?php

App::uses('HttpSocket', 'Network/Http');
App::import("Controller", "Reports");

class TrelloExclusionListsController extends AppController
{
    public function addTrelloExList()
    {
        $this->loadModel('Trello_exclusion_list');
        if ($this->request->is('post')) :
            $this->log($this->request->data, LOG_DEBUG);
            if ($this->Trello_exclusion_list->save($this->request->data, ['deep' => true])) :
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(['controller' => 'Reports','action' => 'mypage']);
            endif;
            $this->Session->setFlash(__('Unable to add your post.'));
            return $this->redirect(['action' => 'mypage']);
        endif;
    }
}