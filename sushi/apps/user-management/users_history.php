<?php
/*
    FuncExecuteAnySqlの使い方がわからんから今回のプログラムだと0番目に確実に入るから暫定的に[0]を付けてFuncSelectSqlを使った余裕があったらfetch使ってFuncExecuteAnySqlを使う
*/
    require_once("../common/utility.php");//共通部品を取得
    function exitpage($error_message = "無効な利用者番号です。"){
        echo "<script>alert('" . $error_message . "');</script>";
        header("Location: http://10.123.100.101/sushi/apps/user-management/users_list.php");
        exit();
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>利用者詳細画面</title>
        <link rel="stylesheet"href="style.css">
    </head>
<?php
    $db = FuncDataBaseConnection();//DBにつなぐ library_test
    if(isset($_REQUEST['user_number']) && is_numeric($_REQUEST['user_number'])){//user_numberがnullでなくさらに数字であるか
        $userNumber = $_REQUEST['user_number'];//利用者番号を前の画面から受け取る
        $userDate = FuncSelectSql("SELECT * FROM users WHERE user_number= :$userNumber", [":$userNumber" =>$_REQUEST['user_number']]);
        $userDate = $userDate[0];//解決法が思いつかなくて面倒になった
    }else{//nullもしくは数字でないなら
        exitpage();
    }
    if(! isset($userDate['user_number'])){//リクエストが無効な数字なら表示させない
        exitpage();
    }
?>
    <body>
        <!--dbから投げられたデータを拾って利用者のデータ表示-->
        <table>
            <!-- データにeach htmlspecialchars して中身を表示する -->
            <tr>
                <th>利用者番号</th>
                <td><?php echo h($userDate['user_number']); //番号?></td>
            </tr>
            <tr>
                <th>氏名</th>
                <td><?php echo h($userDate['user_name']); //氏名?></td>
            </tr>
            <tr>
                <th>性別</th>
                <td><?php echo h($userDate['sex_type']); //性別?></td>
            </tr>
            <tr>
                <th>学年</th>
                <td><?php echo h($userDate['school_year']); //学年?></td>
            </tr>
            <tr>
                <th>利用可否フラグ</th>
                <td><?php echo h($userDate['use_type']); //フラグ?></td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td><?php echo h($userDate['password']); //パスワード?></td>
            </tr>
            <tr>
                <th>区分</th>
                <td><?php echo h($userDate['user_type']); //利用者区分?></td>
            </tr>
            <!-- 利用者のデータここまで -->
            <!-- 窓口と本のデータここから-->
            <tr>
                <th>これまでに借りた冊数</th>
                
                <td>
                    <?php 
                                $lendCount = FuncSelectSql("SELECT lending_user_number, COUNT(lending_user_number='" . $userNumber . "') AS count FROM reception_list GROUP BY lending_user_number ORDER BY lending_user_number DESC");//貸出数
                                $lendCount = $lendCount[0];//解決法が思いつかなくて面倒になった
                                echo h($lendCount['count']);
                    ?>
                </td>
            </tr>
            <tr><!--データによっては変更前提-->
            <?php
                $receptionDate = FuncSelectSql("SELECT * FROM reception_list WHERE lending_user_number= '" . $userNumber . "' ORDER BY lending_date DESC");//貸出データ引っ張り出す
                $receptionDate = $receptionDate[0];//解決法が思いつかなくて面倒になった
                $bookNumber = $receptionDate['book_number'];
                $bookDate = FuncSelectSql("SELECT * FROM books WHERE book_number= '". $bookNumber ."'");//図書データ引っ張り出す
                $bookDate = $bookDate[0];//解決法が思いつかなくて面倒になった
            ?>
                <th><center>借りた本のリスト<center></th>
                <td><center>期間</center><br>
                    <?php
                        if(isset($receptionDate['lending_date'])){
                            echo h("{$receptionDate['lending_date']}~"); //貸出日
                            if($receptionDate['return_date']){
                                echo h($receptionDate['return_date']);//返却日
                            }else{
                                echo ("");}//返却されていないなら表示しない
                        }else{
                            echo ("");
                        }
                    ?></br>
                </td>
                <td><center>タイトル<center><br>
                    <?php
                        echo h($bookDate['book_name']); //タイトル
                    ?></br>
                </td>
                <td><center>カテゴリ<center><br>
                    <?php
                        echo h($bookDate['category']); //カテゴリ
                    ?></br></td>
                <td><center>著者<center><br>
                    <?php
                        echo h($bookDate['author']); //著者
                    ?></br>
                </td>
            </tr>
        </table>
    </body>
</html>