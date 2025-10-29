<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
try {
    $dbh = db_open();
    $sql = 'SELECT * FROM goods, maker WHERE goods.maker_id = maker.maker_id';
    $statement = $dbh->query($sql);
?>

<style>
table {
    border-collapse: separate;
    border-spacing: 1px;
}
th {
    background-color: black;
    color: white;
    font: bold;
}
.right-align {
    text-align: right;
}
</style>

<header>
    <h1>商品一覧</h1>
</header>

<table border="1">
    <tr>
        <th>更新</th>
        <th>商品コード</th>
        <th>メーカー名</th>
        <th>商品名</th>
        <th>定価</th>
        <th>備考</th>
        <th>削除</th>
    </tr>
    <?php while ($row = $statement->fetch()): ?>
    <tr>
        <td><a href="edit.php?goods_id=<?= str2html($row['goods_id']); ?>">更新</a></td>
        <td>  <?= str2html($row['goods_id']); ?></td>
        <td>  <?= str2html($row['goods_name']); ?></td>
        <td>  <?= str2html($row['maker_name']); ?></td>
        <td class="right-align">  <?= number_format(str2html($row['price'])); ?></td>
        <td>  <?= str2html($row['remarks']) ?></td>
        <td><a href="delete.php?goods_id=<?= str2html($row['goods_id']); ?>">削除</a></td>
    </tr>
    <?php endwhile; ?>
</table>

 <p><a href="add.php">商品登録</a></p>

<?php
} catch (PDOException $e) {
    echo str2html($e->getMessage()); 
    exit;
}
?>