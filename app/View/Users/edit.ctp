<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php
echo $this->Html->css('cake.generic');
 if ($auth) {
 echo 'ログインユーザ' . $auth['username'];
 }
?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?= h(__('Edit User')); ?></legend>
        <?= $this->Form->input('username', ['class' => 'form-control']);
        echo $this->Form->input('departmentcode', [
            'options' => [
                '1' => 'セールスマーケティング部',
                '2' => 'CRM戦略推進部',
                '3' => 'CRMマネジメントサービス',
                '4' => '開発部',
                '5' => '管理部',
                '6' => 'CRM協会',
                '7' => 'その他'
            ],
            'class' => 'form-control'
        ]);
        echo $this->Form->input('trello_id', ['class' => 'form-control', 'placeholder' => 'trelloのユーザid', 'type' => 'text']);
        echo $this->Form->input('email', ['class' => 'form-control', 'placeholder' => '取得したいgoogleカレンダーのメールアドレス', 'type' => 'email']);
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>