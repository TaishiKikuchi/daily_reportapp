<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    public $helpers = ['Html', 'Form', 'Session'];

    public function beforeFilter()
    {
        $this->Auth->allow('logout', 'add', 'login');
        parent::beforeFilter();
    }

    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->User->validates()) {
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__('The user has been saved'));
                    if ($this->Auth->login()) {
                        $this->redirect($this->Auth->redirect(['controller' => 'reports','action' => 'mypage']));
                    } else {
                        $this->Session->setFlash(__('Invalid username or password, try again'));
                    }
                    //return $this->redirect(array('controller' => 'users', 'action' => 'login'));
                }
                $this->Session->setFlash(
                    __('The user could not be saved. Please, try again.')
                );
            } else {
                $this->Session->setFlash(
                    __('validatation error Please, try again.')
                );
            }
        }
    }

    public function edit($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(['controller' => 'Reports','action' => 'mypage']);
            }
            $this->Session->setFlash(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
            $this->set('user', $this->User->findById($id));
        }
    }

    public function delete($id = null)
    {
        // cakephp2.4まではこれ
        $this->request->onlyAllow('post');

        //$this->request->allowMethod('post');
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Session->setFlash(__('User was not deleted'));
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect(['controller' => 'reports','action' => 'mypage']));
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

    public function getUsers($id = null)
    {
        //現在のユーザー情報を取得する
        if (isset($id)) {
            $this->User->id = $id;
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            //$tmp =  $this->User->find('first', array('conditions' => array('id' => $id))); したと同じ挙動する
            $tmp =  $this->User->findById($id);
            $users = $tmp['User']['task'];
        } else {
            $users = $this->User->find('all');
        }
        return $users;
    }
    public function isAuthorized($user)
    {
        //ユーザー登録は許可
        if ($this->action === 'add') :
            return true;
        endif;

        // 投稿のオーナーは編集や削除ができる
        if (in_array($this->action, ['edit', 'delete'])) :
            $page_id = (int) $this->request->params['pass'][0];
            $this->log($page_id, LOG_DEBUG);
            $this->log($user['id'], LOG_DEBUG);
            if ($this->User->isOwnedBy($page_id, $user['id'])) :
                return true;
            endif;
        endif;

        return parent::isAuthorized($user);
    }
}
