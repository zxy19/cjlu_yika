var deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
  deferredPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome !== 'accepted') {
      alert("您拒绝了添加到主屏幕的请求。我们在之后将不会再提示您添加，如有需要，请点击浏览器中的“添加到主屏幕”按钮（移动）或“安装”按钮（PC）");
      localStorage['pwaTipped']="set";
    }
  });
  if(window.pwaTip)pwaTip.auto();
});
function swMsg(dat){
    try {
      if ('serviceWorker' in navigator)
      if(window.swReg)
      navigator.serviceWorker.controller.postMessage(JSON.stringify(dat));
    } catch (e) {}
}

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('webappworker.js').then(function(registration) {
      window.swReg=registration;
      swMsg({"type":"getVer"});
    }, function(err) {
      console.log("service Worker未成功注册");
    });
    navigator.serviceWorker.addEventListener('controllerchange', () => {
      // This fires when the service worker controlling this page
      // changes, eg a new worker has skipped waiting and become
      // the new active worker.
      if(document.body.classList.contains("unload"))reloadFor("服务工作者需要更新，已经重新加载页面");
      else
        if(confirm("服务工作者需要更新，现在请求刷新页面，是否同意？如果您有未完成的作业，可以取消并稍后手动刷新","刷新请求")){
            localStorage["htCHC"] = 0;
            reloadFor("服务工作者需要更新，已经重新加载页面");
        }
          
    });
    navigator.serviceWorker.addEventListener('message', function(e) {
      var dat=JSON.parse(e.data);
      if(dat.type=="setVer"){
        window.swVer=dat.ver;
        if(localStorage["htCHC"] != 1){
          localStorage["htCHC"] = 1;
          swMsg({"type":"cache"});
        }
      }else if(dat.type=="update"){
        localStorage["ver"] = dat.lv;
        localStorage["htCHC"] = 0;
        reloadFor("有必要资源需要更新，已经重新加载页面");
      }else if(dat.type=="clearImgC"){
        //setUdat();
      }
    })
}



/**
 * 重载（刷新后显示原因）
 * @param {string} reason 重载
 */
 function reloadFor(reason) {
	localStorage["rlrs"] = reason;
	window.onhashchange = function () {};
	location.reload();
}
//显示重载原因
if (localStorage["rlrs"]) {
	localStorage["rlrs"] = "";
}
function setUpdateList(d) {
  if (!window.swReg) return;
  swMsg({ type: "clearCache", url: d.ul,lv:d.lv});
}