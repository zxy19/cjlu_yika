self.Version = "0.0.3";
var CACHE_NAME ="card_v1.1.0";
function canBeCached(url) {
	if (/.*\.(png|jpg|gif|bmp|webp|js|html|css|json|ico|eot|ttf|svg|woff|woff2)/i.test(url)) return true;
	else if(url.charAt(url.length-1)=="/")return false;
	else return false;
}
self.addEventListener("activate", function (event) {
	event.waitUntil(
		caches.keys().then(function (cacheNames) {
			return Promise.all([
				cacheNames.map(function (cacheName) {
					if (CACHE_NAME != cacheName) {
						console.log("out date cache cleaned:" + cacheName);
						return caches.delete(cacheName);
					}
				})
			]);
		})
	);
	self.skipWaiting();
});
self.addEventListener("install", function (event) {
	self.skipWaiting();
});
self.addEventListener("fetch", function (event) {
	var url = event.request.url;
	if (url.indexOf("#") != -1) url = url.substr(0, url.indexOf("#"));
	url = url.substr(url.indexOf("/", 8) + 1);
	if (!url) url = "index.php";
	console.log(url);
	if ((/https?:\/\/(?!.*?cjlu_card.xypp.cc).*/gi.test(url)) && (/https?:\/\/(?!127\.0\.0\.1).*/gi.test(url))) {
		return fetch(event.request);
	} else {
		event.respondWith(
			caches.match(event.request).then(function (c) {
				if (c) return c;
				else
					return fetch(event.request, { credentials: "include" })
						.then(function (response) {
							if (canBeCached(url)) {
								if (!response || response.status !== 200 || response.type !== "basic") {
									return response;
								}
								var responseToCache = response.clone();
								caches.open(CACHE_NAME).then(function (cache) {
									cache.put(event.request, responseToCache);
								});
								return response;
							}
							console.log(response);
							return response;
						}) //Offline case:return normal files with chachs
						.catch(function () {
							return caches.match(url).then(function (response) {
								console.log("尝试获取缓存");
								// Cache hit - return response
								if (response) {
									console.log("已获取到缓存的文件");
									return response;
								} else { 
									return noInternetRet(url)||Promise.resolve(new Response("无法访问服务器，请检查网络连接",{"status" : 500 , "statusText" : "No Internet Connected!"}));
								}
							});
						});
			})
		);
	}
});
var nlv;
self.addEventListener("message", function (event) {var senderId;
	senderId = event.source ? event.source.id : "unknow";
	var dat = JSON.parse(event.data);
	if (dat.type == "clearCache") {
		nlv=dat.lv;
		event.waitUntil(
			caches.open(CACHE_NAME).then(function (cache) {
				for (var i = 0; i < dat.url.length; i++){
				cache.delete(dat.url[i]);
				console.log("delete cache of : " + dat.url[i]);
				clients.get(senderId).then(function (client) {
					client.postMessage(JSON.stringify({
						type:"update","lv":nlv
					}));
				})
			}
			})
		);
	}else if (dat.type == "clearCacheImg") {
		event.waitUntil(
			caches.open(CACHE_NAME).then(function (cache) {
				cache.delete(dat.url);
				console.log("delete cache of : " + dat.url);
				clients.get(senderId).then(function (client) {
					client.postMessage(JSON.stringify({
						type:"clearImgC"
					}));
				})
			})
		);
		
	} else if (dat.type == "dropCache") {
		caches.keys().then(function (cacheNames) {
			cacheNames.map(function (cacheName) {
				console.log("delete cache:" + cacheName);
				caches.delete(cacheName);
			});
		});
	} else if (dat.type == "getVer") {
		event.waitUntil(
			clients.get(senderId).then(function (client) {
				client.postMessage(JSON.stringify({
					type:"setVer","ver":Version
				}));
			})
		);
	}else if(dat.type=="cache"){
// 		caches.open(CACHE_NAME).then(function (cache) {
// 			cache.addAll(["index.html","/","main.js","main.css"])
// 		});
	}
});
function noInternetRet(url){
    if(url == "/" || /index\..*/.test(url)){
        let myHeaders = new Headers();

        myHeaders.append('Content-Type', 'text/html');
        var resp = new Response("<meta charset='UTF-8'>无法访问服务器，请检查网络连接<a onclick='location.reload();' href='#'>点击重试</a>",{"status" : 500 , "statusText" : "No Internet Connected!",headers:myHeaders});
        return resp;
    }
	switch(url){
		default:
			return false;
	}
}