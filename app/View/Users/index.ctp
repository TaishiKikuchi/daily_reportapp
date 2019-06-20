<h1>user list</h1>
<?php
echo $this->Html->css('cake.generic');
 if ($auth) {
 echo 'ログインユーザ' . $auth['username'];
 }

?>
<table>
    <tr>
        <th>Id</th>
        <th>name</th>
        <th>department<th>
        <th>タスク<th>
        <th>編集<th>
        <th>Created</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $user['User']['username']; ?>
        </td>
        <td><?php echo $user['User']['departmentcode']; ?></td>
        <td><?php echo $user['User']['trello_id']; ?></td>
        <td><?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));
        echo $this->Form->postLink('delete2',
        array('controller' => 'Users', 'action' => 'delete', $user['User']['id']), array('confirm' => '本当に削除しますか?'));
        ?></td>
        <td><?php echo $user['User']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($report); ?>
</table>