$(document).ready(function(){
  $(".owl-carousel").owlCarousel({
  	 //Set AutoPlay to 3 seconds
        items: 1,
        autoplay : 3000,
        nav : true,
        loop : true,
        navText : [ "<img src=\"libs/owlcarousel/img/prev.png\">", "<img src=\"libs/owlcarousel/img/next.png\">"],
  		autoplayHoverPause : false,
  		animateIn : 'fadeIn',
    	smartSpeed:800
  });
});