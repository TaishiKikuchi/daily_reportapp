<h1>daily_reports</h1>
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
array('controller' => 'posts', 'action' => 'view', $report['Report']['id'])); ?>
        </td>
        <td><?php echo $report['Report']['body']; ?></td>
        <td><?php echo $report['Report']['workcontent_id']; ?></td>
        <td><?php echo $report['Report']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($report); ?>
</table>