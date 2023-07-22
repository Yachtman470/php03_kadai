<?php
include("funcs.php");  //funcs.phpを読み込む（関数群）

//1. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = db_conn();      //DB接続関数
  // $pdo = new PDO('mysql:dbname=blumhouse_gs_php02_db;charset=utf8;host=mysql57.blumhouse.sakura.ne.jp','blumhouse','Enter1901');
  // $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_bm_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<a href="bm_update_view.php?id='.h($r["id"]).'">';
    $view .= h($r["id"])." | ".h($r["name"])." | ".h($r["url"])." | ".h($r["comment"])." | ".h($r["datetime"]);
    // $view .= $res['id'].', '.$res['name'].', '.$res['url'].', '.$res['comment'].', '.$res['datetime'];
    $view .= '</a>';

    $view .= '<a href="delete.php?id='.h($r["id"]).'">';
    $view .= "[削除]<br>";
    $view .= '</a>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>書籍ブックマーク</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">ブックマークした書籍一覧</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
