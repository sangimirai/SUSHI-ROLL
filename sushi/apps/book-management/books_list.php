
<?php require_once("../common/utility.php"); ?>
<?php
    
    $book_number = $_POST["book_number"];
    $book_name = $_POST["book_name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $sequential = $_POST["sequential"];
    $select = $_POST["select"];


?>


<!DOCTYPE html>



<html>
    <head>
        <link rel="stylesheet" href="CSSのURL">
        <meta charset="utf-8">
        <title>書籍検索</title>
    </head>
    <body>
      <form action="books_list.php" method="post">
       <h2 style="text-align:center">書籍検索</h2>

        <center>
         <p style="text-align:center">書籍番号<form action="" method="post">
         <input type="search" name="book_number" placeholder=""></p>
        </center>

         <center>
         <p style="text-align:center">タイトル<form action="" method="post">
         <input type="search" name="book_name" placeholder=""></p>
         </center>

         <center>
         <p style="text-align:center">著者<form action="" method="post">
         <input type="search" name="author" placeholder=""></p>
         </center>

         <center>
         <p style="text-align:center">カテゴリ
         <select name="category" onechenge="chenge(this)">
         <option value=''>選択なし</option>
            <?php
              # 1は本のカテゴリ
              FuncMakePulldown(1);
            ?>
          </select>
        </p>
        </center>
        <center>
         <p style="text-align:center">ソート順
         <select name="sequential" onechenge="chenge(this)">
         <option value="book_number">書籍番号</option>
         <option value="book_name">タイトル</option>
         <option value="author">著者</option> 
         <option value="category">カテゴリ</option> 
         </select>

         <select name="select" onechenge="chenge(this)">
         <option value="1">昇順</option>
         <option value="2">降順</option>
         </select></p>
         </center>

    <center>
     <button type="submit" style="text-align:center">検索</button>
    </center>
    </form>


    <p>表示件数
      <?php
        $x;
        $count = FuncSelectSql("SELECT * FROM books where book_name like '%$book_name%' and book_number like '$book_number%' and author like '%$author%' and category like '%$category%' order by $sequential");
        foreach( $count as $a){
          if($a == 0){
            $x = 0;
            echo $x;
          }else{
            $x = $x++;
            echo $x;
          }
        }
    ?>
    </p>
    <table border="1" align="center">
    <?php
     $table;
     if($select == 1){
      $table = FuncSelectSql("SELECT * FROM books where book_name like '%$book_name%' and book_number like '$book_number%' and author like '%$author%' and category like '%$category%' order by $sequential");
     }else{
      $table = FuncSelectSql("SELECT * FROM books where book_name like '%$book_name%' and book_number like '$book_number%' and author like '%$author%' and category like '%$category%' order by $sequential desc");
      
     }

     echo "
     <tr>
     <th>書籍番号</th>
     <th>タイトル</th>
     <th>著者</th>
     <th>カテゴリ</th>
     <th>詳細</th>
     </tr>";

     foreach ( $table as $i ) {
      echo "<tr>";
      echo  "<td>{$i['book_number']}</td>";
      echo "<td>{$i['book_name']}</td>";
      echo "<td>{$i['author']}</td>";
      echo "<td>{$i['category']}</td>";
      echo "<td><a target='_blank' href='books_property.php?id=".$i['book_number']."'>この書籍の詳細画面へ</a></td>";
      echo "</tr>";
      $y++;
     }

    ?>
    </table>





  <button type="reset" style="text-align:right">クリア</button>
    </body>
</html>