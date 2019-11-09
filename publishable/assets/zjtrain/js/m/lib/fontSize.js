function fontSize(){
	var html = document.documentElement;
	var windowWidth = html.clientWidth*4;//window.devicePixelRatio  （物理像素-实际屏幕的尺码、逻辑像素-视觉看到的尺寸，如：iPhone 物理像素：750px 、逻辑像素：375px）
	html.style.fontSize = windowWidth / 75 + 'px';
}	
document.addEventListener("DOMContentLoaded",function(){
	fontSize();
},false)
window.onresize=function(){
	fontSize();
}
