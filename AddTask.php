<?php
session_start();

// 二重送信防止用のトークンの発行
$token = uniqid('', true);

// トークンをセッション変数にセット
$_SESSION['token'] = $token;

// データベースへの接続情報が入ります。
$dsn         = 0;
$url['user'] = 0;
$url['pass'] = 0;
            
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
                                参考→<a href="../../ ～ /Application/user.php">ポートフォリオ</a>
                            </p>
                        </li>
                    </ul>
                </div>

                <h3>データベース内容</h3>
                <div class="scrollbar flex_space-between width_1000">
                    <div class="overview">
                                                        
                        <?php                             
                        foreach(array_reverse($TaskList) as $column): ?>
                            <div class="news_ flex_space-between">
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
                                <?php $i = $column['id'];?>
                                <div class="delete_content">
                                    <form method="post"  id ="form_<?php  echo $i;?>" action="./registration.php">
                                        <input type="hidden" name="delete" value="<?php echo $i;?>">
                                        <div class="contents_handler">
                                            <a  href="javascript:void(0)" onclick="FormSubmit(<?php  echo $i;?>);">DELETE</a> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach;?>
                        
                    </div>
                </div>
                
                <div class="flex_center width_950">
                    <form class="news" method="post" name="thisform" action="./registration.php">
                        <div class="form">store_name</div>
                        <select name="store_name" id="store_name">
                            <option value="">選択してください</option>
                            <option value="丸の内">丸の内</option>
                        </select>
                        <div class="form">category</div>
                        <select name="category" id="category">
                            <option value="">選択してください</option>
                            <option value="お知らせ">お知らせ</option>
                            <option value="メニュー">メニュー</option>
                        </select>
                        <div class="form">content</div>
                        <textarea class="textarea" name="content" id="content" rows="10"></textarea>
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                    </form>
                </div>

                <div class="flex_space-around">
                    <div class="contents_handler">
                        <a href="javascript: thisform.submit()">新規投稿</a>
                    </div>
                    <div class="contents_handler">
                        <a href="./registration.php">管理画面へ戻る</a>
                    </div>
                </div>
                <div class="home flex_end">
                    <p><a href="./">戻る</a></p>
                </div>
            </div>
        </main>

        <?php include('parts/footer.html'); ?>

    </div>
    <script src="./js/javascript.js"></script>
    <script>
        'use strict';
        console.log( thisform );
    </script>
</body>
</html>