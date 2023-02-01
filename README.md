# SUSHI-ROLL

## 図書管理システム

2022年のシステム開発実習の制作物

### 必要なもの

- Docker
- Make

### 使い方

1. このリポジトリをクローン
2. 以下のコマンドを実行する

```sh
make up

# コンテナ環境の初期化
# docker compose down -v
```

3. 以下のサービスが起動する

```sh
# 図書館システム
http://localhost
```

- ログイン用のクレデンシャル
  - 管理者：ID = 4 PASS = pass4
  - 利用者：ID = 1 PASS = pass1

4. データベースを直接確認したい場合はこちら

```
# phpmyadmin
http://localhost:8080
```

