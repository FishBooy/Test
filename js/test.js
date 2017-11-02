
var timeId;
$(function(){
	//hove效果
	$('#home-page .article-wrap')
	.mouseover(function(){
		$(this).addClass('chosen-arc').prev().addClass('chosen-prev');
	})
	.mouseout(function(){
		$(this).removeClass('chosen-arc').prev().removeClass('chosen-prev');
	});

	// $(window).resize(function(){
	// 	timeId && clearTimeout(timeId);
	// 	timeId=setTimeout(function(){
	// 		alert('width:'+$(window).width()+'--height:'+$(window).height()+'--h2:'+$('h2').css('fontSize')+'--p!:'+$('p').css('fontSize'));
	// 	},100);
		
	// });
	// $(window).trigger('resize')
})