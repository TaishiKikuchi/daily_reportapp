<h1>dailyreports</h1>
<?php echo $this->Html->link('Edit', array('action' => 'edit', $report['Report']['id'])); ?>
<table>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>works</th>
        <th>気づき・共有</th>
        <th>Created</th>
    </tr> 
    <tr>

        <td><?php echo $report['Report']['id']; ?></td>
        <td><?php echo $report['Report']['title']; ?></td>
        <td>
            <?php foreach ($report['Work'] as $work): ?>
            <p><?php echo $work["subject"]; ?> :<?php echo $work["starttime"]; ?> <p>
            <?php endforeach; ?>
        </td>
        <td>
            <?php foreach ($report['Share'] as $share): ?>
            <p><?php echo $share["content"]; ?></p>
            <?php endforeach; ?>
        </td>
        <td><?php echo $report['Report']['created']; ?></td>
    </tr>
</table>
<p><small>Created: <?php echo $report['Report']['created']; ?></small></p>