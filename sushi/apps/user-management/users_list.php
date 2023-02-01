<?php
//DBへ接続
	require_once("../common/utility.php");
	//$users = FuncSelectSql("select * from users;");
	//$users= $users[0];
	//検索の実行

	$number = $_POST["user_number"];
	$name = $_POST["user_name"];
	$gender = $_POST["sex_type"];
	$password = $_POST["password"];
	$year = $_POST["school_year"];
	$item = $_POST["item"];
	$sort = $_POST["sort"];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>利用者の検索</title>
</head>
<h1>利用者検索</h1>
<!-- form -->
<form id="mainform" action="users_list.php" method="post">
	<p>利用者番号
		<input type="search"  size="10" name="user_number" placeholder="">
	</p>
	<p>氏名	
		<input type="search"  size="10" name="user_name" placeholder=""></p>
	<p>性別	
		<select name="sex_type">
			<option></option>
			<option value="1">男性</option>
			<option value="2">女性</option>
		</select>
	</p>
	<p>学年	
		<select name="school_year" placeholder="">
			<option></option>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
			<option>6</option>

		</select>
	</p>
	<p>パスワード
		<input type="password"  size="10" name="password" placeholder=""></p>
	<p>ソート順
		<select name="item" >
			<option value="user_number" selected>利用者番号</option>
			<option value="user_name">氏名</option>
			<option value="sex_type">性別</option>
			<option value="school_year">学年</option>
			<option value="password">パスワード</option>
		</select>
		<select name="sort" >

			<option value="1" selected>昇順</option>
			<option value="2">降順</option>
		</select>
	</p>
		<p><input type="submit" value ="検索" name="check">
	</p>
</form>
<p>
	表示件数	n件

</p>
<p>
	<table border="1">
		<tr>
			<th>利用者番号</th>
			<th>氏名</th>
			<th>性別</th>
			<th>学年</th>
			<th>パスワード</th>
			<th>詳細</th>
		</tr>
		<tr>
		<?php 
		if(isset($_POST['check'])){	//検索ボタンの処理 
			if($sort == 1){
				$sqltest = FuncSelectSql("SELECT * FROM users where user_number like '$number%' and user_name like '%$name%' and sex_type like '%$gender' and password like '%$password%' and school_year like '%$year%' order by $item");	
			}else{
				$sqltest = FuncSelectSql("SELECT * FROM users where user_number like '$number%' and user_name like '%$name%' and sex_type like '%$gender' and password like '%$password%' and school_year like '%$year%' order by $item desc");
			}

		foreach($sqltest as $result):
				?>
			<th><?php print_r($result['user_number']); ?></th>
			<th><?php print_r($result['user_name']); ?></th>
			<th><?php print_r($result['sex_type']); ?></th>
			<th><?php print_r($result['school_year']); ?></th>
			<th><?php print_r($result['password']); ?></th>
			<th><a href="http://10.123.100.101/sushi/apps/user-management/users_history.php?user_number=<?php echo $result['user_number']; ?>"> この利用者の詳細画面へ</a></th>

		</tr>
		<?php endforeach; } ?>
		

	</table>

	<p>	<input type="button" value ="クリア"  name="clear" onclick="location.href='http://10.123.100.101/sushi/apps/user-management/users_list.php'"></p>
</html>