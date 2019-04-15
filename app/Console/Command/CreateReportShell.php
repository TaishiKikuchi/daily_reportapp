<?php
App::uses('ReportsController', 'Controller');
App::uses('UsersController', 'Controller');
App::uses('AppController', 'Controller');

class CreateReportShell extends AppShell
{
    function startup()
    {
        parent::startup();
 
        // コントローラー設定
        $this->ReportsController = new ReportsController();
        $this->UsersController = new UsersController();
    }
 
    public function create_daily_records()
    {
        $users = $this->UsersController->get_users();
        if ($users === false) {
            $message = 'app/Console/Command/CreateReportsShell::create_report | "ユーザー情報"がありません'."\n";
            $this->log($message);    // ログ書き込み
            return false;
        }
        $this->ReportsController->create_report($users);
    }
}