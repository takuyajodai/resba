<?php
  //接続用パラメータの設定
  $host = 'localhost'; //データベースが動作するホスト
  $user = 'www'; //DBユーザ名（各自が設定）
  $pass = 'www'; //DBパスワード（各自が設定）
  $dbname = 'resbattle';//データベース名（各自が設定）

  // mysqliクラスのオブジェクトを作成
  $mysqli = new mysqli($host,$user,$pass,$dbname);
  if ($mysqli->connect_error) { //接続エラーになった場合
  echo $mysqli->connect_error; //エラーの内容を表示
  exit();//終了
  } else {
  //echo "You are connected to the DB successfully.<br>"; //正しく接続できたことを確認
  $mysqli->set_charset("utf8"); //文字コードを設定
  }
  //入力データの受取
  if(!empty($_POST["topic_title"]) && !empty($_POST["description"]) && !empty($_POST["position1"]) && !empty($_POST["position2"])){
  //POSTされた変数の受取
  $topic_title = $_POST["topic_title"];
  $description = $_POST["description"];
  $position_red = $_POST["position1"];
  $position_blue = $_POST["position2"];
  
  //テーマの登録
  $sql = "insert into topics (topic_title, description, position_red, position_blue) values ('$topic_title','$description', '$position_red', '$position_red')"; //実行するSQLを文字列として記述
  $result = $mysqli->query($sql); //SQL文の実行
  if ($result) { //SQL実行のエラーチェック
    header('Location:index.php?success=1');
  } else {
    //echo "データの登録に登録に失敗しました <br>";
    //echo "SQL文：$sql <br>"; //本当は表示しないほうがいい
    //echo "エラー番号：$mysqli->errno <br>";
    //echo "エラーメッセージ：$mysqli->error <br>";
    header('Location:make_topic.php?error=1');
    exit();
  }

  $result->close(); // 結果セットを閉じる
  $mysqli->close(); // 接続を閉じる
  } else {
  //echo "入力されていない項目があります。<br>";
  header('Location:make_topic.php?error=4');
  }
?>