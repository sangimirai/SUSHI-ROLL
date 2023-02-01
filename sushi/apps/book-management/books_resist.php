<?php require_once("../common/utility.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  FuncExecuteSql("
    INSERT into books(book_number, book_name, author, category, lending_type) VALUES
      ({$_POST["books_number"]}, \"{$_POST["books_name"]}\",\"{$_POST["books_author"]}\",\"{$_POST["category"]}\",\"{$_POST["lending_type"]}\");
  ");
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title></title>
</head>

<body>
  <h1>書籍登録</h1>
  <h2>書籍内容</h2>
  <form id="form" action="books_resist.php" method="post">
    <p>書籍番号<input type="text" name="books_number" id="number" /> </p>
    <p>タイトル<input type="text" name="books_name" /></p>

    <p>著者<input type="text" name="books_author" /></p>

    <p>カテゴリ
      <select name="category">
        <?php
        FuncMakePulldown(1);
        ?>
      </select>
    </p>

    <p>貸出し可否フラグ
      <select name="lending_type">
        <?php
        FuncMakePulldown(2);
        ?>
      </select>
    </p>

    <dialog>
      <p>画面をクリアしますか？</p>
      <input type="button" id="reset" value="はい" onclick="clearText()" />
      <button id="close">いいえ</button>
    </dialog>
    <button id="clear">クリア</button>
    <script type="text/javascript">
      var dialog = document.querySelector('dialog');
      var btn_show = document.getElementById('clear');
      var btn_close = document.getElementById('close');
      var btn_reset = document.getElementById('reset');
      btn_show.addEventListener('click', function() {
        dialog.showModal();
      }, false);
      btn_close.addEventListener('click', function() {
        dialog.close();
      }, false);
      btn_reset.addEventListener('click', function() {
        var textForm = document.getElementById("number");
        textForm.value = '';
      });
    </script>

    <input type="submit" id="submit-button" name="resist" value="登録">
  </form>
  <script>
    const submitButton = document.querySelector('#submit-button');
    const form = document.querySelector('#form');
    submitButton.addEventListener('submit', (event) => {
      event.stopPropagetion();
      event.preventDefault();
      const formData = new formData(form);
      const options = {
        method: 'POST',
        body: formData,
      }
      const url = form.getAttribute('action');
      fetch(url, option);
    });
  </script>

  <dialog id="2">
    <p>窓口メニューへ戻ります</p>
    <button onclick="location.href='../common/menu.php'">はい</button>
    <button id="close2">いいえ</button>
  </dialog>
  <button id="back">戻る</button>
  <script type="text/javascript">
    var dialog2 = document.getElementById('2');
    var btn_show2 = document.getElementById('back');
    var btn_close2 = document.getElementById('close2');
    btn_show2.addEventListener('click', function() {
      dialog2.showModal();
    }, false);
    btn_close2.addEventListener('click', function() {
      dialog2.close();
    }, false);
  </script>
</body>

</html>