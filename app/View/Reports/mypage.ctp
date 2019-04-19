<?php
    echo $this->Html->css('mypage_style');
    echo $this->element('header'); ?>
    <p class="addbutton"><?php echo $this->Html->link('作業内容更新', 
        array('controller' => 'reports', 
        'action' => 'load_work', 
        $report['Report']['user_id'],
        $report['Report']['id']), 
        array('class' => 'button')); ?>
    </p>
<div class="container"> 
    <div class="report_form">
<?php
    echo $this->Form->create('Report');
    echo $this->Form->input('title', array(
        'default' => $report['Report']['title'], 
        'div' => false
    ));
    echo $this->Form->input('user_id', array(
        'type' => 'hidden', 
        'value' => $report['Report']['user_id']
    ));
    echo $this->Form->input('id', array(
        'type' => 'hidden', 
        'value' => $report['Report']['id']
    ));
    
    $wc = 0;

    foreach ($report['Work'] as $work):
        $wc++; ?>
        <div>作業内容: <span> <?php
         echo $this->Html->link('削除', 
         array(
            'controller' => 'reports', 
            'action' => 'delete_work', 
            $work['id']), 
         array('class' => 'button')); ?>
         </span></div>
    
    <?php
        echo $this->Form->input('Work.' . $wc . '.id', array('type' => 'hidden','value' => $work['id']));
        echo $this->Form->input('Work.' . $wc . '.subject', 
            array(
                'label' => false,
                'value' => $work['subject'],
                'class' => 'textarea')); ?>
        
    <div class="timeblock">
        <div>開始時間
    <?php 
        echo $this->Form->input('Work.' . $wc . '.starttime',
            array(
                'type' => 'time',
                'timeFormat' => '24',
                'interval' => 15,
                'round' => 'down',
                'div' => false,
                'label' => false,
                'default' => $work['starttime']
            )); ?>
        </div>

        <div>終了時間
    <?php 
        echo $this->Form->input('Work.' . $wc . '.endtime',
            array(
                'type' => 'time',
                'timeFormat' => '24',
                'interval' => 30,
                'div' => false,
                'label' => false,
                'default' => $work['endtime']
            )); ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <p class="addbutton"><?php echo $this->Html->link('作業内容追加', 
        array(
            'controller' => 'reports', 
            'action' => 'create_work', 
            $report['Report']['id']), 
        array('class' => 'button')); ?>
    </p>
    <?php
    $sc = 0;
    foreach ($report['Share'] as $share):
        $sc++; ?>
        <div>気づき・共有</div>
    <?php
        echo $this->Form->input('Share.' . $sc . '.id', array('type' => 'hidden','value' => $share['id']));
        echo $this->Form->input('Share.' . $sc . '.content',
            array(
                'rows' => '3',
                'label' => false,
                'value' => $share["content"],
                'class' => 'textarea'));

        echo $this->Html->link('削除', 
            array(
                'controller' => 'reports', 
                'action' => 'delete_share', 
                $share['id']), 
                array('class' => 'button'));
    endforeach; ?>
    
    <p class="addbutton">
    <?php
        echo $this->Html->link('気づき・共有追加', 
            array(
                'action' => 'create_share', 
                $report['Report']['id']), 
            array('class' => 'button'));

        echo $this->Form->button('作成', array(
                'type' => 'submit',
                'escape' => true,
                'class' => 'button'));
        echo $this->Form->end(); ?>
    </p>
    </div>
    <div class="show_share">
    <h2>みんなの共有・気づき</h2>
    <?php foreach ($shares as $share): ?>
                <p><?php echo $share['Share']['content']; ?></p>
    <?php endforeach; ?> 
    </div>
</div>
