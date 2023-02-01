<?php
    require_once("../common/utility.php");
    // var_dump(empty($_GET['code_type']));
    // var_dump($_GET['code_type']);
    // if(empty($_GET['code_type']) or empty($_GET['code'])){
    //     echo "<script>window.close();</script>";
    // }
    $codeType = "";
    $code = "";
    if(isset($_GET['code_type']) and isset($_GET['code'])){
        $codeType = $_GET['code_type'];
        $code = $_GET['code'];
    }
    $codeName = "";
    $codeCheck = true;
    if(!in_array($codeType,$showCodeType)){
        echo "<script>alert('この区分は存在しないか修正・変更ができません');</script>";
        $codeCheck = false;
        // echo "<script>window.close();</script>";
        // echo "<script>location.href = 'http://10.123.100.101/sushi/app/common/menu.php'</script>";
    }
    //接続のみ
    //($table = FuncDataBaseConnection()->prepare("SELECT * FROM code_types WHERE code_type=$codeType AND code=$code"))->execute();

    $table=[];
    if($codeCheck){
        $table = FuncSelectSql("SELECT * FROM code_types WHERE code_type=$codeType AND code=$code");
    }
    if(!$table and $codeCheck){//存在しない区分コードできたときページを閉じる
        echo "<script>alert('存在しない区分コードです');</script>";
        // echo "<script>window.close();</script>";
        // echo "<script>location.href = 'http://10.123.100.101/sushi/app/common/menu.php'</script>";
        $codeCheck = false;
    }else{
        foreach($table as $tmp){
            $codeName = $tmp['code_name'];
        }
    }
    if(!empty($_POST['code_name'])){
        $codeName = $_POST['code_name'];
        //($table = FuncDataBaseConnection()->prepare("UPDATE code_types SET code_name = '$codeName'  WHERE code_type=$codeType AND code=$code"))->execute();

        FuncExecuteSql("UPDATE code_types SET code_name = '$codeName'  WHERE code_type=$codeType AND code=$code");

        echo "<script>alert('更新しました');</script>";
    }
?>
<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>修正</h1>

<form method="POST" name ="codeTypes" onsubmit=" return check()">
    <table>
        <tr>
            <th>区分</th>
            <td><input type="text" size="30" value="<?php echo $codeType; ?> " disabled></td>
        </tr>
        <tr>
            <th>コード</th>
            <td><input type="text" size="30" value="<?php echo $code; ?> " disabled></td>
        </tr>
        <tr>
            <th>名称</th>
            <td><input type="text" name="code_name" size="30" value="<?php echo $codeName; ?>" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                    if($codeCheck){
                        echo '<input name="aaa"type="submit" value="更新">';
                    }
                ?>
            </td>
        </tr>
    </table>
</form>
<a target='_blank' href='code_type_resist_addition.php?code_type=<?php echo $codeType ?>'>追加</a>
<script>
    function check() {
        var newCodeName = document.codeTypes.code_name.value;
        return confirm('<?php echo $codeName;?>'+"を"+newCodeName+"に変更しますか?");
    }
</script>
</body>
</html>
