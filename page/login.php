
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
        a.btn{
            padding:5px 8px;
            border-radius: 4px;
            background:#66bb6a;
        }
        a{
            color:white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>量大一卡</h1>
        <p><?php if(isset($msg))echo $msg;else echo "请登录" ?></p>
        <div><br><br><a class="btn" href="?action=login">点击登录</a></div><br>
        <div><small>继续操作即代表您同意本平台的<a href="./intro/eula.html">《用户协议》</a></small></div>
        <p><a href="./intro/">关于</a></p>
    </div>
    <script src="webapp.js"></script>
</body>
</html>

