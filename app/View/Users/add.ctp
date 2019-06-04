<?php echo $this->Html->css('users_style'); ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<div class="users form form-group">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?= h(__('Add User')); ?></legend>
        <?= $this->Form->input('username', ['class' => 'form-control']);
        echo $this->Form->input('password', ['class' => 'form-control', 'placeholder' => '8文字以上']);
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
    
<?= $this->Form->button('作成' , [
        'type' => 'submit',
        'escape' => true,
        'class' =>'btn btn-primary']);
    echo $this->Form->end(); ?>
</div>