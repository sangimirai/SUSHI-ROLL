<?php

declare(strict_types=1);

require_once("../common/utility.php");

session_start();

if ($_SESSION['usrnum'] == false) {
    $_SESSION['usrnum'] = "";
}

if ($_SESSION['booknum'] == false) {
    $_SESSION['booknum'] = "";
}

if (isset($_POST['usrnum'])) {
    $_SESSION['usrnum'] = $_POST['usrnum'];
}

if (isset($_POST['booknum'])) {
    $_SESSION['booknum'] = $_POST['booknum'];
}

//以下DB接続
//接続設定
// $dbtype="mysql";
// $sv="db";
// $dbname="library_test";
// $user="sushi";
// $pass="roll";

//データベースに接続
// $dsn="$dbtype:dbname=$dbname;host=$sv;charset=utf8";
// $conn=new PDO($dsn,$user,$pass);

// サーバー用 DBコネクション
$conn = FuncDataBaseConnection();
//DB接続処理おわり

$alert1 = "<script type='text/javascript'>alert('該当する利用者が存在しないか、この利用者は貸出しできません');</script>";
$alert2 = "<script type='text/javascript'>alert('該当する書籍が存在しないか、この書籍は貸出しできません');</script>";

$sqlrc = "SELECT * FROM reception_list ";
$stmt = $conn->prepare($sqlrc);
$stmt->execute();
$count = $stmt->rowCount() + 1;

$user = (function () use ($conn) {  //$userにreturnした値を代入。このとき、即時関数外の$connを使えるようにuse()を使う。
    if ($_SERVER["REQUEST_METHOD"] != "POST") { //サーバにPOSTの要求があるか確認
        return; //なければ何もしない
    }

    if (!isset($_POST["usrnum"])) { //POSTした中身（usrnum）があるか確認
        return; //無ければ何もしない
    }

    $stmt = $conn->prepare("select * from users where user_number = :user_number and user_type = 0"); //利用者番号検索で入力した数値と同じ値を探す
    $stmt->bindValue(":user_number", $_SESSION["usrnum"]); //:user_numberと_POST["usrnum"]を置き換える。
    $stmt->execute(); //実行
    return $stmt->rowCount() != 0 ? $stmt->fetchAll()[0] : []; //先頭の列を取り出す。
})();


$book = (function () use ($conn) {  //$bookにreturnした値を代入。このとき、即時関数外の$connを使えるようにuse()を使う。
    if ($_SERVER["REQUEST_METHOD"] != "POST") { //サーバにPOSTの要求があるか確認
        return; //なければ何もしない
    }

    if (!isset($_POST["booknum"])) { //POSTした中身（booknum）があるか確認
        return; //無ければ何もしない
    }

    $stmt = $conn->prepare("select * from books where book_number = :book_number and lending_type = 0"); //利用者番号検索で入力した数値と同じ値を探す
    $stmt->bindValue(":book_number", $_SESSION["booknum"]); //:user_numberと_POST["usrnum"]を置き換える。
    $stmt->execute(); //実行
    return $stmt->rowCount() != 0 ? $stmt->fetchAll()[0] : []; //先頭の列を取り出す。
})();


(function () use ($conn, $user, $book, $count, $alert1, $alert2) {
    if (isset($_POST['lending'])) {
        if ($user == []) {
            echo $alert1;
            return;
        }

        if ($book == []) {
            echo $alert2;
            return;
        }

        $stmt = $conn->prepare("INSERT INTO reception_list(reception_number,book_number,lending_user_number,lending_date) VALUE('$count','{$_POST["booknum"]}','{$_POST["usrnum"]}',CURDATE())");
        $stmt->execute();
        header("Location: {$_SERVER['PHP_SELF']}");
    }
})();

$bb = "";
$bb = $book['book_number'] ?? "";





?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>貸し出し画面</title>
    <script type="text/javascript" src="lending_service.js"></script>
    <script>
        function lending1() {
            return window.confirm('この書籍を貸出しますか？');
        }
    </script>
    <!-- <link rel="stylesheet" href="lending_service.css"> -->
</head>

<body>

    <h1>貸し出し画面</h1>

    窓口番号：<?php echo $count; ?><br> <!--窓口番号を表示する（窓口管理番号Labelに窓口テーブルのレコード数+1の数が表示されていることを、DBを参照して確認すること）-->

    <form method="post">
        利用者番号　　　
        <input type="search" name="usrnum" id="usrnum"><!--利用者番号入力フォーム-->
        <input type="submit" name="Userbutton" value="検索"> <!--<input type="button" name="lockIn" value="検索内容を確定する" onclick="writeLock1();">-->
        <input type="hidden" name="booknum" value="<?php echo $_POST["booknum"] ?? ""; ?>">
    </form>

    氏名　　<?php echo $user["user_name"] ?? ""; ?><br>

    性別　　<?php echo $user["sex_type"] ?? ""; ?><br>

    学年　　<?php echo $user["school_year"] ?? ""; ?><br>

    <form method="post">
        書籍番号　　　　
        <input type="search" name="booknum" id="booknum"><!--書籍番号入力フォーム-->
        <input type="submit" name="bookbutton" value="検索"><!--検索ボタン--><!--<input type="button" name="lockIn" value="検索内容を確定する" onclick="writeLock2();">-->
        <input type="hidden" name="usrnum" value="<?php echo $_POST["usrnum"] ?? ""; ?>">
    </form>

    タイトル　　<?php echo $book["book_name"] ?? "" ?><br>

    著者　　<?php echo $book["author"] ?? ""; ?> <br>

    <input type="button" value="クリア" onclick="clear1()" /><!--クリアボタン-->
    <form method="post" onsubmit="lending1()">
        <input type="hidden" name="booknum" value="<?php echo $_POST["booknum"] ?? ""; ?>">
        <input type="hidden" name="usrnum" value="<?php echo $_POST["usrnum"] ?? ""; ?>">
        <input type="submit" value="貸出し" name="lending" /><!--貸出ボタン-->
    </form>
    <input type="button" value="戻る" onclick="history.back();"><!--戻るボタン-->

</body>

</html>