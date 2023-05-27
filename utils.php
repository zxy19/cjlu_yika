<?php
function getpageurl($args = false) {
    $pageURL = 'http';
    if(isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on"){
        $pageURL .= "s";
    }
    $requestURL = $_SERVER['REQUEST_URI'];
    if(!$args){
        $requestURL = strtok($requestURL, '?');
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $requestURL;
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] .  $requestURL;
    }
    return $pageURL;
}
function jump_noreferer($url){
    echo "<html><head>
        <meta name='referrer' content='never'>
        <meta http-equiv='content-type' content='text/html;charset=UTF-8' />
    </head><a href='".$url."' id='b'></a>
        <script>
            document.getElementById('b').click();
        </script></html>";
}
?>