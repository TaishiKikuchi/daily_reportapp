<?php
    echo $this->element('header');
    echo $this->Html->css('style');
    echo $this->Html->css('index_style'); ?>
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
