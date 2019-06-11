<?php echo $this->Html->css('users_style'); ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<div class="users form form form-group">
<?php
echo $this->session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>
        <?php echo $this->Form->input('username', ['class' => 'form-control']);
        echo $this->Form->input('password', ['class' => 'form-control']);
    ?>
    </fieldset>
<?php
    echo $this->Form->button('ログイン' , [
        'type' => 'submit',
        'escape' => true,
        'class' =>'btn btn-success']);
    echo $this->Html->link('新規作成', ['class' => 'btn btn-primary', 'action' => 'add']);
    echo $this->Form->end(); ?>
</div>