<?php
echo $this->element('header');
echo $this->Html->css('shareindex_style'); ?>

<table>
    <tr>
        <th>気づき・共有</th>
    </tr>

    <?php foreach ($shares as $share): ?>
    <tr>
        <td>
            <?= h($share['Share']['content']); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<div class='pager'>
<?= $this->Paginator->numbers(); ?>
</div>