(function($){'use strict';if($.fn.owlCarousel){$(".welcome_slides").owlCarousel({items:1,loop:true,autoplay:true,smartSpeed:1500,nav:true,navText:["<i class='pe-7s-angle-left'</i>","<i class='pe-7s-angle-right'</i>"]})
$(".client_slides").owlCarousel({items:1,loop:true,autoplay:true,smartSpeed:800,nav:true,navText:["<i class='pe-7s-angle-left'</i>","<i class='pe-7s-angle-right'</i>"]})
$(".portfolio_slides").owlCarousel({items:6,loop:true,margin:0,autoplay:true,smartSpeed:3000,responsive:{320:{items:2},576:{items:3},768:{items:4},992:{items:6}}})
$(".events-slider").owlCarousel({items:1,loop:true,autoplay:true,smartSpeed:800,nav:true,})}if($.fn.scrollUp){$.scrollUp({scrollSpeed:1500,scrollText:'<i class="fa fa-angle-up"></i>'});}if($.fn.counterUp){$('.counter').counterUp({delay:10,time:2000});}if($.fn.onePageNav){$('#nav').onePageNav({currentClass:'active',scrollSpeed:2000,easing:'easeOutQuad'});}if($.fn.onePageNav){$('#iconmenu').onePageNav({currentClass:'active',scrollSpeed:2000,easing:'easeOutQuad'});}if($.fn.magnificPopup){$('.video_btn').magnificPopup({disableOn:0,type:'iframe',mainClass:'mfp-fade',removalDelay:160,preloader:true,fixedContentPos:false});$('.gallery_img').magnificPopup({type:'image',gallery:{enabled:true},removalDelay:300,mainClass:'mfp-fade',preloader:true});}if($.fn.meanmenu){$('#nav-menu').meanmenu({onePage:true});}if($.fn.jarallax){$('.jarallax').jarallax({speed:0.2});}if($.fn.matchHeight){$('.item').matchHeight();}var $window=$(window);$window.on('scroll',function(){if($window.scrollTop()>500){$('.fixedbutton1').css('right','-50px');}else{$('.fixedbutton1').css('right','-100px');}});$window.on('scroll',function(){if($window.scrollTop()>650){$('.header_area').addClass('sticky slideInDown');}else{$('.header_area').removeClass('sticky slideInDown');}});$window.on('load',function(){$('.fixedbutton1').css('right','-100px');$('#preloader').fadeOut('slow',function(){$(this).remove();});});})(jQuery);$(document).ready(function(){$("a.fixedbutton1,a.btnstyle1").on('click',function(event){if(this.hash!==""){event.preventDefault();var hash=this.hash;$('html, body').animate({scrollTop:$(hash).offset().top},800,function(){window.location.hash=hash;});}});});
