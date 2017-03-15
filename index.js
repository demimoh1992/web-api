$(document).ready(function(){
	//using slicks carousel jquery plugin to show a gallery slider
	$('.carousel').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		centerMode: true,
		centerPadding: '60px',
		autoplay: true,
		prevArrow: $('.prevArrow'),
		nextArrow: $('.nextArrow')
 	});
});
