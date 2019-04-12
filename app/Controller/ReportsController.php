<?php

class ReportsController extends AppController {
    public $helpers = array('Html', 'Form');

    public function index() {
        $this->set('reports', $this->Report->find('all'));
        $this->set('shares', $this->Report->Share->find('all'));
    }

    public function mypage($id = null) {

        if ($this->request->is('post')) {
            if ($this->Report->saveAssociated($this->request->data, array('deep' => true))) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'mypage'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
        $user_id = $this->Auth->user('id');
        $report = $this->Report->find('all',
        array('order' => array('Report.created' => 'desc'),
        'conditions' => array('Report.user_id' => $user_id),
        'limit' => 1,     
        ));
        $this->set('report', $report[0]);
        $this->set('shares', $this->Report->Share->find('all', 
            array('order' => 'Share.created ASC',
            'limit' => 20))
        );
        
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $report = $this->Report->findById($id);
        if (!$report) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('report', $report);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Report->create();
            if ($this->Report->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
    
        $report = $this->Report->findById($id);
        if (!$report) {
            throw new NotFoundException(__('Invalid post'));
        }
    
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Report->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to update your post.'));
        }
    
        if (!$this->request->data) {
            $this->request->data = $report;
        }
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
    
        if ($this->Report->delete($id)) {
            $this->Session->setFlash(
                __('The post with id: %s has been deleted.', h($id))
            );
        } else {
            $this->Session->setFlash(
                __('The post with id: %s could not be deleted.', h($id))
            );
        }
    
        return $this->redirect(array('action' => 'index'));
    }

    //操作承認用コード
    //$this->request->data['Report']['user'] = $this->Auth->user('id');

    public function isAuthorized($user) {
        // 登録済ユーザーは投稿できる
        if ($this->action === 'add') {
            return true;
        }
        if ($this->action === 'index'){
            //$this->autoLayout = false;  // レイアウトをOFFにする
            return true;
        }
        if ($this->action === 'view'){
            return true;
        }    
        // 投稿のオーナーは編集や削除ができる
        if (in_array($this->action, array('edit', 'delete'))) {
            $reportId = (int) $this->request->params['pass'][0];
            if ($this->Report->isOwnedBy($reportId, $user['id'])) {
                return true;
            }
        }
    
        return parent::isAuthorized($user);
    }

    public function create_work($id) {
        $data = array('Work' =>
                    array('report_id' => $id,
                          'created' => date ("y/m/t/h/i")
                    )
        );
        $this->Report->Work->create();
        if ($this->Report->Work->save($data)) {
            $this->Session->setFlash(__(date ("y/m/t/h:i") . '追加できました'));
        } else {
            $this->Session->setFlash(__('追加できませんでした'));
        }
        return $this->redirect(array('controller' => 'reports', 'action' => 'mypage'));
    }

    public function delete_work($id) {
        if ($this->Report->Work->delete($id)) {
            $this->Session->setFlash(__('削除できました'));
        } else {
            $this->Session->setFlash(__('削除できませんでした'));
        }
        return $this->redirect(array('controller' => 'reports', 'action' => 'mypage'));
    }

    public function create_share($id) {
        $data = array('Share' =>
                    array('report_id' => $id,
                          'created' => date ("y/m/t/h/i")
                    )
        );
        $this->Report->Share->create();
        if ($this->Report->Share->save($data)) {
            $this->Session->setFlash(__(date ("y/m/t/h:i") . '追加できました'));
        } else {
            $this->Session->setFlash(__('追加できませんでした'));
        }
        return $this->redirect(array('controller' => 'reports', 'action' => 'mypage'));
    }

    public function delete_share($id) {
        if ($this->Report->Share->delete($id)) {
            $this->Session->setFlash(__('削除できました'));
        } else {
            $this->Session->setFlash(__('削除できませんでした'));
        }
        return $this->redirect(array('controller' => 'reports', 'action' => 'mypage'));
    }

    public function create_report($users)
    {
        //日報の作成
        foreach ($users as $user):
        $data = array('Report' => 
                    array('user_id' => $user['User']['id'],
                        'title' => date("m/t") . $user['User']['username'] . "'日報",
                        'created' => date ("y/m/t/h/i")    
                    )
        );
        $this->Report->create();
        $this->Report->save($data);
        endforeach;
    }
}