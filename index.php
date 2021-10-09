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
                <h3>身につけた技術</h3>
                <ul>
                    <li>
                        <a href="./pdo.php">PDOの使い方</a>
                    </li>
                    <li>
                        <a href="./registration.php">二重送信の防止</a>
                    </li>
                    <li>
                        <a href="./servlet.php">サーブレットを使った基本的な機能</a>
                    </li>                </ul>
                <h3>身につけたい技術</h3>
                <ul>
                    <li>
                        <a href="./relation.php">データベースのリレーション</a>
                    </li>
                    <li>
                        <a href="save_image">データベースへ画像の保存</a>
                    </li>
                </ul>
            </div>
        </main>

        <?php include('parts/footer.html'); ?>

    </div>
</body>
</html>