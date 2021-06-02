<?php
session_start();
$user_name = $_SESSION['user_name'];
if (isset($_SESSION['id'])) { //ログインしているとき
  $msg = 'こんにちは' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
  $link = '<a href="logout.php">ログアウト</a>';
} else { //ログインしていない時
  $msg = 'ログインしていません';
  $link = '<a href="login_form.php">ログイン</a>';
}
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>blog一覧</title>
</head>

<body>
  <?php
  $dsn = "mysql:host=localhost; dbname=blog; charset=utf8mb4";
  $db_account_name = "blog";
  $db_account_password = "blog";
  try {
    $pdo = new PDO($dsn, $db_account_name, $db_account_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  try {
    $sql = "SELECT * FROM blog.blogs";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
  } catch (PDOException $Exception) {
    die('接続エラー：' . $Exception->getMessage());
  }
  ?>
  <h1>blog一覧</h1>
  <table>
    <tbody>
      <tr>
        <th>id</th>
        <th>user_id</th>
        <th>blog_title</th>
      </tr>
      <?php
      while ($row = $stmh->fetch(PDO::FETCH_ASSOC)) {
        if ($_SESSION['id'] == $row['id']) {
      ?>
          <tr>
            <th><?= htmlspecialchars($row['id']) ?></th>
            <th><?= htmlspecialchars($row['user_id']) ?></th>
            <th><?= htmlspecialchars($row['title']) ?></th>
          </tr>
      <?php
        }
      }
      $pdo = null;
      ?>
    </tbody>
  </table>
</body>

</html>