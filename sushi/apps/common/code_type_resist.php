<?php require_once("../common/utility.php"); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>コード区分マスタ</h1>
<table border="1">
    <tr>
        <th>区分</th>
        <th>コード</th>
        <th>名称</th>
        <th>修正</th>  
    </tr>
    <?php
//SQLの実行も行う場合
        // $table = FuncSelectSql("SELECT * FROM code_types");
        // $sql = "SELECT * FROM code_types";
        // $table = FuncDataBaseConnection()->prepare($sql);
        // $table->execute();
//接続のみの場合

        // ($table = FuncDataBaseConnection()->prepare("SELECT * FROM code_types"))->execute();

        $table = FuncSelectSql("SELECT * FROM code_types");

        // while($i = $table->fetch()){
        //     echo "<tr>";
        //     echo "<td>{$i['code_type']}</td>";
        //     echo "<td>{$i['code']}</td>";
        //     echo "<td>{$i['code_name']}</td>";
        //     if(in_array($i['code_type'], $showCodeType)){
        //         echo "<td><a target='_blank' href='code_type_resist_correct.php?code_type=".$i['code_type']."&code=".$i['code']."'>修正</a></td>";
        //     }else{
        //         echo "<td></td>";
        //     }
        //     echo "</tr>";
        // } 

        foreach ( $table as $i ) {
            echo "<tr>";
            echo "<td>{$i['code_type']}</td>";
            echo "<td>{$i['code']}</td>";
            echo "<td>{$i['code_name']}</td>";
            if(in_array($i['code_type'], $showCodeType)){
                echo "<td><a target='_blank' href='code_type_resist_correct.php?code_type=".$i['code_type']."&code=".$i['code']."'>修正</a></td>";
            }else{
                echo "<td></td>";
            }
                echo "</tr>";
        }
    ?>
</table>
</body>
</html>
