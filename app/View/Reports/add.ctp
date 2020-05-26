<h1>Add Report</h1>
<?php
echo $this->Form->create('Report');
echo $this->Form->input('title', array(
    'value' => $auth['username'] . "'s日報")); ?>
<?php foreach ($report['Work'] as $work):
    echo $this->Form->input('subject', 
        array('div' => false, 
              'default' => $work['subject']
        )
    ); 
endforeach;     
echo $this->Form->input('content',array('rows' => '3'));
echo $this->Form->end('作成'); ?>