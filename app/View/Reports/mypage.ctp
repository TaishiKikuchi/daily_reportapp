<h1><?php echo $auth['username'] ?> mypage</h1>

<h2>本日の日報</h2>
<?php
echo $this->Form->create('Report');
echo $this->Form->input('title', array('default' => $report['Report']['title']));
echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $report['Report']['user_id']));
echo $this->Form->input('id', array('type' => 'hidden', 'value' => $report['Report']['id']));
$wc = 0;

foreach ($report['Work'] as $work):
    $wc++;
    echo $this->Form->input('Work.' . $wc . '.id', array('type' => 'hidden','value' => $work['id']));
    echo $this->Form->input('Work.' . $wc . '.subject', 
        array('div' => false, 
              'value' => $work['subject']
        )
    ); 
    echo $this->Form->input('Work.' . $wc . '.starttime',
        array('type' => 'time',
              'timeFormat' => '24',
              'interval' => 15,
              'round' => 'down',
              'div' => false,
              'default' => $work['starttime']
        )
    );
    echo $this->Form->input('Work.' . $wc . '.endtime',
        array('type' => 'time',
            'timeFormat' => '24',
            'interval' => 30,
            'div' => false,
            'default' => $work['endtime']
        )
    ); ?>
    <p><?php echo $this->Html->link('作業内容削除', array('controller' => 'reports', 'action' => 'delete_work', $work['id'])); ?></p>
<?php endforeach; ?>
<p><?php echo $this->Html->link('作業内容新規追加', array('controller' => 'reports', 'action' => 'create_work', $report['Report']['id'])); ?></p>
<?php
$sc = 0;
foreach ($report['Share'] as $share):
    $sc++;
    echo $this->Form->input('Share.' . $sc . '.id', array('type' => 'hidden','value' => $share['id']));
    echo $this->Form->input('Share.' . $sc . '.content',
        array('rows' => '3',
              'value' => $share["content"]
            )
    ); ?>
    <p><?php echo $this->Html->link('気づき・共有削除', array('controller' => 'reports', 'action' => 'delete_share', $share['id'])); ?></p>
<?php endforeach;
echo $this->Html->link('気づき・共有新規追加', array('action' => 'create_share', $report['Report']['id']));
echo $this->Form->end('作成'); ?>

<h2>みんなの共有・気づき</h2>
<?php foreach ($shares as $share): ?>
            <p><?php echo $share['Share']['content']; ?></p>
<?php endforeach; ?>
