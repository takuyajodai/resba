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
  if(!empty($_POST["username"]) && !empty($_POST["password"])){
  //POSTされた変数の受取
  $username = $_POST["username"];
  $password = $_POST["password"];
  //ユーザ名が既に使用されているかのチェック
  $sql = "select password from users where username = '$username'"; //実行するSQLを文字列として記述
  $result = $mysqli->query($sql); //SQL文の実行
  if( $result->num_rows == 0){
      //echo "ユーザ名「${username}」は登録されていません。<br>";
      header('Location:login.php?error=6');
      exit();
  }
  $row = $result->fetch_assoc(); //結果から一行づつ読み込み
  $db_enc_passwd = $row["password"]; //データベースからパスワード読み込み
  $uid = $row["uid"]; //データベースからUIDを取得
  if(password_verify($password, $db_enc_passwd)) {
      //echo "ユーザ「${username}」が正しく認証されました。<br>";
      //セッション開始
      session_start(); //セッションを開始する
      $_SESSION['uid'] = $username; //セッション変数uidにデータベースから取得したUIDを登録
      header('Location:index.php?success=4');
  } else {
      //echo "ユーザ「${username}」を認証できませんでした。パスワードが一致しません。<br>";
      header('Location:login.php?error=5');
      exit();
  }
  $result->close(); // 結果セットを閉じる
  $mysqli->close(); // 接続を閉じる
  } else {
  //echo "入力されていない項目があります。<br>";
  header('Location:login.php?error=4');
  }
?>