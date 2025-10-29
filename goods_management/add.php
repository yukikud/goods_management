<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

try {
  $dbh = db_open();
  $sql = 'SELECT * FROM maker';
  $statement = $dbh->query($sql);
?>
<style>
.required {
  color: red;
}
.submitbutton {
 background-color: gray;
 color: white;
 border: none;
 padding: 10px 20px;
 border-radius: 5px;
 font-weight: bold;
 cursor: pointer;
}
</style>

<h1>商品登録</h1>
<span class="required">*</span>は必須項目です。
<form action='insert.php' method='POST'>
  <p>
    <label for='goods_id'>商品コード<span class="required">*</span>:</label>
    <input type='text' name='goods_id' required>
  </p>
  <p>
    <label for='maker_id'>メーカーコード<span class="required">*</span>:</label>
    <select name="maker_id">
    <?php while ($row = $statement->fetch()): ?>
      <option value="<?= str2html($row['maker_id']); ?>">
          <?= str2html($row['maker_name']); ?>
      </option>
    <?php endwhile; ?>
    </select>
  </p>
  <p>
    <label for='goods_name'>商品名<span class="required">*</span>:</label>
    <input type='text' name='goods_name' required>
  </p>
  <p>
    <label for='price'>定価<span class="required">*</span>:</label>
    <input type='number' name='price' step ='100' required>
  </p>
  <p>
    <label for='remarks'>備　考:</label>
    <textarea name='remarks'></textarea>
  </p>
  <p class='button'>
    <input type='submit' class='submitbutton' value='登録'>
  </p>
</form>

<p><a href='index.php'>商品一覧に戻る</a></p>

<?php
} catch (PDOException $e) {
    echo str2html($e->getMessage());
}
?>

</body>
</html>