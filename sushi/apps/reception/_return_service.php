<?php
ini_set('display_errors', 1);

require_once("../common/utility.php");

echo $a;



$stmt = FuncDataBaseConnection()->prepare("select * from users where user_number = :user_number");
$stmt->bindValue(":user_number", 1);
$stmt->execute();
$users = $stmt->fetchAll();
$stmt = FuncDataBaseConnection()->prepare("select * from books where book_number = :book_number");
$stmt->bindValue(":book_number", 1);
$stmt->execute();
$book = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script>
        function confirm_return() {
            var res = confirm("この書籍を返却しますか?\n「OK」で返却\n「キャンセル」で処理を中断");
            if (res == true) {
                // OKなら移動
                window.location.href = "/sushi/apps/reception/books_status_list.php";
            } else {
                // キャンセルならアラートボックスを表示
                alert("処理を中断。");
            }
        }

        function confirm_reset() {
            var res = confirm("画面をクリアしますか?\n「OK」でクリア\n「キャンセル」で処理を中断");
            if (res == true) {
                // OKなら移動
                location.href = location.href.split('?');
            } else {
                // キャンセルならアラートボックスを表示
                alert("処理を中断。");
            }
        }

        function confirm_back() {
            var res = confirm("窓口メニューへ戻りますか?\n「OK」で戻る\n「キャンセル」で処理を中断");
            if (res == true) {
                // OKなら移動
                window.location.href = "/sushi/apps";
            } else {
                // キャンセルならアラートボックスを表示
                alert("処理を中断。");
            }
        }
    </script>
    <title>返却</title>
</head>

<body class="adminBg">

    <div class="registerForm">
        <h1>書籍返却</h1>
        <form method="post">
            <dl>
                <dt>窓口管理検索
                    <input type="text" name="input">
                    <input type="submit" name="submit" value="検索">
                </dt>
                <dt>利用者番号</dt>
                <dd>
                    <?php echo $users[0]['user_number']; ?>
                </dd><br>

                <dt>氏名</dt>
                <dd><?php echo $users[0]['user_name']; ?>
                </dd><br>

                <dt>性別</dt>
                <dd><?php echo $users[0]['sex_type']; ?>
                </dd><br>

                <dt>学年</dt>
                <dd><?php echo $users[0]['school_year']; ?></dd><br>

                <dt>書籍番号</dt>
                <dd><?php echo $book[0]['book_number']; ?></dd><br>
                <dt>タイトル</dt>
                <dd><?php echo $book[0]['book_name']; ?></dd><br>
                <dt>著者</dt>
                <dd><?php echo nl2br($book[0]['author']); ?></dd>
            </dl>
        </form>
        <form action="" method="post" onsubmit="">
            <input class="registerButton" type="button" name="reset" value="クリア" onclick="confirm_reset()">
            <input class="registerButton" type="button" name="return" value="返却" onclick="confirm_return()">
            <input class="registerButton" type="button" name="back" value="戻る" onclick="confirm_back()">
        </form>
    </div>

</body>

</html>