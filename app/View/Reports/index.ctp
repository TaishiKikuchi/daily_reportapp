<h1>dailyreports list</h1>
<p>aaaaaaaaaaaaa</p>
<?php
echo $this->Html->css('./index_style.css');
    echo $this->Html->link('日報作成', array('controller' => 'reports', 'action' => 'add', $auth['id'])); ?>
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
