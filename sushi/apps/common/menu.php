<?php
require('utility.php');
session_start();
// 関数を起動する
FuncCheckSession(1);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <title>窓口メニュー</title>
    <link rel="stylesheet" href="style_login_menu.css" type="text/css">
</head>

<body>

    <h1 class="center">窓口管理メニュー</h1>
    <h3 class="miniTitle">書籍管理</h3>
    <a class="btn-style-link" href='../book-management/books_resist.php'>本の登録</a>
    <a class="btn-style-link" href='../book-management/books_list.php'>本の検索</a>

    <h3 class="miniTitle">窓口業務</h3>
    <a class="btn-style-link" href='../reception/lending_service.php'>貸出</a>
    <a class="btn-style-link" href='../reception/return_service.php'>返却</a>
    <a class="btn-style-link" href='../reception/books_status_list.php'>窓口検索</a>

    <h3 class="miniTitle">利用者管理</h3>
    <a class="btn-style-link" href='../user-management/users_resist.php'>利用者の登録</a>
    <a class="btn-style-link" href='../user-management/users_list.php'>利用者の検索</a>

    <h3 class="miniTitle">共通</h3>
    <a class="btn-style-link" href='code_type_resist.php'>コード区分マスタ</a>

</body>

</html>