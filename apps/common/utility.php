<?php
declare(strict_types=1);

require_once(dirname(__FILE__)."/../../config/config.php");

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
    $config = new Config();
    $dsn = "mysql:dbname={$config->GetDbName()};host={$config->GetDbHost()};charset=utf8";
    $user = $config->GetDbUser();
    $password = $config->GetDbPass();
    try {
        $dataBase = new PDO($dsn,$user,$password);
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
    $stmt = FuncDataBaseConnection()->prepare($sql);
    $stmt->execute($param);
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
    $stmt = FuncDataBaseConnection()->prepare($sql);
    $stmt->execute($param);
    return $stmt->rowCount();
}
