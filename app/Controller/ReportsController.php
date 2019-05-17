<?php
App::uses('HttpSocket', 'Network/Http');
App::import("Controller", "Users");
App::import('Vendor', 'Google_Client', array('file' => 'google-api-php-client/src/Google/Client.php'));

class ReportsController extends AppController
{
    public $helpers = ['Html', 'Form'];
    public $components = array('Paginator', 'Session');

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
        $this->getGoogleClientToken();
        $this->loadModel('User');
        if ($this->request->is('post')) {
            if ($this->Report->saveAssociated($this->request->data, ['deep' => true])) {
                $this->Session->setFlash(__('Your post has been saved.'));
                $this->chwrite($this->request->data);
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
                'order' => 'Share.created DESC',
                'limit' => 20
        ]));

        $task = $this->User->findById($user_id);
        $this->set('task', $task['User']['task']);

        $this->set('subtitle', 'マイページ');
    }

    public function chwrite($post)
    {
        $room_id = "hogehoge";
        //ここから reportテキストをフォーマットに合わせて作る
        $title = $post['Report']['title'] . "\n";
        $workcontent = "【作業内容】\n";
        $timecontent = "【作業時間】\n";
        $sharecontent = "【気づき・共有】\n";
        foreach ($post['Work'] as $value) :
            $workcontent = $workcontent . " ・" . $value['subject'] . "\n" ;
            $timecontent = $timecontent . " ・" . $value['starttime']['hour'] . ":" . $value['starttime']['min'] . "~" . " " .
            $value['subject'] . "\n";
        endforeach;

        foreach ($post['Share'] as $value) :
            $sharecontent = $sharecontent . $value['content'] . "\n" ;
        endforeach;

        $content = $title . "\n" . $workcontent . "\n" . $timecontent . "\n" . $sharecontent;
        //ここまで
        $request = ['header' => [
                    'X-ChatWorkToken' => CHATWORKTOKEN,
                    'Content-Type' => 'application/x-www-form-urlencoded'],
                    'body' => ['body' => $content]
        ];
        $url = "https://api.chatwork.com/v2/rooms/". CHATWORKROOMID ."/messages";

        $data = [];

        $report = $this->Report->findById($post['Report']['id']);
        //$this->log($report['Report'], LOG_DEBUG);
        $HttpSocket = new HttpSocket();
        if (!$report || $report['Report']['message_id'] == null) :
            $response = $HttpSocket->post($url, $data, $request);
        else :
            $url = "https://api.chatwork.com/v2/rooms/". CHATWORKROOMID ."/messages" . "/" . $report['Report']['message_id'];
            $response = $HttpSocket->put($url, $data, $request);
        endif;
        $this->log($response, LOG_DEBUG);
        $this->log($url, LOG_DEBUG);
        if ($response->code != 200) :
            return $this->Session->setFlash('Your post has been saved. but chatworkに投稿できませんでした');
        endif;

        if (!$report || $report['Report']['message_id'] == null) :
            $tmp = json_decode($response['body'], true);
            $this->Report->read('message_id', $id = $post['Report']['id']);
            $this->Report->set(['Report' => [
                    'message_id' => $tmp['message_id']
                ]
            ]);
            $this->Report->save();
        endif;
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

  
    public function getGoogleClientToken()
    {
        // パスが通っていなければ設定
        $path = '/daily_reportapp/app/Vendor/google-api-php-client/src';
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
     
        // OAuthクライアント認証用のJSONファイル
        $oauth_credentials = "../../app/Config/client_secret.json";  // 上記でダウンロードしたJSONファイルのPATH

        // Google認証後のリダイレクト先（「http://localhost/test/google-calendar/?code=アクセストークン」 という形でリダイレクトされる）
        $redirect_uri = "http://localhost:8080/daily_reportapp/reports/mypage";

        // Google API Client
        $client = new Google_Client();
        $client->setAuthConfig(AUTHCRE);
        $client->setRedirectUri($redirect_uri);
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType("offline");   // トークンの自動リフレッシュ
        $client->setApprovalPrompt("force"); // これがないと初回以外はリフレッシュトークンが得られない
        $authUrl = $client->createAuthUrl();
        
        // 認証後codeを受け取ったらセッション保存
        if (isset($this->request->query['code'])) {
            $client->authenticate($this->request->query['code']);
            $this->Session->write('token', $client->getAccessToken());
            $this->redirect('http://' . $_SERVER['HTTP_HOST'] . '/daily_reportapp/reports/mypage');
        }
     
        if ($this->Session->check('token')) {
            $client->setAccessToken($this->Session->read('token'));
        }
             
        if (!$client->getAccessToken()) {
            $auth_url = $client->createAuthUrl();
            echo '<a href="'.$auth_url.'">認証</a>';
        }
        return 0;
    }

    public function getSchedules()
    {
        $this->autoRender = false;
        $optParams = array();
        /* 日付指定する場合 */
        $optParams["timeMin"]  = date("Y-m-d") . "T00:00:00+0900";  // "2017-01-01T00:00:00Z";
        $optParams["timeMax"]  = date("Y-m-d") ."T23:59:59+0900";
        $optParams["timeZone"] = "Asia/Tokyo";
        $optParams["singleEvents"] = true;
        $optParams["orderBy"]  = "startTime";     // orderBy指定する場合は singleEvents=true でないと怒られる
        $email = EMAIL;
        $client = new Google_Client();
        $client->setAuthConfig(AUTHCRE);
        // カレンダーAPI用のインスタンス生成
        $client->setAccessToken($this->Session->read('token'));
        $cal_service  = new Google_Service_Calendar($client);
        $results = $cal_service->events->listEvents($email, $optParams);
        $this->log($results['items'], LOG_DEBUG);
        $schedules = [];
        foreach ($results['items'] as $value) :
            $schedules[] = $value['summary'];
        endforeach;
        
        echo json_encode($schedules);
    }
}
