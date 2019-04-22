<?php
echo $this->element('header');
echo $this->Html->css('shareindex_style'); ?>

<table>
    <tr>
        <th>カテゴリId</th>
        <th>気づき・共有</th>
    </tr>

    <?php
    foreach ($shares as $share): ?>
    <tr>
        <td>
            <?php
            echo $share['Share']['category_id']; ?>
        </td>
        <td>        
            <?php 
            echo $share['Share']['content']; ?>
        </td>
    </tr>
    <?php
    endforeach; ?>
</table>
<div class='pager'>
<?php echo $this->Paginator->numbers(); ?>
</div>