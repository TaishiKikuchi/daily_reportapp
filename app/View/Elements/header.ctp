<?php echo $this->Html->css('header_style'); ?>
<header>
	<h1>日報作成app</h1>
    <?php
    if ($auth) {
        echo 'ログインユーザ' . $auth['username'];
        echo 'ログアウト';
    } else {
        echo '新規登録';
        echo 'ログアウト';
    }
    ?>
    <nav>
        <ul class="container">
            <li class="item"><a href="./reports/index">日報一覧</a></li>
            <li class="item"><a href="./shares/index">気づき・共有一覧</a></li>
            <li class="item"><a href="./reports/mypage">マイページ</a></li>
        </ul>
    </nav>
</header>