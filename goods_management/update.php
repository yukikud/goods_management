<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
?>

<?php
include __DIR__ . '/inc/error_check.php';
if(empty($_POST['goods_id'])) {
    echo "<p>商品コードを指定してください。</p>";
    exit;
}

try {
    $dbh = db_open();
    $sql ="UPDATE goods SET maker_id = :maker_id , goods_name = :goods_name, price = :price, remarks = :remarks WHERE goods_id = :goods_id";
    $stmt = $dbh->prepare($sql);
    $price = (int)$_POST['price'];
    $stmt->bindParam(":maker_id", $_POST['maker_id'], PDO::PARAM_STR);
    $stmt->bindParam(":goods_name", $_POST['goods_name'], PDO::PARAM_STR);
    $stmt->bindParam(":price", $price, PDO::PARAM_INT);
    $stmt->bindParam(":remarks", $_POST['remarks'], PDO::PARAM_STR);
    $stmt->bindParam(":goods_id", $_POST['goods_id'], PDO::PARAM_STR);
    $stmt->execute();
    echo "<h1>商品更新完了</h1><br>商品データが更新されました。<br>";
    echo "<p><a href='index.php'>商品一覧に戻る</a></p>";
} catch (PDOException $e) {
    echo str2html($e->getMessage());
    show_back_link($back_link);
}
?>