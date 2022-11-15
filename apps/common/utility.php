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
