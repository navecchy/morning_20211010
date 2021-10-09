<?php
session_start();

$dsn         = 0;
$url['user'] = 0;
$url['pass'] = 0;

// POSTされたトークンを取得
$token = isset($_POST["token"]) ? $_POST["token"] : "";

// セッション変数のトークンを取得
$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";

// セッション変数のトークンを削除
unset($_SESSION["token"]);

// POSTされたトークンとセッション変数の比較
if($token != "" && $token == $session_token) {
// 以前のコード
// if(isset($_POST['content']) && $_POST['content']) {
    try {
        //input_post.phpの値を取得
        $store_name = $_POST['store_name'];
        $category = $_POST['category'];
        $content = $_POST['content'];


        $dbh = new PDO($dsn, $url['user'], $url['pass']); //MySQLのデータベースに接続
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //PDOのエラーレポートを表示
    
        $sql = "INSERT INTO news_and_event (store_name, category, content) VALUES (:store_name, :category, :content)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダ
        $stmt = $dbh->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
        $params = array(':store_name' => $store_name, ':category' => $category, ':content' => $content); // 挿入する値を配列に格納する
        $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
    
      } catch (PDOException $e) {
      exit('データベースに接続できませんでした。A' . $e->getMessage());
      }
} else if(isset($_POST['delete']) && $_POST['delete']) {
    try {
        $id = $_POST['delete']; 
                    
        $dbh = new PDO($dsn, $url['user'], $url['pass']); //MySQLのデータベースに接続

        // SQL準備
        $stmt = $dbh->prepare("DELETE FROM news_and_event WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        // SQL実行
        $stmt->execute();
    } catch (PDOException $e) {
      exit('データベースに接続できませんでした。B' . $e->getMessage());
      }
}





//------------------------------------------------------------------表示部分
            
try{
    $dbh = new PDO($dsn, $url['user'], $url['pass'],[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]
    );
    $sql = "SELECT * FROM news_and_event";
	$stmt = $dbh->query($sql);
    $TaskList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($TaskList);
    
    $dbh = null;

}catch (PDOException $e){
    echo '接続失敗' . $e->getMessage();
    exit();
}

$column_List = [];
foreach($TaskList as $column){
    array_push($column_List , $column['content']);
}
$column_List = array_reverse($column_List); 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico">
    <title>第4回 朝礼</title>
</head>
<body>
    <div class="wrapper">
        <?php include('parts/header.html'); ?>

        <main>
            <div class="main_contents width_1000">
                <div class="description">
                    <h3>二重送信の防止</h3>
                    <ul>
                        <li>
                            <p>
                                POSTに値が残って何回も送信される。
                            </p>
                        </li>
                        <li>
                            <p>
                                参考→<a href="../../～/Application/user.php">ポートフォリオ</a>
                            </p>
                        </li>
                    </ul>
                </div>

                <h3>データベース内容</h3>
                <div class="scrollbar flex_space-between width_1000">
                    <div class="overview">
                                                        
                        <?php                             
                        foreach(array_reverse($TaskList) as $column): ?>
                            <div class="news_">
                                <div>
                                    <span><?php echo date('Y/m/d', strtotime($column['updated_at'])) ?></span>
                                    <img src="./img/<?php
                                        if ($column['store_name']=="丸の内") echo "marunouchi";
                                    ?>.gif" alt="店名">
                                    <img src="./img/<?php
                                        if ($column['category']=="お知らせ") echo "ico_info";
                                        if ($column['category']=="メニュー") echo "menu";
                                    ?>.gif" alt="カテゴリー">

                                    <?php if($column == end($TaskList)):?>
                                        <img src="./img/new.PNG" alt="カテゴリー">
                                    <?php endif; ?>

                                    <br>
                                    <p>
                                        <a href="">
                                            <?php echo $column['content'] ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach;?>

                    </div>
                </div>
                <div class="flex_space-around">
                    <div class="contents_handler">
                        <a href="./AddTask.php">コンテンツ操作</a>
                    </div>
                    <div class="contents_handler">
                        <a href="./">Topへ戻る</a>
                    </div>
                </div>
                <div class="home flex_end">
                    <p><a href="./">戻る</a></p>
                </div>
            </div>
        </main>

        <?php include('parts/footer.html'); ?>

    </div>
</body>
</html>