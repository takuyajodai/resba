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
        <div class="content_header">
          <div class="topic"><h2 class="topic">レスバトル一覧</h2></div>
          <button type="button" class="button button_topic" onclick="location.href='make_topic.php'">テーマを作成</button>
        </div>
        <hr>

        <div class="column">
          <table>
            <tr>
              <th></th>
              <th></th>
            </tr>
            <?php
              $sql = "SELECT * FROM topics"; //実行するSQLを文字列として記述
              $result = $mysqli->query($sql); //SQL文の実行
              if ($result) {
                while($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td class="left"><a class="table_topic" href="resbattle.php?topic_id='.$row['topic_id'].'">'.$row['topic_title'].'</td>';
                  echo '<td class="right"><p class="table_date">'.$row['posted_time'].'</p></td>';
                  echo '</tr>';
                }
              }
            ?>

        </div>
      </div>
      <?php
    ?>
  </body>
  </html>

<?php
} else {
  header('Location:user.php?error=0');
}

