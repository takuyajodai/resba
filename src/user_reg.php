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
  header('Location:user.php?error=1');
  exit();//終了
  } else {
  //echo "You are connected to the DB successfully.<br>"; //正しく接続できたことを確認
  $mysqli->set_charset("utf8"); //文字コードを設定
  }
  //入力データの受取
  if(!empty($_POST["username"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])){
  //POSTされた変数の受取
  $username = $_POST["username"];
  $password1 = $_POST["password1"];
  $password2 = $_POST["password2"];
  //ユーザ名が既に使用されているかのチェック
  $sql = "select * from users where username = '$username'"; //実行するSQLを文字列として記述
  $result = $mysqli->query($sql); //SQL文の実行
  if( $result->num_rows != 0){
      //echo "ユーザ名「${username}」はすでに登録されているため使用できません。<br>";
      header('Location:user.php?error=2');
      exit();
  }
  //パスワードが一致するかのチェック
  if($password1 != $password2) {
      //echo "パスワードが一致しません<br>";
      header('Location:user.php?error=3');
      exit();
  }
  //パスワードの暗号化
  $enc_passwd = password_hash($password1,PASSWORD_DEFAULT); //ソルトを使ったパスワードの暗号化
  //ユーザの登録
  $sql = "insert into users (username, password) values ('$username','$enc_passwd')"; //実行するSQLを文字列として記述
  $result = $mysqli->query($sql); //SQL文の実行
  if ($result) { //SQL実行のエラーチェック
      session_start(); //セッションを開始する
      $sql = "SELECT uid FROM users WHERE username='$username'";
      $result2 = $mysqli->query($sql); //SQL文の実行
      if ($result2) {
        $row = $result2->fetch_assoc(); //結果から一行づつ読み込み
        $uid = $row["uid"]; //データベースからUIDを取得
        $_SESSION['uid'] = $uid;
        header('Location:index.php?success=4');
      } else {
        header('Location:user.php?error=1');
        exit();
      }
  } else {
      //echo "データの登録に登録に失敗しました <br>";
      //echo "SQL文：$sql <br>"; //本当は表示しないほうがいい
      //echo "エラー番号：$mysqli->errno <br>";
      //echo "エラーメッセージ：$mysqli->error <br>";
      header('Location:user.php?error=1');
      exit();
  }
  // DB接続を閉じる
  $mysqli->close();
  } else {
    //echo "入力されていない項目があります。<br>";
    header('Location:user.php?error=4');
  }
?>