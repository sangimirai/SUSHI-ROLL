<?php

require_once("../common/utility.php");

$err = (function () {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    // 重複確認するとこ
    $count = FuncExecuteSql("select * from users where user_number = ?;", [$_POST["user_number"]]);
    if (0 < $count) {
        return "※すでに使われている利用者番号です。";
    }

    // データ入れるとこ
    FuncExecuteSql(
        "insert into users(user_number,user_name,sex_type,school_year,use_type,password,user_type) values(?, ?, ?, ?, ?, ?, ?);",
        [$_POST["user_number"], $_POST["user_name"], $_POST["sex_type"], $_POST["school_year"], $_POST["use_type"], $_POST["password"], $_POST["user_type"]]
    );
})();


?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title> </title>
    <link rel="stylesheet" href="users_resist.css">
</head>

<body>
    <h1>利用者登録画面</h1>

    <form method="post">
        <table>
            <tr>
                <th>お名前（※三十文字以内で入力してください。）</th>
                <td>
                    <input type="text" name="user_name" size="30" required>

                </td>
            </tr>

            <tr>
                <th>性別を選択してください。</th>
                <td>
                    <select name="sex_type">
                        <?php FuncMakePulldown(3);  ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>学年を選択してください。</th>
                <td>
                    <select name="school_year">
                        <?php FuncMakePulldown(4);  ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>利用可否フラグを選択してください。</th>
                <td>
                    <select name="use_type">
                        <?php FuncMakePulldown(2);  ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th>パスワードを英数字のみ1～30桁以内で入力してください。</th>
                <td>
                    <input type="password" name="password" size="30" required>
                </td>
            </tr>

            <tr>
                <th>利用者番号を20桁以内で入力してください。</th>
                <td>
                    <input type="number" name="user_number" size="20" required>

                </td>
            </tr>

            <tr>
                <th>区分を選択してください。</th>
                <td>
                    <label>
                        <input type="radio" name="user_type" value="0" required>
                        <span>一般</span>
                    </label>
                    <label>
                        <input type="radio" name="user_type" value="1" required>
                        <span>窓口</span>
                    </label>
                </td>
            </tr>
        </table>
        <br>
        <div>
            <input type="submit" value="登録する"></td>
        </div>
        <div>
            <?= $err ?? "" ?>
        </div>
    </form>

</body>

</html>