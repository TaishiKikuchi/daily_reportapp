
<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php echo $this->Form->input('username');
        echo $this->Form->input('password');
        echo $this->Form->input('departmentcode', array(
            'options' => array(
                '1' => 'セールスマーケティング部', 
                '2' => 'CRM戦略推進部', 
                '3' => 'CRMマネジメントサービス', 
                '4' => '開発部', 
                '5' => '管理部', 
                '6' => 'CRM協会', 
                '7' => 'その他'
            )
        ));
        echo $this->Form->input('task');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>