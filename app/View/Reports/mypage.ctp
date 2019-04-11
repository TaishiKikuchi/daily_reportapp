<h1><?php echo $auth['username'] ?> mypage</h1>

<h2>本日の日報</h2>
<?php
echo var_dump($report);
echo $this->Form->create('Report');
echo $this->Form->input('title', array('default' => $report[0]['Report']['title']));
echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $report[0]['Report']['user_id']));
echo $this->Form->input('id', array('type' => 'hidden', 'value' => $report[0]['Report']['id']));
$wc = 0;

foreach ($report[0]['Work'] as $work):
    $wc++;
    echo $this->Form->input('Work.' . $wc . '.id', array('type' => 'hidden','value' => $work['id']));
    echo $this->Form->input('Work.' . $wc . '.subject', 
        array('div' => false, 
              'default' => $work['subject']
        )
    ); 
    echo $this->Form->input('Work.' . $wc . '.starttime',
        array('type' => 'time',
              'timeFormat' => '24',
              'div' => false,
              'default' => $work['starttime']
        )
    );
    echo $this->Form->input('Work.' . $wc . '.endtime',
        array('type' => 'time',
            'timeFormat' => '24',
            'div' => false,
            'default' => $work['endtime']
        )
    );
endforeach; 
?>
<button>作業内容新規追加</button>
<?php
$sc = 0;
foreach ($report[0]['Share'] as $share):
    echo $this->Form->input('Share.' . $sc . '.id', array('type' => 'hidden','value' => $share['id']));
    echo $this->Form->input('Share.' . $sc . '.content',
        array('rows' => '3',
              'default' => $share["content"]
            )
    );
endforeach; ?>
<button>気づき新規追加</button>
<?php echo $this->Form->end('作成'); ?>

<h2>みんなの共有・気づき</h2>
<?php foreach ($shares as $share): ?>
            <p><?php echo $share['Share']['content']; ?></p>
<?php endforeach; ?>
