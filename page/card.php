<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require("head.php") ?>
    <style>
        html,body{
            height:100%;
            color: white;
        }
        body {
            background: linear-gradient(to bottom, rgb(5, 140, 238), rgb(5, 140, 238));
        }
        .container {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }
        img {
            width: calc(100% - 50px);
        }
        p {
            display: inline-block;
            width: calc(100% - 50px);
            background: rgba(0,0,0,0.5);
            border-radius: 5px;
        }
        a{
            color:white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>量大一卡</h1>
        <div>点击图片可以刷新</div>
        <img onclick="location.reload()" src="<?php echo $qrRes; ?>" alt="image">
        <div><small><?php echo htmlentities($nameRes); ?></small></div>
        <p>余额：￥ <?php echo htmlentities($ammountRes); ?></p>
        <p><a href="?action=logout">登出</a>&nbsp;&nbsp;&nbsp;<a href="about.php">关于</a></p>
    </div>
    <script src="webapp.js"></script>
</body>
</html>
