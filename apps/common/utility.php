<?php
declare(strict_types=1);

/**
 * htmlspecialcharsのラッパー関数
 */
function h(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * データベースへの接続関数
 */
function FuncDataBaseConnection(): PDO{
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
        $dataBase = new PDO($dsn,$user,$password, $options);
        return $dataBase;
    }catch(Exception $e){
        echo "Database Error: ". $e->getMessage();
        exit();
    }
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
function FuncSelectSql(string $sql, array $param): array{
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
function FuncExecuteSql(string $sql, array $param): int{
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
function FuncExecuteAnySql(string $sql, array $param): PDOStatement{
    $stmt = FuncDataBaseConnection()->prepare($sql);
    $stmt->execute($param);
    return $stmt;
}
