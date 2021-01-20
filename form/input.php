<?php

session_start();

header('X-Frame-Options: DENY');

// スーパーグローバル変数 php 9種類
// 連想配列

if(!empty($_SESSION)){
  echo '<pre>';
  var_dump($_SESSION);
  echo '</pre>';
}

function h($str){
		return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// 入力、確認、完了 input.php, confirm.php, thanks.php
// input.php

$pageFlag = 0;

if(!empty($_POST['btn_confirm'])){
		$pageFlag = 1;
}

if(!empty($_POST['btn_submit'])){
		$pageFlag = 2;
}
?>

<!DOCTYPE html>
<meta charset="utf-8">
<head></head>
<body>

<!-- 確認画面 -->
<?php if($pageFlag === 1) : ?>
<!-- トークンが正しいかどうかを判定 -->
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>

<form method="POST" action="input.php">
		氏名
		<?php echo h($_POST['your_name']); ?>
		<br>
		メールアドレス
		<?php echo h($_POST['email']); ?>
		<br>
		<!-- 戻るボタン -->
		<input type="submit" name="back" value="戻る"
		<!-- 戻るボタン -->
		<input type="submit" name="btn_submit" value="送信する">
		<input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
		<input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
		<!-- ページフラッグが変わるタイミングでcsrfが消えてしまうので、下記hiddenで保持 -->
		<input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">
</form>

<!-- トークンが正しいかどうかを判定の endif -->
<?php endif; ?>

<?php endif; ?>


<!-- サンクスページ -->
<?php if($pageFlag === 2) : ?>
<!-- トークンが正しいかどうかを判定 -->
<?php if($_POST['csrf'] === $_SESSION['csrfToken']) :?>
送信が完了しました。

<!-- トークンが残っているのがよくないので、完了画面でトークンを削除 -->
<?php unset($_SESSION['csrfToken']); ?>

<!-- トークンが正しいかどうかを判定の endif -->
<?php endif; ?>
<?php endif; ?>


<!-- メールフォーム本体 -->
<?php if($pageFlag === 0) : ?>
<?php
if(!isset($_SESSION['csrfToken'])){
		$csrfToken = bin2hex(random_bytes(32));
		$_SESSION['csrfToken'] = $csrfToken;
}
// csrfTokenって長いので、$token変数にする
$token = $_SESSION['csrfToken'];
?>

<form method="POST" action="input.php">
  氏名
  <input type="text" name="your_name" value="<?php if(!empty($_POST['your_name'])){ echo h($_POST['your_name']); } ?>">
  <br>
		メールアドレス
		<input type="email" name="email" value="<?php if(!empty($_POST['email'])){ echo h($_POST['email']); } ?>">
		<br>
		ホームページ
		<input type="url" name="url" value="<?php if(!empty($_POST['url'])){ echo h($_POST['url']); } ?>">
		<br>
		性別
		<input type="radio" name="gender" value="0">男性
		<input type="radio" name="gender" value="1">女性
		年齢
		<select name="age">
				<option value="">選択してください</option>
				<option value="1">〜19歳</option>
				<option value="2">20歳〜29歳</option>
				<option value="3">30歳〜39歳</option>
				<option value="4">〜19歳</option>
				<option value="5">〜19歳</option>
				<option value="6">〜19歳</option>
		</select>
		お問い合わせ内容
		注意事項のチェック
  <input type="submit" name="btn_confirm" value="確認する">
		<!-- 下記の記述で、valueのなかにトークンが入ってくる -->
		<input type="hidden" name="csrf" value="<?php echo $token; ?>">
		
</form>
<?php endif; ?>

</body>
</html>
