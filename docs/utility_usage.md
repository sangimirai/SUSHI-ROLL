# utility.phpの使い方

## まず最初に

以下をファイルの先頭に書き足してください。

```php
<?php require_once("../common/utility.php"); ?>
```

## 続いて

### データベースを使いたいとき

#### FuncSelectSql関数

selectの結果を返してくれます。

```php
<?php
# テーブルに登録されているすべての情報が変数に入ります。
$変数 = FuncSelectSql("select * from テーブル名;");

# プリペアードステースメントが使用できます。
$変数 = FunctionSql("select * from テーブル名 where 列名 = :値", [":値" => 入れたい値]);
```

#### FuncExecuteSql関数

insert, update, deleteの更新行数を返してくれます。


```php
<?php
$変更のあった行数 = FuncExecuteSql("insert into テーブル名 values ('値');");

# プリペアードステースメントが使用できます。
$変更のあった行数 = FuncExecuteSql("inset into テーブル名 values(:値1, :値2);",
                                  [":値1" => 入れたい値1, ":値2" => 入れたい値2]);
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
