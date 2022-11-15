<?php
declare(strict_types=1);

class Config {

    private string $dbHost;
    private string $dbName;
    private string $dbUser;
    private string $dbPass;

    function __construct() {
        $this->dbHost = getenv("DB_HOST") ? getenv("DB_HOST") : "";
        $this->dbName = getenv("MYSQL_DATABASE") ? getenv("MYSQL_DATABASE") : "";
        $this->dbUser = getenv("MYSQL_USER") ? getenv("MYSQL_USER") : "";
        $this->dbPass = getenv("MYSQL_PASSWORD") ? getenv("MYSQL_PASSWORD") : "";
    }

    function GetDbHost(): string {
        return $this->dbHost;
    }

    function GetDbName(): string {
        return $this->dbName;
    }

    function GetDbUser(): string {
        return $this->dbUser;
    }

    function GetDbPass(): string {
        return $this->dbPass;
    }
}
