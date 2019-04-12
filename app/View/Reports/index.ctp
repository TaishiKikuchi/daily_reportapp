<h1>dailyreports list</h1>
<?php
 if ($auth) {
 echo 'ログインユーザ' . $auth['username'];
 }
 
 echo $this->Html->link('logout', array('controller' => 'users'
 , 'action' => 'logout', $auth['id']));
?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
    </tr>
    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->
    <?php echo $this->Html->link('日報作成',
array('controller' => 'reports', 'action' => 'add', $auth['id'])); ?>
    <?php foreach ($reports as $report): ?>
    <tr>
        <td><?php echo $report['Report']['id']; ?></td>
        <?php foreach ($report['Work'] as $work): ?>
        <?php echo $work["subject"]; ?>
        <?php endforeach; ?>
        <td>
            <?php echo $this->Html->link($report['Report']['title'],
array('controller' => 'reports', 'action' => 'view', $report['Report']['id'])); ?>
        </td>
        <td>
        <?php
                echo $this->Html->link(
                    'Edit',
                    array('action' => 'edit', $report['Report']['id'])
                );
                echo $this->Form->postLink('Delete',
                array('action' => 'delete', $report['Report']['id']),
                array('confirm' => '本当に削除しますか?')
                );
            ?>
        </td>
        <td><?php echo $report['Report']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($report); ?>
</table>