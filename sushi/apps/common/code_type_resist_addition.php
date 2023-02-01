<?php
    require_once("../common/utility.php");
    $codeType = "";
    if(isset($_GET['code_type'])){
        $codeType = $_GET['code_type'];
    }
    $max = "";
    $codeCheck = true;
    if(!in_array($codeType,$showCodeType)){
        echo "<script>alert('この区分は存在しないか修正・変更ができません');</script>";
        $codeCheck = false;
        // echo "<script>window.close();</script>";
        // echo "<script>location.href = 'http://10.123.100.101/sushi/app/common/menu.php'</script>";
    }
    // if(!FuncSelectSql("SELECT * FROM code_types WHERE code_type=$codeType")->fetch()){
    //($table = FuncDataBaseConnection()->prepare("SELECT * FROM code_types WHERE code_type=$codeType"))->execute();
    $table=[];
    if($codeCheck){
        $table = FuncSelectSql("SELECT * FROM code_types WHERE code_type=$codeType");
    }
    if(!$table or $codeCheck){//存在しない区分できたときページを閉じる
        // echo "<script>alert('存在しない区分コードです');</script>";
        $codeCheck = false;
        // echo "<script>window.close();</script>";
        // echo "<script>location.href = 'http://10.123.100.101/sushi/app/common/menu.php'</script>";
    }else{
        ($table = FuncDataBaseConnection()->prepare("SELECT MAX(code) FROM code_types WHERE code_type=$codeType;"))->execute();
        $tmp = $table->fetch();
        $max = $tmp["MAX(code)"];
        $max = $max+1;
        if(!empty($_POST['code_name'])){
            try{            
                $codeName = $_POST['code_name'];
                // ($table = FuncDataBaseConnection()->prepare("SELECT MAX(code) FROM code_types WHERE code_type=$codeType;"))->execute();
                // $tmp = $table->fetch();
                // $max = $tmp["MAX(code)"];
                // $max = $max+1;
                //($table = FuncDataBaseConnection()->prepare("INSERT INTO code_types(code_type,code,code_name) VALUES ($codeType,$max,'$codeName');"))->execute();
                FuncExecuteSql("INSERT INTO code_types(code_type,code,code_name) VALUES ($codeType,$max,'$codeName');");
                $max = $max+1;
                echo "<script>alert('追加しました');</script>";
            }catch(Exception $e){
                echo "<script>alert('失敗しました');</script>";
            }
        }
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
<h1>追加</h1>
<form method="post" name ="codeTypes" onsubmit="return check();">
    <table>
        <tr>
            <th>区分</th>
            <td><input type="text" size="30" value="<?php echo $codeType; ?> " disabled></td>
        </tr>
        <tr>
            <th>コード</th>
            <td><input type="text" size="30" value="<?php echo $max; ?> " disabled></td>
        </tr>
        <tr>
            <th>名称</th>
            <td><input type="text" name="code_name" size="30" value="" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php
                    if($codeCheck){
                        echo '<input type="submit" value="登録">';
                    }
                ?>
            </td>
        </tr>
    </table>
</form>
<Script>
    function check() {
        var newCodeName = document.codeTypes.code_name.value;
        return confirm("区分"+'<?php echo $codeType;?>'+"に"+newCodeName+"を追加しますか?");
    }
</Script>
</body>
</html>
