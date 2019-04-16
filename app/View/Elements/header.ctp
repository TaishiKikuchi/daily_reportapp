<?php echo $this->Html->css('header_style'); ?>
<header>
    <div id='loginstu'>
    <?php
    if ($auth) {
        echo 'ログインユーザ' . $auth['username'];
        echo $this->Html->link('ログアウト', array('controller' => 'users','action' => 'logout', 'class' => 'usermanager'));
    } else {
        echo $this->Html->link('ログイン', array('controller' => 'users','action' => 'login', 'class' => 'usermanager'));
        echo $this->Html->link('新規登録', array('controller' => 'users','action' => 'add', 'class' => 'usermanager'));
    } ?>
    </div>
    
    <h1 class="title">日報作成app</h1>
    <h3 class="subtitle">~ <?php echo $subtitle ?> ~</h3>
    <nav>
        <ul class="container">
            <li class="item"><a href="/daily_reportapp/reports/index">日報一覧</a></li>
            <li class="item"><a href="/daily_reportapp/reports/index">気づき・共有一覧</a></li>
            <li class="item"><a href="/daily_reportapp/reports/mypage">マイページ</a></li>
        </ul>
    </nav>
</header>