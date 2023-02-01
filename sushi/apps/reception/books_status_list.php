<!--01/27現在 未実装機能/未解決項目-->
<!--
・10件以上のテーブルを表示/非表示(未検証)
・追記:上記機能に関わる関数及び処理を削除
-->

<!--表示データの準備(テーブルに表示するデータ,エラーメッセージ,表示用フラグ)-->
<?php

//共通部品取得
require_once('../common/utility.php');

//DB接続
$db = FuncDataBaseConnection();

//メッセージ用
$errormsg = "";
$sysmsg = "";

//出力制御
$frag = 0;  //表示フラグ、表示データが存在する場合に「1」にする
$count = 0; //行数カウンタ

//クエリ用
$array_where = array(); //SQL文を格納
$array_dat = array(); //POSTされるデータを格納
$sortType = ""; //ASC DESC

//"検索"ボタンを押したときの処理
if (isset($_POST['search'])) {
  //入力チェック(全て空値かどうか)
  if (
    empty($_POST["reception_number"]) and
    empty($_POST["book_number"]) and
    empty($_POST["lending_user_number"]) and
    empty($_POST["lending_date"]) and
    empty($_POST["return_date"]) and
    empty($_POST["jyoukyou"])
  ) {
    $errormsg = '項目を一つ以上埋めてください';
    //入力がある場合  
  } else {
    //入力値を変数に格納(空値は無視する),上から[窓口管理番号,書籍番号,利用者番号,貸出日,返却日,現在状況,ソート順(昇順/降順)]
    //テキストボックス、前方一致検索用の文字列を準備
    if (!empty($_POST["reception_number"])) {
      $array_where[] = 'reception_number LIKE ?';
      $array_dat[] = $_POST["reception_number"] . '%';
    }
    if (!empty($_POST["book_number"])) {
      $array_where[] = 'book_number LIKE ?';
      $array_dat[] = $_POST["book_number"] . '%';
    }
    if (!empty($_POST["lending_user_number"])) {
      $array_where[] = 'lending_user_number LIKE ?';
      $array_dat[] = $_POST["book_number"] . '%';
    }
    if (!empty($_POST["lending_date"])) {
      $array_where[] = 'lending_date LIKE ?';
      $array_dat[] = $_POST["lending_date"] . '%';
    }
    if (!empty($_POST["return_date"])) {
      $array_where[] = 'return_date LIKE ?';
      $array_dat[] = $_POST["return_date"] . '%';
    }

    //プルダウン、ソート機能と利用可否フラグをチェックする文字列を準備
    if ($_POST["jyoukyou"] == 9) {
      $array_where[] = 'return_date IS NULL'; //NULLチェックは「返却日」を見る
    } else {
      $array_where[] = 'return_date IS NOT NULL';
    }

    if ($_POST["sorttype"] == "昇順") {
      $sortType = ' ORDER BY reception_number DESC'; //ソートは「窓口管理番号」基準
    } else {
      $sortType = ' ORDER BY reception_number ASC';
    }
    //ソート機能用テキスト以外を連結
    $keywords = implode(" AND ", $array_where);

    //クエリの送信(.implode()で変数に格納したSQL呼出し)
    $sql = 'SELECT * FROM reception_list WHERE ' . $keywords . $sortType; //WHERE + 連結文字列 + ソート文  
    $table = $db->prepare($sql);
    $table->execute($array_dat);
    $count = $table->rowCount(); //行数カウンタに行数を格納 
    $s_list = $table->fetchAll(PDO::FETCH_ASSOC);
    if ($count < 10) {
      $frag = 1; //表示フラグをON
    }
    $sysmsg = "検索結果 ";
  }
} else {
  //[検索]ボタンを押していないとき
  $sql = 'SELECT * FROM reception_list WHERE 1';
  $table = $db->prepare($sql);
  $table->execute();
  $s_list = $table->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!--表示するデータの処理終了-->

<!--Script-->
<!--処理の続行/中止を制御する-->
<script>
  //返却用リンククリック時
  function move_return() {
    var res = confirm("この書籍を返却しますか?");
    if (res == true) {
      // OKの場合移動
      window.location.href = 'return_service.php';
    } else {
      // キャンセルならアラートボックスを表示
      alert("処理を中断しました");
    }
  }
  //【クリア】ボタンクリック時
  function reset_check() {
    if (window.confirm("画面をクリアしますか?")) {
      window.location.href = 'books_status_list.php' //自身に遷移
      return true;
    } else {
      alert("処理を中断しました");
      return false;
    }
  }
</script>
<!--Script終了-->

<!--HTML-->
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>窓口状態検索</title>
</head>

<body>
  <h1>窓口状態検索</h1>
  <form action="books_status_list.php" method="post" name="books_status_list" onReset="return reset_check()">
    <p>窓口管理番号<input type="text" id="reception_number" name="reception_number"></p>
    <p>書籍番号<input type="text" id="book_number" name="book_number"></p>
    <p>利用者番号<input type="text" id="lending_user_number" name="lending_user_number"></p>
    <p>貸出日<input type="text" id="lending_date" name="lending_date"></p>
    <p>返却日<input type="text" id="return_date" name="return_date"></p>
    <p>現在状況
      <select id="jyoukyou" name="jyoukyou"><?php FuncMakePulldown(2); ?></select>
    </p>
    <p>ソート順<select id="sorttype" name="sorttype" size="1">
        <option>------</option>
        <option>昇順</option>
        <option>降順</option>
      </select>
    </p>
    <p><input type="submit" name="search" value="検索"></p>
    <p><input type="reset" value="クリア"></p>
  </form>

  <!--検索結果-->
  <?php if (isset($_POST["search"]) && $frag != 0) { ?>
    <?php echo $sysmsg . $count . '件' ?>
    <table border="1">
      <tr>
        <th>窓口管理番号</th>
        <th>書籍番号</th>
        <th>利用者番号</th>
        <th>貸出日</th>
        <th>返却日</th>
        <th>返却</th>
      </tr>
      <?php foreach ($s_list as $table) { ?>
        <tr>
          <td><?php echo $table["reception_number"] ?></td>
          <td><?php echo $table["book_number"] ?></td>
          <td><?php echo $table["lending_user_number"] ?></td>
          <td><?php echo $table["lending_date"] ?></td>
          <td><?php echo $table["return_date"] ?></td>
          <td><a href="javascript:move_return();">この利用者の返却画面へ</a></td>
        </tr>
      <?php } ?>
    </table>
  <?php } elseif ($frag == 0) { ?>
    <?php echo $errormsg; ?>
  <?php } ?>
</body>

</html>