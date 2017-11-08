
var timeId;
$(function(){

	//菜单开关
	$('.top-menus')
	.mouseover(function(e){
		$('#top-menus-trigger').addClass('hover');
		$('#top-menus-list').stop().fadeIn();
	})
	.mouseout(function(){
		$('#top-menus-trigger').removeClass('hover');
		$('#top-menus-list').stop().fadeOut();
	})

	//hove效果
	$('.site-index-content .post-block')
	.mouseover(function(){
		$(this).addClass('chosen-arc').prev().addClass('chosen-prev');
	})
	.mouseout(function(){
		$(this).removeClass('chosen-arc').prev().removeClass('chosen-prev');
	})

	// $(window).resize(function(){
	// 	timeId && clearTimeout(timeId);
	// 	timeId=setTimeout(function(){
	// 		alert('width:'+$(window).width()+'--height:'+$(window).height()+'--h2:'+$('h2').css('fontSize')+'--p!:'+$('p').css('fontSize'));
	// 	},100);
		
	// });
	// $(window).trigger('resize')
})