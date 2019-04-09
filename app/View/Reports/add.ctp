<h1>Add Report</h1>
<?php
$select_data = array(1,2,3,4,5,6);
echo $this->Form->create('Report');
echo $this->Form->input('title', array(
    'value' => $auth['username'] . "'s日報")); ?>
<?php echo $this->Form->input('subject', array('div' => false)); $this->Form->input('starttime', array('div' => false));
      echo $this->Form->select("hoge",$select_data,array("empty"=>"--","default"=> 0));
      echo $this->Form->input('starttime',
      array(
        'label' => '時刻',
        'div' => false,
      ));
      echo $this->Form->input('subject'); $this->Form->input('starttime');
      echo $this->Form->input('subject'); $this->Form->input('starttime'); ?>
<?php
echo $this->Form->input('content',array('rows' => '3'));
echo $this->Form->end('作成');
?>