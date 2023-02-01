<?php

declare(strict_types=1);

require_once("../common/utility.php");



$err = (function () {
    if (!isset($_POST["num"])) {
        return;
    }

    // 返却日にnullが入っているか確認
    $return_date = FuncSelectSql(
        "select return_date from reception_list where reception_number = ?",
        [$_POST["num"]]
    )[0]["return_date"];

    if ($return_date != null) {
        return "返却済みです。";
    }

    // 返却のSQL
    FuncExecuteSql(
        "update reception_list set return_date = current_date where reception_number = ? ",
        [$_POST["num"]]
    );

    return;
})();


$table = (function () {
    $table = FuncSelectSql(
        "select
            r.reception_number,
            r.lending_user_number,
            u.user_name,
            c_g.code_name as sex_type,
            c_y.code_name as school_year,
            b.book_number,
            b.book_name,
            b.author
        from
            reception_list r
            inner join books b on b.book_number = r.book_number
            inner join users u on u.user_number = r.lending_user_number
            inner join code_types c_g on c_g.code_type = 3 and c_g.code = u.sex_type
            inner join code_types c_y on c_y.code_type = 4 and c_y.code = u.school_year
        where
            r.reception_number = ?
        limit 1",
        [$_GET["num"] ?? ""]
    );

    return $table[0] ?? [];
})();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>返却</title>
</head>

<body>
    <h1>書籍返却</h1>
    <table>
        <tr>
            <td>窓口管理番号</td>
            <td>
                <form>
                    <input type="number" name="num">
                    <button type="submit">検索</button>
                </form>
            </td>
        </tr>
        <tr>
            <td>利用者番号</td>
            <td><?= $table['lending_user_number'] ?? "" ?></td>
        </tr>
        <tr>
            <td>氏名</td><td><?= $table['user_name'] ?? "" ?></td>
        </tr>
        <tr>
            <td>性別</td>
            <td><?= $table['sex_type'] ?? "" ?></td>
        </tr>
        <tr>
            <td>学年</td>
            <td><?= $table['school_year'] ?? "" ?></td>
        </tr>
        <tr>
            <td>書籍番号</td>
            <td><?= $table['book_number'] ?? "" ?></td>
        </tr>
        <tr>
            <td>タイトル</td>
            <td><?= $table['book_name'] ?? "" ?></td>
        </tr>
        <tr>
            <td>著書</td>
            <td><?= $table['author'] ?? "" ?></td>
        </tr>
    </table>
    <form method="POST">
        <input type="hidden" name="num" value="<?= $_GET["num"] ?? "" ?>">
        <input type="submit" value="返却">
    </form>
    <p><?= $err ?? "" ?></p>
</body>

</html>