<?php

declare(strict_types=1);

error_reporting(0);

$showCodeType = [1, 4]; //修正を表示する区分

//プルダウン作成
function FuncMakePulldown($codeType)
{
    // $table = FuncSelectSql("SELECT * FROM code_types WHERE code_type=$codeType");
    ($table = FuncDataBaseConnection()->prepare("SELECT * FROM code_types WHERE code_type=$codeType"))->execute();
    while ($i = $table->fetch()) {
        echo "<option value='{$i["code"]}'>{$i['code_name']}</option>";
    }
}

function FuncDataBaseConnection()
{
    $host = getenv("DB_HOST");
    $dbName = getenv("MYSQL_DATABASE");
    $user = getenv("MYSQL_USER");
    $password = getenv("MYSQL_PASSWORD");
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION
    ];
    $dsn = "mysql:dbname={$dbName};host={$host};charset=utf8";
    try {
        $dataBase = new PDO($dsn, $user, $password, $options);
        return $dataBase;
    } catch (Exception $e) {
        echo "Database Error: " . $e->getMessage();
        exit();
    }
}

/**
 * htmlspecialcharsのラッパー関数
 */
function h(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Select文を実行する関数
 * 実行結果が連想配列で返ってきます
 *
 * @param string $sql
 * @param array<string, mixed> $param
 * 
 * @return array<string, mixed>
 */
function FuncSelectSql(string $sql, array $param = []): array
{
    $stmt = FuncExecuteAnySql($sql, $param);
    return $stmt->fetchAll();
}

/**
 * Insert, Update, Delete文を実行する関数
 * 変更のあった行数が返ってきます。
 *
 * @param string $sql
 * @param array<string, mixed> $param
 *
 * @return int
 */
function FuncExecuteSql(string $sql, array $param = []): int
{
    $stmt = FuncExecuteAnySql($sql, $param);
    return $stmt->rowCount();
}

/**
 * 任意のSQLを実行する関数
 *
 * @param string $sql
 * @param array<string, mixed> $param
 *
 * @return PDOStatement
 */
function FuncExecuteAnySql(string $sql, array $param): PDOStatement
{
    $stmt = FuncDataBaseConnection()->prepare($sql);
    $stmt->execute($param);
    return $stmt;
}

/**
 * ログインしているか
 */
function is_login(int $user_type): bool
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION["user"]["user_type"]) || !isset($_SESSION["user"]["use_type"])) {
        return false;
    }

    // 利用出来ない場合
    if ($_SESSION["user"]["use_type"] != 0) {
        return false;
    }

    if ($_SESSION["user"]["user_type"] != $user_type) {
        return false;
    }

    return true;
}

/**
 * login.phpへリダイレクトする関数
 */
function redirect_to_login(): void
{
    header("Location: /sushi/apps/common/login.php");
    exit();
}


// TODO: 引数をuser_typeからuser_numberに変更したい。
/**
 * ユーザが利用できるか判定する関数
 * ログインしていない場合、Loginに遷移する。
 * 引数はuserのuser_typeを指定する。
 * 利用者なら`FuncCheckSession(0)`
 * 管理者なら`FuncCheckSession(1)`
 */
function FuncCheckSession(int $user_type): void
{
    if (!is_login($user_type)) {
        redirect_to_login();
    }
    // この行に来る場合、ログインしているユーザであるはず...
}
