<?php
    echo $this->Html->css('mypage_style');
    echo $this->element('header'); 
    /* trello除外リスト作成途中
    echo $this->Form->create('exlists');
    echo $this->Form->input('user_id', [
        'type' => 'hidden',
        'value' => $list['Rep']['id']
    ]);
    echo $this->Form->button($btname , [
        'type' => 'submit',
        'escape' => true,
        'class' => ['button', 'postbutton']]);
    echo $this->Form->end(); */
    ?>
<button type="button" class="button getbutton" onclick="getCardName('<?= h($trello_id)?>')">Trello読み込み</button>
<button type="button" class="button getbutton" onclick="getCalendar('<?= h($email) ?>')">カレンダー読み込み</button>

<div class="container">
    <div class="report_form">
<?php
    echo $this->Form->create('Report');
    echo $this->Form->input('title', [
        'default' => date("m/d") . $auth['username'] . "'日報", 
        'div' => false,
        'class' => 'reporttitle',
        'label' => false
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
    $sc = 0;
    if (isset($report)) :
        foreach ($report['Work'] as $work):
            $wc++;
            $sc++; ?>
            <div>作業内容: <span> 
            <?php
            echo $this->Html->link('削除', [
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
            <div>振り返り<span></span></div>
            <?php
            echo $this->Form->input('Work.' . $wc . '.content', [
                'rows' => '2',
                'label' => false,
                'value' => $work["content"],
                'class' => 'textarea']);        
        endforeach; 
    endif ?>
        <div id="work" value="<?= h($wc) ?>"></div>
        <button id="add_work" class="button addbutton" type="button" value="">作業内容追加</button>
        <div>全体の振り返り</div>
    <?php
        if (isset($report)) :
            $btname ='更新';
            $sharecontent = $report['Share'][0]['content'];
            $share_id = $report['Share'][0]['id'];
        else:
            $sharecontent = "";
            $share_id = 0;
            $btname ='作成';
        endif;

        echo $this->Form->input('Share.0.id', array('type' => 'hidden','value' => $share_id));
        echo $this->Form->input('Share.0.content', [
            'rows' => '3',
            'label' => false,
            'value' => $sharecontent,
            'class' => 'textarea']);
        echo $this->Form->button($btname , [
            'type' => 'submit',
            'escape' => true,
            'class' => ['button', 'postbutton']]);
        echo $this->Form->end(); ?>
    </div>
    <!--
    <div class="show_share">
    <h2>みんなの共有・気づき</h2>
    <?php foreach ($shares as $share): ?>
        <p><?= h($share['Share']['content']); ?></p>
    <?php endforeach; ?>
    </div>
    -->

    <div class="trello_ex_list">
    <?php
    echo $this->Html->script('script');
    $exc = 0;
    if (isset($trello_ex_list)) :
        echo $this->Form->create('Trello_exclusion_list', array('action' => 'addTrelloExList'));
        echo $this->Form->input('user_id', [
            'type' => 'hidden',
            'value' => $auth['id']
        ]);
        foreach ($trello_ex_list as $list):
            $exc++;
            echo $this->Form->input('id', ['type' => 'hidden','value' => $list['id']]);
            echo $this->Form->input('trello_id', [
                'label' => false,
                'value' => $list['trello_id'],
                'class' => 'textarea',
                'type' => 'text'
                ]);
            echo $this->Form->input('state', ['type' => 'hidden','value' => 0]);
        endforeach;
        echo $this->Form->button("追加" , [
            'type' => 'submit',
            'escape' => true,
            'class' => ['button', 'postbutton']]);
        echo $this->Form->end();
    endif; ?>
    </div>
</div>
