<?php
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';

if(empty($_GET['goods_id'])) {
  echo "<p>商品コードを指定してください</p>";
  exit;
}

try {
  $goods_id = str2html($_GET['goods_id']);

  $dbh = db_open();
  $sql = "SELECT * FROM goods WHERE goods_id = :goods_id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":goods_id", $goods_id, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$result) {
    echo "指定したデータはありません。";
    exit;
  }

  $maker_id = str2html($result['maker_id']);
  $goods_name = str2html($result['goods_name']);
  $price = str2html($result['price']);
  $remarks = str2html($result['remarks']);

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

<h1>商品更新</h1>

<form action='update.php' method='POST'>
  <p>
    <label for='goods_id'>商品コード<span class="required">*</span>:</label>
    <input type='text' name='goods_id' value="<?= $goods_id ?>" readonly>
  </p>
  <p>
    <label for='maker_id'>メーカーコード<span class="required">*</span>:</label>
    <select name="maker_id">
    <?php while ($row = $statement->fetch()): ?>
      <?php if ($row['maker_id'] == $maker_id) : ?>
      <option value="<?= str2html($row['maker_id']); ?>" selected>
        <?= str2html($row['maker_name']); ?>
      </option>
      <?php else : ?>
      <option value="<?= str2html($row['maker_id']); ?>">
        <?= str2html($row['maker_name']); ?>
      </option>
      <?php endif; ?>
    <?php endwhile; ?>
    </select>
  </p>
  <p>
    <label for='goods_name'>商品名<span class="required">*</span>:</label>
    <input type='text' name='goods_name' value="<?= $goods_name; ?>" required>
  </p>
  <p>
    <label for='price'>定価<span class="required">*</span>:</label>
    <input type='number' name='price' step ='100' value="<?= $price; ?>" required>
  </p>
  <p>
    <label for='remarks'>備　考:</label>
    <textarea name='remarks'><?= $remarks; ?></textarea>
  </p>
  <input type="hidden" name="mode" value="update">
  <p class='button'>
    <input type='submit' class='submitbutton' value='更新'>
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