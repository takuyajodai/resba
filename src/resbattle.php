<?php
session_start();
if(isset($_SESSION['uid'])) {
  $uid = $_SESSION['uid'];
  ?>

  <!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <title>レスバトル</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
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
      ?>
      <div class="wrap">
        <header>
            <h1 class="logo">RESBA</h1>
            <ul class="global-nav">
              <?php
                if( isset($_SESSION['uid'])) {
              ?>
                  <li class="global-nav-item"><a href="index.php">HOME</a></li>
                  <li class="global-nav-item"><a href="about.php">ABOUT</a></li>
                  <li class="global-nav-item"><a href="logout.php">LOGOUT</a></li>
              <?php  
                } else {
              ?>
                  <li class="global-nav-item"><a href="about.php">ABOUT</a></li>
                  <li class="global-nav-item"><a href="login.php">LOGIN</a></li>
                  <li class="global-nav-item"><a href="user.php">SIGNIN</a></li>
              <?php
                } 
              ?>
            </ul>
        </header>
        <div class="content">
        <?php
          $error = $_GET['error'];
          if($error == '0'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">DBに接続できません</p>';
            echo '</div>';
          }
          if($error == '1'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">DBの登録に失敗しました</p>';
            echo '</div>';
          }
          if($error == '2'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">フォームに入力漏れがあります</p>';
            echo '</div>';
          }

          $success = $_GET['success'];
          if($success == '1'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">データの登録に成功しました</p>';
            echo '</div>';
          }
          if($success == '2'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">データの修正に成功しました</p>';
            echo '</div>';
          }
          if($success == '3'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">データの削除に成功しました</p>';
            echo '</div>';
          }
          if($success == '4'){
            echo '<div style="text-align: center; padding-bottom: 20px">';
            echo '<p style="color: #4C8FFB;">ログインしました</p>';
            echo '</div>';
          }
	      ?>
        <div class="chat">
          <div class="content_header">
            <?php
              $topic_id = $_GET['topic_id'];
              $sql = "SELECT * FROM topics WHERE topic_id=$topic_id"; //実行するSQLを文字列として記述
              $result = $mysqli->query($sql); //SQL文の実行
              if ($result) {
                while($row = $result->fetch_assoc()) {
                  ?>
                  <div class="tmp">
                    <?php
                    echo '<h2 class="chat_topic">'.$row['topic_title'].'</h2>';
                    ?>
                    <a id="red" href="#" class="circle1">
                      <p style="color:#fff; font-weight700;">赤</p>
                    </a>
                    <a id="blue" href="#" class="circle2">
                      <p style="color:#fff; font-weight700;">青</p>
                    </a>
                  </div>
                  <?php
                  echo '<h3 class="description">'.$row['description'].'</h3>';
                }
              }
            ?>
          </div>
          <div class="main">
              <div class="progress_back">
                  <div class="progress_front" width="50%"></div>
              </div>
            </div>
          <div class="content_chat">
            <?php
              //メッセージが入力されていたら登録
                if(!empty($_POST["main_text"] && !empty($_POST["position"]))){
                  $topic_id = $_GET['topic_id'];
                  $main_text = $_POST["main_text"];
                  $position = $_POST["position"];
                  $sql = "INSERT INTO messages (main_text, uid, position, topic_id) VALUES ('$main_text', $uid, $position, $topic_id)"; //実行するSQLを文字列として記述
                  $result = $mysqli->query($sql); //SQL文の実行
                  if ($result) { //SQL実行のエラーチェック
                    //echo "データの登録に成功しました";
                  } else {
                    echo "SQL文：$sql";
                    echo "エラー番号：$mysqli->errno";
                    echo "エラーメッセージ：$mysql->error";
                    exit();
                    header('Location:resbattle.php?error=1');
                    exit();
                  }
                } else {
                  //echo "テキストが登録されていません<br>";
                }
            ?>
            <div class="chat_box">
              <div class="chat_content" id="chat_content">
                <div class="chat_text">
                  <?php
                    $sql = "SELECT main_text, position, DATE_FORMAT(posted_time,'%H:%i') AS posted_time FROM messages WHERE topic_id = $topic_id order by posted_time"; //実行するSQLを文字列として記述
                    $result = $mysqli->query($sql); //SQL文の実行
                    if ($result) { //実行結果が正しければ
                      // 連想配列を取得
                      while($row = $result->fetch_assoc()){ //結果から一行づつ読み込み
                        if($row["position"] == 1) {
                          $position = "red";
                        } else if($row["position"] == 2) {
                          $position = "blue";
                        } else {
                          $position = "other";
                        }
                        echo '<div class="chat_area '.$position.'"><p class="'.$position.'">'. $row["posted_time"] . ' - ' . $row["main_text"].'</p></div><br>'; //結果を整形して表示
                      }
                      // 結果セットを閉じる
                      $result->close();
                    }
                  ?>
                  <p id="anchor"></p>
                </div>
              </div>
            </div>
          </div>

          <div class="content_input">
            <?php
              echo '<form class="send-box flex-box" action="resbattle.php?topic_id='.$topic_id.'#anchor" method="post">';
            ?>
              <div class="radio">
                <input type="radio" id="red" name="position" value=1 required>
                <label for="red" class="red_side">赤陣営</label>
                <input type="radio" id="blue" name="position" value=2 required>
                <label for="blue" class="blue_side">青陣営</label>
              </div>
              <div class="group" id="group">
                <div class="password_box" id="password_box">
                    <div class="password_inner">
                      <input class="input" id="text4" type="text" name="main_text" requied placeholder="メッセージを入力">
                    </div>
                    <i class="fas fa-eye-slash"></i>
                </div>
                <button type="submit" class="button send_chat_button">送信</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
      <?php
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function(){
      let r_count = 1;
      let b_count = 1;
        $('#red').click(function(){ 
            r_count++;
            let per = r_count / (r_count + b_count);
            console.log(per);
            $('.progress_front').css('width', per*100+"%");
        });

        $('#blue').click(function(){
            b_count++; 
            let per = b_count / (r_count + b_count);
            $('.progress_front').css('width', (1-per)*100+"%");
        });
    });
</script>
  </body>
  </html>

<?php
} else {
  header('Location:user.php?error=0');
}

