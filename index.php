<?php
require_once("utils.php");
require_once("cjlu_oauth.php");
if(isset($_GET["token"]) && ($token = $_GET["token"])!=""){
    //Receive OAuth Token(Token str driectly)
    setcookie("ctoken", $token, time()+60*60*24*30,null,null,null,TRUE);
    header("Location: ".strtok($_SERVER['REQUEST_URI'], '?'));
}else if(isset($_GET['action']) && ($action = $_GET['action'])!=""){
    if($action == "login"){
        jump_noreferer(cjlu_oauth_geturl(getpageurl()."?action=oauth",getpageurl(),true));
    }else if($action == "reauth"){
        jump_noreferer(cjlu_oauth_geturl(getpageurl()."?action=oauth",getpageurl(),false));
    }else if($action == "logout"){
        setcookie("ctoken","", time()-3600);
        $_COOKIE['ctoken']="";
        header("Location: ".strtok($_SERVER['REQUEST_URI'], '?'));
    }
}else{
    $qrRes = "";
    $ammountRes = "";
    $nameRes = "";
    if(isset($_COOKIE['ctoken']) && ($cookie = $_COOKIE['ctoken'])!=""){
        // echo $cookie;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://qywx.cjlu.edu.cn/Pages/QRCode/ConQRCodeU.aspx");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $headers = array(
            'User-Agent: Mozilla/5.0 (Linux; Android 5.0; SM-N9100 Build/LRX21V) > AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 > Chrome/37.0.0.0 Mobile Safari/537.36 > MicroMessenger/6.0.2.56_r958800.520 NetType/WIFI Edg/113.0.0.0',
            'Cookie: '.$cookie
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        if(preg_match('/<img[^>]*id="DynamicQRimg"[^>]*src="([^"]*)"[^>]*>/', $response, $matches)){
            $qrRes = $matches[1];
        }
        if(preg_match('/剩余 ￥([0-9\.]+) <\/p>/', $response, $matches)){
            $ammountRes = $matches[1];
        }
        if(preg_match('/<h3[^>]*>\s*(\S*)\s*<\/h3>/', $response, $matches)){
            $nameRes = $matches[1];
        }
    }
    
    if($qrRes == ""){
        if($cookie != ""){
            setcookie("ctoken","", time()-3600);
            $msg = "登录过期";
        }
        require("page/login.php");
    }else{
        require("page/card.php");
    }
    
}
?>