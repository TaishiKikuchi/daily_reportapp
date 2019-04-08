<h1>Add Report</h1>
<?php
echo $this->Form->create('Report');
echo $this->Form->input('title');
echo $this->Form->input('workcontent_id',array(
    'type' => 'hidden',
    'value' => $auth['id']));
echo $this->Form->input('body',array('rows' => '3'));
echo $this->Form->end('作成');
?>