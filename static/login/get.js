
(function(){
var option = {"zIndex": "9999999999", "product": "popup", "theme_version": "2.9.10", "fullbg": "pictures/gt/eaa132740/eaa132740.jpg", "staticserver": "http://static.geetest.com/", "challenge": "adf59681036a5dab694b9d908111142cb0", "ypos": 0, "popupbtnid": "submit_button", "height": 116, "apiserver": "http://api.geetest.com/", "sliceurl": "pictures/gt/eaa132740/slice/d0e4cdb2.png", "theme": "golden", "version": "2.9.10", "link": "", "imgserver": "http://static.geetest.com/", "https": false, "logo": true, "geetestid": "791683427cf22d044ab8e9d14cd22740", "id": "aadf59681036a5dab694b9d908111142c", "imgurl": "pictures/gt/eaa132740/bg/d0e4cdb2.jpg"};
if (!window.GeeTestOptions) {
window.GeeTestOptions = [option];
}
else {
GeeTestOptions = GeeTestOptions.concat(option);
};
var node, scripts = document.body.getElementsByTagName('script'),
src = "http://api.geetest.com/get.php?gt=791683427cf22d044ab8e9d14cd22740&product=popup&popupbtnid=submit_button";
for (var i = 0; i < scripts.length; i++) {
if (scripts[i].src == src) {
node = scripts[i];
var gs = document.createElement("script");
gs.type = "text/javascript";
gs.id = option.id + "_script";
gs.charset = "utf-8";
gs.async = true;
gs.src = option.staticserver + "static/js/geetest." + option.version + ".js";
node.parentNode.insertBefore(gs, node.nextSibling);
node.parentNode.removeChild(node);
var ie6 = /msie 6/i.test(navigator.userAgent),
ieimg = ie6 ? "gif" : "png";
var retina = window.devicePixelRatio && window.devicePixelRatio > 1,
rImg = option.theme + "/sprite" + (retina ? "2x" : "") + "." + option.theme_version + '.' + ieimg;
document.createElement("img").src = option.staticserver + "static/" + rImg;
if (!document.getElementById("gt_css")) {
var css = document.createElement("link");
css.setAttribute("rel", "stylesheet");
css.setAttribute("type", "text/css");
css.setAttribute("href", option.staticserver + "static/" + option.theme + "/style" + (option.https ? "_https" : "") + "." + option.theme_version + ".css");
css.setAttribute("id", "gt_css");
document.getElementsByTagName("head")[0].appendChild(css)
}
break;
}
}
})()