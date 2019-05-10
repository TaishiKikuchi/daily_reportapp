<?php
App::uses('HttpSocket', 'Network/Http');
App::import("Controller", "Users");

class ReportsController extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $components = array('Paginator');

    public $paginate = [
        'limit' => 5
    ];

    public function index($code = null)
    {
        if (empty($this->request->data) || $this->request->data['code'] == 7) {
            $code = [
                7, 1, 2, 3, 4, 5, 6
            ];
        } else {
            $code = $this->request->data['code'];
        }
        $this->log($code, LOG_DEBUG);
        //$this->autoLayout = false;
        $reports = $this->Report->find('all', [
            'conditions' => [
                'Report.created >=' => date("Y/m/d"),
                'User.departmentcode' => $code
            ]
        ]);

        $this->set('reports', $reports);
        $this->set('code', $code);
        $this->set('subtitle', '日報一覧');
    }

    
    public function shareindex()
    {
        $this->Paginator->settings = $this->paginate = [
            'conditions' => [
                'NOT' => [
                    'content' => null
                ]
            ],
            'limit' => 5,
            'order' => ['Share.created' => 'desc']
        ];

        $data = $this->Paginator->paginate('Share');
        $this->set('shares', $data);

        $this->set('subtitle', '共有一覧');
    }

    public function mypage($id = null)
    {
        $this->loadModel('User');
        //$this->log($this->request->data, LOG_DEBUG);
        if ($this->request->is('post')) {
            $this->log($this->request->data, LOG_DEBUG);
            if ($this->Report->saveAssociated($this->request->data, ['deep' => true])) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(['action' => 'mypage']);
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
        $user_id = $this->Auth->user('id');
        //ここの処理はmodel側でやらせるべき？

        $report = $this->Report->find('all', [
            'order' => ['Report.created' => 'desc'],
            'conditions' => [
                'Report.user_id' => $user_id,
                'Report.created >=' => date("Y/m/d")
            ],
            'limit' => 1
        ]);

        if ($report) {
            $this->set('report', $report[0]);
        } else {
            $this->set('report', null);
        }
        //ここはまあそのままでokのようなきがする
        $this->set('shares', $this->Report->Share->find('all', [
                'order' => 'Share.created ASC',
                'limit' => 20
        ]));

        $task = $this->User->findById($user_id);
        $this->set('task', $task['User']['task']);

        $this->set('subtitle', 'マイページ');
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $report = $this->Report->findById($id);
        if (!$report) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('report', $report);
        $this->set('subtitle', '日報詳細');
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Report->create();
            if ($this->Report->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
    
        $report = $this->Report->findById($id);
        if (!$report) {
            throw new NotFoundException(__('Invalid post'));
        }
    
        if ($this->request->is(['post', 'put'])) {
            if ($this->Report->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Session->setFlash(__('Unable to update your post.'));
        }
    
        if (!$this->request->data) {
            $this->request->data = $report;
        }
    }

    public function delete($id)
    {
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
    
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        // 登録済ユーザーは投稿できる
        if ($this->action === 'add') {
            return true;
        }
        if ($this->action === 'index') {
            //$this->autoLayout = false;  // レイアウトをOFFにする
            return true;
        }
        if ($this->action === 'view') {
            return true;
        }
        // 投稿のオーナーは編集や削除ができる
        if (in_array($this->action, ['edit', 'delete'])) {
            $reportId = (int) $this->request->params['pass'][0];
            if ($this->Report->isOwnedBy($reportId, $user['id'])) {
                return true;
            }
        }
    
        return parent::isAuthorized($user);
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'logout');
    }
/*
    public function create_work($id)
    {
        $data = ['Work' => [
                        'report_id' => $id,
                        'created' => date("Y/m/d H:i")
        ]];

        $this->Report->Work->create();
        if ($this->Report->Work->save($data)) {
            $this->Session->setFlash(__(date("Y/m/d H:i") . '追加できました'));
        } else {
            $this->Session->setFlash(__('追加できませんでした'));
        }
        return $this->redirect(['controller' => 'reports', 'action' => 'mypage']);
    }
*/

    public function delete_work($id)
    {
        if ($this->Report->Work->delete($id)) {
            $this->Session->setFlash(__('削除できました'));
        } else {
            $this->Session->setFlash(__('削除できませんでした'));
        }
        return $this->redirect(['controller' => 'reports', 'action' => 'mypage']);
    }
/*
    public function create_share($id)
    {
        $data = ['Share' => [
                        'report_id' => $id,
                        'created' => date("Y/m/d H:i")
        ]];

        $this->Report->Share->create();
        if ($this->Report->Share->save($data)) {
            $this->Session->setFlash(__(date("Y/m/d H:i")   . '追加できました'));
        } else {
            $this->Session->setFlash(__('追加できませんでした'));
        }
        return $this->redirect(['controller' => 'reports', 'action' => 'mypage']);
    }
*/
    public function delete_share($id)
    {
        if ($this->Report->Share->delete($id)) {
            $this->Session->setFlash(__('削除できました'));
        } else {
            $this->Session->setFlash(__('削除できませんでした'));
        }
        return $this->redirect(['controller' => 'reports', 'action' => 'mypage']);
    }

    public function create_report($users)
    {
        //日報の作成
        foreach ($users as $user) :
            $data = ['Report' => [
                        'user_id' => $user['User']['id'],
                        'title' => date("m/d") . $user['User']['username'] . "'日報",
                        'created' => date("Y/m/d H:i")
            ]];

            $this->Report->create();
            $this->Report->save($data);
        endforeach;
    }
}
