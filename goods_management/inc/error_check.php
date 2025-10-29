<?php
$back_link = 'add.php';
if (isset($_POST['mode']) && $_POST['mode'] === 'update') {
    $back_link = 'edit.php?goods_id=' . str2html($_POST['goods_id']);
}

function show_back_link($link, $label = '商品登録・更新画面に戻る') {
    echo "<p><a href='" . str2html($link) . "'>" . str2html($label) . "</a></p>";
}

if(empty($_POST['goods_id'])) {
    echo "<p>商品コードが入力されていません。</p>";
    show_back_link($back_link);
    exit;
}

if(empty($_POST['goods_name'])) {
    echo "<p>商品名が入力されていません。</p>";
    show_back_link($back_link);
    exit;
}

if(empty($_POST['price'])) {
    echo "<p>定価が入力されていません。</p>";
    show_back_link($back_link);
    exit;
} 

if(strlen($_POST['goods_id']) != 4) {
    echo "<p>商品コードは4文字で入力してください。</p>";
    show_back_link($back_link);
    exit;
}

if(mb_strlen($_POST['goods_name']) > 10) {
    echo "<p>商品名は10文字以内で入力してください。</p>";
    show_back_link($back_link);
    exit;
}

if(!preg_match('/\A\d{0,6}\z/u', $_POST['price'])) {
    echo "<p>定価は数値6桁までで入力してください。</p>";
    show_back_link($back_link);
    exit;
}

if(mb_strlen($_POST['remarks']) > 10) {
    echo "<p>備考は10文字以内で入力してください。</p>";
    show_back_link($back_link);
    exit;
}

if (isset($_POST['mode']) && $_POST['mode'] === 'update') {
    // 更新時は重複チェックをスキップ
    return;
}

$dbh = db_open();
$sql = "SELECT COUNT(*) FROM goods WHERE goods_id = :goods_id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":goods_id", $_POST['goods_id'], PDO::PARAM_STR);
$stmt->execute();
if ($stmt->fetchColumn() > 0) {
    echo "<p>その商品コードは既に登録されています。</p>";
    show_back_link($back_link);
    exit;
}