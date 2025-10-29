<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
?>

<h1>商品削除完了</h1>

<?php
try {
    $dbh = db_open();
    $sql ="DELETE FROM goods WHERE goods_id = :goods_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":goods_id", $_POST['goods_id'], PDO::PARAM_STR);
    $stmt->execute();
    echo "<p>商品データが削除されました。</p>";
    echo "<p><a href='index.php'>商品一覧に戻る</a></p>";
} catch (PDOException $e) {
    echo str2html($e->getMessage());
    exit;
}
?>