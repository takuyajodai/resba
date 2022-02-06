<?php
  session_start(); //セッション開始
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

      <div class="form">
        <?php
        $error = $_GET['error'];
        if($error == '0'){
          print '<div style="text-align: center; padding-bottom: 20px">';
          print '<p style="color: #DF4A6D;">利用前にログイン又は会員登録をしてください</p>';
          print '</div>';
        }
        if($error == '1'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">DBにアクセスできません</p>';
					print '</div>';
				}
				if($error == '2'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">このユーザー名はすでに使われています</p>';
					print '</div>';
				}
				if($error == '3'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">パスワードが一致していません</p>';
					print '</div>';
				}
				if($error == '4'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">フォームに入力漏れがあります</p>';
					print '</div>';
				}
				if($error == '5'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">パスワードが間違っています</p>';
					print '</div>';
				}
				if($error == '6'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">このユーザー名は登録されていません</p>';
					print '</div>';
				}
				if($error == '7'){
					print '<div style="text-align: center; padding-bottom: 20px">';
					print '<p style="color: #DF4A6D;">ログアウトしました</p>';
					print '</div>';
				}

        ?>
        <form action="make_topic_exec.php" method="post">
          <h2>テーマを作成します</h2>
          <dl>
            <dt>テーマタイトル:</dt>
            <dd>
            <div class="password_box">
                  <div class="password_inner">
                    <input class="input" id="text1" type="text" name="topic_title" requied>
                    <div class="password_string">テーマを入力</div>
                  </div>
                  <i class="fas fa-eye-slash"></i>
              </div>
            </dd>
            <dt>概要:</dt>
            <div class="group">
              <dd>
              <div class="password_box">
                  <div class="password_inner">
                    <input class="input" id="text4" type="text" name="description" requied>
                    <div class="password_string">テーマの概要</div>
                  </div>
                  <i class="fas fa-eye-slash"></i>
              </div>
            </div>
            </dd>
            <button class="button" type="submit">作成</button>
          </dl>
        </form>
        <script>
          $('#text4').focus(function(){
            $('.password_box').animate({borderTopColor: '#3be5ae', borderLeftColor: '#3be5ae', borderRightColor: '#3be5ae', borderBottomColor: '#3be5ae'}, 200);
          }).blur(function(){
              $('.password_box').animate({borderTopColor: '#d3d3d3', borderLeftColor: '#d3d3d3', borderRightColor: '#d3d3d3', borderBottomColor: '#d3d3d3'}, 200);
          });
      </script>
      </div>
    </div>
    <?php
  ?>
</body>
</html>
