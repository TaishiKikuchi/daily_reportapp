<h1><?php echo $auth['username'] ?> mypage</h1>

<h2>本日の日報</h2>
<?php
echo $this->Form->create('Report');
echo $this->Form->input('title', array('value' => $auth['username'] . "'s日報")); ?>
<?php 
foreach ($report['Work'] as $work):
    echo $this->Form->input('subject', 
        array('div' => false, 
              'default' => $work['subject']
        )
    ); 
    echo $this->Form->input('starttime',
        array('type' => 'time',
              'timeFormat' => '24',
              'div' => false,
              'default' => $work['starttime']
        )
    );
    echo $this->Form->input('endtime',
        array('type' => 'time',
            'timeFormat' => '24',
            'div' => false,
            'default' => $work['endtime']
        )
    );
endforeach;
foreach ($report['Share'] as $share):
    echo $this->Form->input('content',
        array('rows' => '3',
              'default' => $share["content"]
            )
    );
endforeach;
    echo $this->Form->end('作成');
?>
<h2>みんなの共有・気づき</h2>
<?php foreach ($shares as $share): ?>
            <p><?php echo $share['Share']['content']; ?></p>
<?php endforeach; ?>
