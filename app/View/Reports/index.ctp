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
        <th>body<th>
        <th>Created</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($reports as $report): ?>
    <tr>
        <td><?php echo $report['Report']['id']; ?></td>
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
                echo $this->Html->link(
                    'delete',
                    array('action' => 'delete', $report['Report']['id'])
                );
            ?>
        </td>
        <td><?php echo $report['Report']['body']; ?></td>
        <td><?php echo $report['Report']['workcontent_id']; ?></td>
        <td><?php echo $report['Report']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($report); ?>
</table>