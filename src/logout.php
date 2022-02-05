<?php
	session_start(); //セッションを開始する
	$_SESSION['uid'] = null; //セッション変数uidにデータベースから取得したUIDを登録
	session_destroy();
	header('Location:user.php?error=7');
?>
