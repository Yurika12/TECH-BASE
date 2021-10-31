<!DOCTYPE html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php

$filename="mission_3-5.txt";
//投稿機能
//フォーム内が空でない場合に以下を実行する
if(!empty($_POST["name"])&&!empty($_POST["comment"])){
    //入力データの受け取りを変数に代入
    $name=$_POST["name"];
    $comment=$_POST["comment"];
    $pass=$_POST["pass"];
    //日付データを取得して変数に代入
    $postedAt=date("Y年m月d日　H:i:s");
    //編集フォームに入力がない場合は新規投稿、ある場合は編集　ここで判断
    if(empty($_POST["editNO"])){
        //以下、新規投稿機能
        //ファイルの存在がある場合は投稿番号+1,なかったら１に指定する
        if(file_exists($filename)){
            $num=count(file($filename))+1;
        }else{
            $num=1;
        }
        //書き込む文字列を組み合わせた変数
        $newdata=$num."<>".$name."<>".$comment."<>".$postedAt."<>".$pass."<>".PHP_EOL;
        //ファイルを追記保存モードでオープンする
        $fp=fopen($filename,"a");
        //入力データのファイル書き込み
        fwrite($fp,$newdata);
        fclose($fp);
        }
        }
    

//編集選択
//編集フォームの送信の有無で処理を分岐
if(!empty($_POST["editNO"])){
    //もし、編集フォームに入力されたら
    //以下編集機能
    //入力データの受け取りを変数に代入
    $editNO=$_POST["editNO"];
    $editpass=$_POST["editpass"];
    //読み込んだファイルの中身を配列に格納する
    $ret_array=file($filename);
    //配列の数だけループさせる
    foreach($ret_array as $line){
    //explode関数でそれぞれの値を取得
    $data=explode("<>",$line);
    if($data[0]==$editNO && $data[4]==$editpass){
        //ファイルを書き込みモードでオープン、中身をからに
        $fp=fopen($filename,"w");
        //編集フォームから送信された値と差し替えて上書き
        fwrite($fp,$editNO."<>".$name."<>".$comment."<>".$postedAt);
    }else{
        //一致しなかったところはそのまま書き込む
        fwrite($fp,$line);
    }
    }
    fclose($fp);
}
//編集フォームの送信の有無で処理を分岐
if(!empty($_POST["editID"])){
    //入力データの受け取りを変数に代入
    $ID=$_POST["editID"];
    //読み込んだファイルの中身を配列に格納する
    $editCon=file($filename);
    //配列の数だけループさせる
    foreach($editCon as $line){
        //explode関数でそれぞれの値を取得
        $editdata=explode("<>",$line);
        //投稿番号と編集対象番号が一致したら、その投稿の「名前」と「コメント」を取得
        if($editID==$editdata[0] && $editpass==$editdata[4]){
            //投稿のそれぞれの値を取得し変数に代入
            $editnumber=$editdata[0];
            $editname=$editdata[1];
            $editcomment=$editdata[2];
            //既存の投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる
            //formのvalue属性で対応
        }
    }
    }
?>


<form action="mission_3-5.php" method="post">
    <input type="text" name="name" placeholder="名前"><br>
    <textarea  name="comment" placeholder="コメント"></textarea><br>
    <input type="text" name="editNO" value="<?php if(isset($edit)){echo $editnumber;}?>">
    <input type="text" name="pass" placeholder="パスワード"><br>
<input type="submit" name="submit" value="送信"><br>
</form>

<form action="mission_3-5.php" method="post">
    <input type="text" name="dnum" placeholder="削除対象番号"></br>
    <input type="text" name="delpass" placeholder="パスワード"><br>
    <input type="submit" name="delete" value="削除"><br>
</form>


<form action="mission_3-5.php" method="post">
    <input type="text" name="editNO" placeholder="編集対象番号"></br>
    <input type="text" name="editpass" placeholder="パスワード">
    <input type="submit" name="send_edit" value="編集"><br>
</form>


</body>
</html>

