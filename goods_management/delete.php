<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

if (empty($_GET['goods_id'])) {
    echo "<p>商品コードが指定されていません。</p>";
    exit;
}

$goods_id = str2html($_GET['goods_id']);
?>

<style>
  .button-delete {
    background-color: #e74c3c;
    color: white;
    font-weight: bold;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
  }
</style>

<h1>商品削除確認</h1>

<p>商品コード「<?= $goods_id ?>」を削除しますか？</p>

<form action="delete_done.php" method="POST">
  <input type="hidden" name="goods_id" value="<?= $goods_id ?>">
  <input type="submit" value="削除する" class="button-delete">
</form>

<p><a href="index.php">商品一覧に戻る</a></p>