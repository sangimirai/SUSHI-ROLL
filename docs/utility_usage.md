# utility.phpの使い方

## まず最初に

以下をファイルの先頭に書き足してください。

```php
<?php require_once("../common/utility.php"); ?>
```

## 続いて

### データベースを使いたいとき

#### FuncSelectSql関数

selectの結果を返してくれます

##### 使用例

```php
<?php
# テーブルに登録されているすべての情報が変数に入ります。
$変数 = FuncSelectSql("select * from テーブル名;");

# プリペアードステースメントが使用できます。
$変数 = FuncSelectSql("select * from テーブル名 where 列名 = :値;", [":値" => 入れたい値]);
```

##### 具体例

```php
<?php
# すべての本の名前を取得する
$books = FuncSelectSql("select book_name from books");

# idが123の本の全ての情報を取得する
$book = FuncSelectSql("select * from books where id = :id;", [":id" => 123]);
$book = FuncSelectSql("select * from books where id = ?;", [123]);
```

#### FuncExecuteSql関数

insert, update, deleteなどの更新された行数を返してくれます。

##### 使用例

```php
<?php
$変更のあった行数 = FuncExecuteSql("insert into テーブル名 values ('値');");

# プリペアードステースメントが使用できます。
$変更のあった行数 = FuncExecuteSql("inset into テーブル名 values(:値1, :値2);",
                                  [":値1" => 入れたい値1, ":値2" => 入れたい値2]);
```

##### 具体例

```php
<?php
# 例
$count = FuncSelectSql("insert into books(book_id) value(:id);", [":id" => 123]);
# または
$count = FuncSelectSql("insert into books(book_id) value(?);", [123]);
```

#### FuncExecuteAnySql関数

すべてのSQLを実行できます｡
`execute()`した結果が返ってくるので、`fetch()`や`rowCount()`などを適用が可能です｡

##### 使用例

```php
<?php
$変数 = FuncExecuteAnySql("select 列名 from テーブル名;").fetch();
```

実行結果が不要な場合はこのような書き方も可能です｡

```php
<?php
FuncExecuteAnySql("insert into books(book_id) value(123);");
```

### プルダウンを作成したい時

引数に入れたコード区分のプルダウンの中身を作成します。

```php
<select>
  <?php
    # コード区分を渡します
    # 1は本のカテゴリ（その他は資料を見て下さい）
    FuncMakePulldown(1);
  ?>
</select>
```

### XSS対策（クロスサイトスクリプティング）をする

htmlspecialcharsが長いため短くしました。  
出力したものをhtmlに出すときは必ず使用して下さい。XSSが発生します。

```php
# 使用例
<?php
echo h("出力したい文字列");
?>

氏名: <?php echo h($userName); ?>
```
