<?php
echo $this->Html->css('cake.generic');
 if ($auth) {
 echo 'ログインユーザ' . $auth['username'];
 }
?>
<div class="users form">
    <p>現在のuser名 <?php echo $user['User']['username']; ?></p>
</div>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <?php echo $this->Form->input('username');
        $this->Form->input('password');
        echo $this->Form->input('departmentcode', array(
            'options' => array('1' => 'セールスマーケティング部', '2' => 'CRM戦略推進部', '3' => 'CRMマネジメントサービス',
            '4' => '開発部', '5' => '管理部', '6' => 'CRM協会', '7' => 'Author', '8' => 'その他')
        ));
        echo $this->Form->input('task');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>