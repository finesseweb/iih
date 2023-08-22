

$(window).bind('resizeEnd', function() {
 calculateHeight();
 });
 
 function calculateHeight(){
 if ($(window).width()<768){
    $('.carousel-item').css({
        'height':($(window).height())
    });
 }else{
    $('.carousel-item').css({
        'height':($(window).height()-$('.header').outerHeight(true))-($('footer').outerHeight(true)/3)
    });
 }
 }




$(document).ready(function(){
     $('[data-toggle="tooltip"]').tooltip();  
   $(".logofixed").hide();
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();            
        if (scroll >= 20) {
            $(".logofixed").show();
            $(".logox").hide();   
             $(".navbar-light .list-inline a.btnread").addClass("btnreadfixed");             
            $(".navbar-light .navbar-nav .nav-link.btnread.virt_btn").addClass("btnreadfixed");            
            $(".fixed-top").addClass("darkHeader");
        } else {
            $(".logofixed").hide();
            $(".logox").show();
            $(".fixed-top").removeClass("darkHeader");
             $(".navbar-light .list-inline a.btnread").removeClass("btnreadfixed");    
            $(".navbar-light .navbar-nav .nav-link.btnread.virt_btn").removeClass("btnreadfixed");
        }
    });               
 }); 


jQuery('.c_ul_1 > li > a').click(function(){
jQuery(this).parent("li").parent("ul").parent("div").children("div").children('div').removeClass('active');
jQuery(this).parent("li").parent("ul").parent("div").children("div").children('div').addClass('fade');

jQuery(jQuery(this).attr('data-href')).addClass('active');
jQuery(jQuery(this).attr('data-href')).removeClass('fade');
jQuery(this).parent("li").parent("ul").children('li').children("a").removeClass('active');
jQuery(this).addClass('active');

});
jQuery('.c_ul_2  > li > a').click(function(){
jQuery(this).parent("li").parent("ul").parent("div").children("div").children('div').removeClass('active');``
jQuery(this).parent("li").parent("ul").parent("div").children("div").children('div').addClass('fade');

jQuery(jQuery(this).attr('data-href')).addClass('active');
jQuery(jQuery(this).attr('data-href')).removeClass('fade');
jQuery(this).parent("li").parent("ul").children('li').children("a").removeClass('active');
jQuery(this).addClass('active');
});
jQuery('.c_ul_3  > li > a').click(function(){
jQuery(this).parent("li").parent("ul").parent("div").parent('div').children("div").children("div").children('div').removeClass('active');
jQuery(this).parent("li").parent("ul").parent("div").parent('div').children("div").children("div").children('div').addClass('fade');

jQuery(jQuery(this).attr('data-href')).addClass('active');
jQuery(jQuery(this).attr('data-href')).removeClass('fade');
jQuery(this).parent("li").parent("ul").children('li').children("a").removeClass('active');
jQuery(this).addClass('active');

});



$(".Programmestabs_mobile li a").on('click', function(event) {    
$('html, body').animate({
scrollTop: $(".Programmesection").offset().top-140
}, 1000);
});

$(".Programmestabs li a").on('click', function(event) {    
$('html, body').animate({
scrollTop: $("#con_div_ug").offset().top-100
}, 1000);
});
$("#programmestype_ug li a").on('click', function(event) {    
$('html, body').animate({
scrollTop: $("#con_div1_sub").offset().top-100
}, 1000);
});
$("#programmestype_pg li a").on('click', function(event) {    
$('html, body').animate({
scrollTop: $("#con_div_sub_pg").offset().top-100
}, 1000);
});

$("#programmestype_phd li a").on('click', function(event) {    
$('html, body').animate({
scrollTop: $("#con_div_sub_phd").offset().top-100
}, 1000);
});


