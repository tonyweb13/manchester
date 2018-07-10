/*$(window).on('resize',function(){
    if($(window).width()<=1600){$(document).scrollLeft(0);}
    if($(window).width()<=1536){$(document).scrollLeft(40);}
    if($(window).width()<=1440){$(document).scrollLeft(110);}
    if($(window).width()<=1360){$(document).scrollLeft(130);}
    if($(window).width()<=1280){$(document).scrollLeft(170);}
    if($(window).width()<=1152){$(document).scrollLeft(235);}
    if($(window).width()<=1024){$(document).scrollLeft(300);}
    if($(window).width()<=800){$(document).scrollLeft(400);}
});

$(function(){
    if($(window).width()<=1600){$(document).scrollLeft(0);}
    if($(window).width()<=1536){$(document).scrollLeft(40);}
    if($(window).width()<=1440){$(document).scrollLeft(110);}
    if($(window).width()<=1360){$(document).scrollLeft(130);}
    if($(window).width()<=1280){$(document).scrollLeft(170);}
    if($(window).width()<=1152){$(document).scrollLeft(235);}
    if($(window).width()<=1024){$(document).scrollLeft(300);}
    if($(window).width()<=800){$(document).scrollLeft(400);}
});*/

$(document).ready(function(){

    $("#masthead-image").show();
    $("#masthead-image1").hide();
    $("#masthead-image2").hide();

    if($('.navSports').hasClass('active')){
        sportsPageLayout();
        sportsMasthead();
    }else if($('.navCasino').hasClass('active')){
        casinoMasthead();
    }else if($('.navSlots').hasClass('active')){
        slotsMasthead();
    }else{
        $('#masthead-container').show();
    }

    $('.subMenu li, .content-overlay').click(function () {
        closeMobilePane();
    });

    $('#live-promo-slider').owlCarousel({
        autoPlay: true,
        pagination: true,
        navigation: false,
        slideSpeed: 600,
        paginationSpeed: 400,
        singleItem: true
    });
    $('#slot-promo-slider').owlCarousel({
        autoPlay: true,
        pagination: true,
        navigation: false,
        slideSpeed: 600,
        paginationSpeed: 400,
        singleItem: true
    });

    $('#promo-slider2').owlCarousel({
        autoPlay: true,
        pagination: true,
        navigation: false,
        slideSpeed: 600,
        paginationSpeed: 400,
        singleItem: true
    });
});

function closeMobilePane() {
    $('#mobile-container').slideUp('fast');
    $('.content-overlay').removeClass('show');
    $('.navMobile').removeClass('active');
}

function sportsPageLayout() {
    $('#masthead-container').hide();
    $('#main-container').css({ marginTop: "10px" });
    $('#main-container .left-panel').css({ width: "1022px" });
    $('#masthead-image').css({ height: "340px" });
    $('#masthead-image1').css({ height: "340px" });
    $('#masthead-image2').css({ height: "340px" });
}

function mainMasthead() {
    $('#masthead-container').show();
    $("#masthead-image").show();
    $("#masthead-image1").hide();
    $("#masthead-image2").hide();
}

function sportsMasthead() {
    $('#masthead-container').hide();
    $("#masthead-image").hide();
    $("#masthead-image1").hide();
    $("#masthead-image2").hide();
}

function slotsMasthead() {
    $('#masthead-container').show();
    $("#masthead-image").hide();
    $("#masthead-image1").hide();
    $("#masthead-image2").show();
}

function casinoMasthead() {
    $('#masthead-container').show();
    $("#masthead-image").hide();
    $("#masthead-image1").show();
    $("#masthead-image2").hide();
}