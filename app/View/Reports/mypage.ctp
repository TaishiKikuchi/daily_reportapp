<?php
    echo $this->Html->css('mypage_style');
    echo $this->element('header'); ?>
<button type="button" class="button getbutton" onclick="getWork(<?php echo $report['Report']['id'] ?>,<?php echo $auth['id'] ?>)">作業内容読み込み</button>
<button type="button" class="button getbutton" onclick="getCardName('kikichitaishi')">作業内容読み込み2</button>
<div class="container"> 
    <div class="report_form">
<?php
    echo $this->Form->create('Report');
    echo $this->Form->input('title', [
        'default' => date("m/d") . $auth['username'] . "'日報", 
        'div' => false
    ]);
    echo $this->Form->input('user_id', [
        'type' => 'hidden',
        'value' => $auth['id']
    ]);
    echo $this->Form->input('id', [
        'type' => 'hidden', 
        'value' => $report['Report']['id']
    ]);
    
    $wc = 0;

    foreach ($report['Work'] as $work):
        $wc++; ?>
        <div>作業内容: <span> <?php
         echo $this->Html->link('削除', 
            [
                'controller' => 'reports', 
                'action' => 'delete_work', 
                $work['id']], 
            ['class' => 'button']); ?>
         </span></div>
    
    <?php
        echo $this->Form->input('Work.' . $wc . '.id', ['type' => 'hidden','value' => $work['id']]);
        echo $this->Form->input('Work.' . $wc . '.subject', [
                'label' => false,
                'value' => $work['subject'],
                'class' => 'textarea']); ?>
        
    <div class="timeblock">
        <div>開始時間
    <?php 
        echo $this->Form->input('Work.' . $wc . '.starttime', [
                'type' => 'time',
                'timeFormat' => '24',
                'interval' => 15,
                'round' => 'down',
                'div' => false,
                'label' => false,
                'default' => $work['starttime']
        ]); ?>
        </div>

        <div>終了時間
    <?php 
        echo $this->Form->input('Work.' . $wc . '.endtime', [
                'type' => 'time',
                'timeFormat' => '24',
                'interval' => 30,
                'div' => false,
                'label' => false,
                'default' => $work['endtime']
        ]); ?>
        </div>
    </div>
    <?php endforeach; ?>
    <div id="work" value="<?php echo $wc ?>"></div>
    <button id="add_work" class="button addbutton" type="button" value="">作業内容追加</button>
    <?php
    $sc = 0;
    foreach ($report['Share'] as $share):
        $sc++; ?>
        <div>気づき・共有<span>
    <?php
        echo $this->Html->link('削除', [
            'controller' => 'reports', 
            'action' => 'delete_share', 
            $share['id']], 
            ['class' => 'button']); ?>
        </span></div>
    <?php
        echo $this->Form->input('Share.' . $sc . '.id', array('type' => 'hidden','value' => $share['id']));
        echo $this->Form->input('Share.' . $sc . '.content', [
                'rows' => '3',
                'label' => false,
                'value' => $share["content"],
                'class' => 'textarea']);        
    endforeach; ?>
    <div id="share" value="<?php echo $sc ?>"></div>
    <button id="add_share" class="button addbutton" type="button">気づき・共有追加</button>
    <?php
        echo $this->Form->button('作成', [
                'type' => 'submit',
                'escape' => true,
                'class' => ['button', 'postbutton']]);
        echo $this->Form->end(); ?>
    </div>
    <div class="show_share">
    <h2>みんなの共有・気づき</h2>
    <?php foreach ($shares as $share): ?>
                <p><?php echo $share['Share']['content']; ?></p>
    <?php endforeach; 
    echo $this->Html->script('script');
    ?>
    </div>
</div>
