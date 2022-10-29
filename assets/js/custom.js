$(document).ready(function () {

	$(".accordion > li > span").click(function() {
		$(this).toggleClass("active").next('div').slideToggle(250)
		.closest('li').siblings().find('span').removeClass('active').next('div').slideUp(250);
	});

	 var swiper = new Swiper('.realeaste-slider-section .swiper-container', {
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
    });

	var swiper = new Swiper('.details-slider-wrapper .swiper-container', {
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
    });

});


