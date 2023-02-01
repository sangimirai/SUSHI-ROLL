<?php

require_once('utility.php');

session_start();

/*
    ***進捗・挙動について***
    DBに接続して、入力された user_number password 利用可否,利用区分
    の情報を基に、利用者区分に応じて menu.php か book-management.php に遷移する。

    ログイン時における入力値の空欄のチェックは現状行わない(20230126)
*/

// 新ローカルは utility_local.php
// サーバは utility.php

// form が送信されたときの処理
if (!empty($_POST)) {
    // 入力されたIDを $userId に格納
    $userId = $_POST['user_number'];
    // $userId 確認用
    // echo $userId;

    // sqlに接続し、入力されたIDと一致するレコードを $table に格納
    $sql = "SELECT * FROM users WHERE user_number=? limit 1";
    $table = FuncSelectSql($sql, [$userId])[0];

    // レコード取得の正否によって処理を分岐する
    if ($table) {
        // user_number が DB に存在するとき
        if ($table['password'] == $_POST['password']) {
            // パスワードのDBの登録値と入力値が一致するとき
            if ($table['use_type'] != 0) {
                // 利用可否フラグが 0 ではないときはログイン不可
                // print("ログインできません");
                $error = "ログインできません";
            } else {

                // 利用可否フラグが正常値 0 のとき
                if ($table['user_type'] == 1) {
                    // 利用区分が 1 であれば窓口メニューへ遷移
                    // print("madoguchi");
                    // セッション情報として $table を保持
                    $_SESSION['user'] = $table;
                    // print_r($_SESSION['user']);
                    header('Location: menu.php');
                    exit();
                } elseif ($table['user_type'] == 0) {
                    // 利用区分が 0 であれば本の検索画面へ遷移
                    // print("shousai");
                    header('Location: ../book-management/books_list.php');
                    exit();
                } else {
                    // 利用区分が1でも0でもない
                    // 利用区分が正常値ではないとき
                    // print("利用者区分が正しくありません");
                    $error = "利用者区分が正しくありません";
                }
            }
        } else {
            // パスワードが一致しないとき
            // print("パスワードが正しくありません");
            $error = "パスワードが正しくありません";
        }
    } else {
        // print("ID が一致しません。");
        $error = "IDが一致しません。";
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>ログイン-図書システム</title>
</head>

<body>
    <script>
        // ID・パスワードの入力値をリセットする
        window.onpageshow = function() {
            document.getElementById("f1").reset();
        };
    </script>
    <h2>図書システム　ログイン</h2>

    <form method="post" id="f1">
        <div>
            <input type="text" name="user_number" placeholder="ID">
        </div>
        <div>
            <input type="password" name="password" placeholder="パスワード">
        </div>
        <div>
            <input type="submit" value="ログイン"><br>
        </div>
        <!-- エラーメッセージを表示 -->
        <div><?= $error ?? "" ?></div>
    </form>
</body>

</html>