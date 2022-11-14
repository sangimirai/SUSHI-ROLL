# SUSHI-ROLL

## 図書管理システム

2022年のシステム開発という授業の制作物

### 必要なもの

- Docker
- Make（任意）

### 使い方

1. このリポジトリをクローン
2. 以下のコマンドを実行する

```sh
docker compose up
```

3. 以下のサービスが起動する

```sh
# httpd
http://localhost

# phpmyadmin
http://localhost:8080
```

```sh
DBのid, password
# user = sushi, roll
# root = root, root
```


### 静的解析

コードにエラーがないかphpstanで確認します。

```sh
make lint
```
