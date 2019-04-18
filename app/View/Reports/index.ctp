<?php
    echo $this->element('header');
    echo $this->Html->css('index_style');
    echo $this->Form->create('User');
    echo $this->Form->input('セレクトボックス', array(
        'options' => array('1' => 'セールスマーケティング部', '2' => 'CRM戦略推進部', '3' => 'CRMマネジメントサービス', 
        '4' => '開発部', '5' => '管理部', '6' => 'CRM協会', '7' => 'all'),
        'onchange'=>'this.form.submit()',
        'name' => 'code',
        'default' => 8,
        'value' => $code
    ));
    echo $this->Form->end();
    ?>
    <div class="report_article">
    <?php
    foreach ($reports as $report): ?>
    <div class="report_container"><?php
        echo $report['Report']['title'];
        foreach ($report['Work'] as $work): ?>
        <div class="report_item"><?php echo $work['subject']; ?></div>
        <div><?php echo $work['starttime']; ?></div>
    <?php   
        endforeach; ?>
    </div>
    <?php
    endforeach; ?>
    </div>
    <?php unset($report); ?>
