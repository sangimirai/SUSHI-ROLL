<?php
try{
	$db = new PDO(
		'mysql:dbname=library_test; host=10.123.100.101; charset=utf8','root','',
		[
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_ERRMODE =>/*&gt*/ PDO::ERRMODE_EXCEPTION
		]
	);
}catch(PDOException $e){
	echo 'DB接続失敗',$e->getMessage(),"\n";
	exit();
}
?>

<?php
	if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])){
		$id = $_REQUEST['id'];
		$books = $db->prepare('SELECT * FROM books where book_number=?');
		$books->execute(array($id));
		$book = $books->fetch();

		$times = $db->prepare('SELECT * FROM reception_list where book_number=?');
		$times->execute(array($id));
		$retimes = $times->fetch();
		$retime = strtotime($retimes['return_date']);
		$time = strtotime('now');
	}
?>

<!DOCTYPE html>
<HTML>
	<head>
		<meta charset='utf-8'>
		<title>書籍詳細</title>
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<header>
		</header>
		<h1>書籍詳細</h1>
		<h1><?php if($retime - $time < 0){
			echo "<FONT COLOR = \"RED\">返却期限を過ぎています</FONT>";
		} ?></h1>

		<dl>
			<dt>書籍ID</dt>
			<dd>
				<?php echo htmlspecialchars($book['book_number']) ?>
			</dd>

			<dt>書籍名</dt>
			<dd>
				<?php echo htmlspecialchars($book['book_name']) ?>
			</dd>

			<dt>著者</dt>
			<dd>
				<?php echo htmlspecialchars($book['author']) ?>
			</dd>

			<dt>カテゴリ</dt>
			<dd>
				<?php echo htmlspecialchars($book['category']) ?>
			</dd>

			<dt>貸出し可否フラグ</dt>
			<dd>
				<?php echo htmlspecialchars($book['lending_type']) ?>
			</dd>

		</dl>
		<input type="button" value="検索画面へ戻る" onclick="location.href='books_list.php'">
	</body>
</HTML>