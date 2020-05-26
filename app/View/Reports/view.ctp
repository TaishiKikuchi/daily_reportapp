<?php echo $this->element('header'); ?>
<div class="viewcontainer">
    <div class="report">
        <div class="stitle">日報タイトル</div>
            <div><?= h($report['Report']['title']); ?></div>
        <div class="stitle">作業内容</div>
        <?php foreach ($report['Work'] as $work): ?>
            <span><div><?= $work["subject"];?> 開始時間: <?= h($work["starttime"]); ?></div></span>
        <?php endforeach; ?>
        <div class="stitle">気づき・共有</div>
        <?php foreach ($report['Share'] as $share): ?>
            <div><?= h($share["content"]); ?></div>
        <?php endforeach; ?>
    </div>
</div>