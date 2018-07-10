/*function isiPhone(){
    return (
    (navigator.platform.indexOf("iPhone") != -1) ||
    (navigator.platform.indexOf("iPod") != -1)
    );
}
if(isiPhone()){
    $(".popover-homescreen").show(); //Alert for iPhone/iPod Only
}*/

/*Standalone*/
(function() {
    var metas = document.getElementsByTagName('meta');

    for (var n in metas){
        var meta = metas[n];
        if (meta.name === 'viewport'){
            meta.remove();
        }
    }

    var meta = document.createElement('meta');
    meta.setAttribute('name', 'viewport');

    if (navigator.standalone) {
        meta.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui');
        $('.popover-homescreen').hide();

        var height = $(window).height();
        var width = $(window).width();

        if(height>width) {
            $('body').css('border-top','20px solid #c23c2f'); // Portrait
        } else {
            $('body').css('border-top','0'); // Landscape
        }

        $(window).on("orientationchange",function(){
            if(window.orientation == 0) {
                $('body').css('border-top','20px solid #c23c2f'); // Portrait
            } else {
                $('body').css('border','0'); // Landscape
            }
        });
    }
    else{
        meta.setAttribute('content', 'initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, minimal-ui');
    }

    var head = document.getElementsByTagName('head')[0];
    head.appendChild(meta);
})();


/*Standalone Links*/
(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")

$(window).load(function() {
    //$("#preloader").delay(400).fadeOut("slow");

    /* Mobile Touchstart :active */
    if(/iP(hone|ad)/.test(window.navigator.userAgent)) {
        var elements = document.querySelectorAll('button');
        var emptyFunction = function() {};
        for(var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('touchstart', emptyFunction, false);
        }
    }
});

/*Slide Menu Functions*/
function bodyScrollOff() {
    $("body").addClass('scrollOff');
}
function bodyScrollOn() {
    $("body").removeClass('scrollOff');
}

function slideLoginOpen() {
    bodyScrollOff();
    $("#slide-login").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
}
function slideLoginClose() {
    bodyScrollOn();
    $("#slide-login").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
}

function slideSignUpOpen() {
    bodyScrollOff();
    $("#slide-login").removeClass('slide-menu-open-left');
    $("#slide-signup").addClass('slide-menu-open-right');
    $('.cover').fadeIn();
}
function slideSignUpClose() {
    bodyScrollOn();
    $("#slide-signup").removeClass('slide-menu-open-right');
    $('.cover').fadeOut();
}

function slideWalletOpen() {
    bodyScrollOff();
    $("#slide-wallet").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
}
function slideWalletClose() {
    bodyScrollOn();
    $("#slide-wallet").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
}

function slideDepositOpen() {
    $("#slide-deposit").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideDepositClose() {
    $("#slide-deposit").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideWithdrawOpen() {
    $("#slide-withdraw").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideWithdrawClose() {
    $("#slide-withdraw").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideTransferOpen() {
    $("#slide-transfer").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideTransferClose() {
    $("#slide-transfer").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideBonusOpen() {
    $("#slide-bonus").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideBonusClose() {
    $("#slide-bonus").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideFriendsOpen() {
    $("#slide-friends").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideFriendsClose() {
    $("#slide-friends").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideCouponOpen() {
    $("#slide-coupon").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideCouponClose() {
    $("#slide-coupon").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideCashHistoryOpen() {
    $("#slide-cashHistory").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideCashHistoryClose() {
    $("#slide-cashHistory").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

function slideAccountOpen() {
    $("#slide-account").addClass('slide-menu-open-left');
    $('.cover').fadeIn();
    $("#slide-wallet").fadeOut(300);
}
function slideAccountClose() {
    $("#slide-account").removeClass('slide-menu-open-left');
    $('.cover').fadeOut();
    $("#slide-wallet").fadeIn(300);
}

//Input Number
function tog(v){return v?'addClass':'removeClass';}
$(document).on('input', '.clearable', function(){
    $(this)[tog(this.value)]('x');
}).on('mousemove', '.x', function( e ){
    $(this)[tog(this.offsetWidth-30 < e.clientX-this.getBoundingClientRect().left)]('onX');
}).on('touchstart click', '.onX', function( ev ){
    ev.preventDefault();
    $(this).removeClass('x onX').val('').change();
});

/*$(document).on('focus', 'input, textarea', function() {
    $(".navbar-fixed-bottom").hide();
});
$(document).on('blur', 'input, textarea', function() {
    $(".navbar-fixed-bottom").show();
});*/


$(document).ready(function(){
    $('.pjackpot2').jOdometer({
        increment: 0.01,
        counterStart:'13615842.24',
        counterEnd: false,
        numbersImage: 'common/images/jodometer-numbers-gold-small.png',
        spaceNumbers: 0,
        formatNumber: true,
        widthNumber: 12,
        heightNumber: 26
    });

    addToHomescreen();

    $("input[data-type='number']").keyup(function(event){
        if(event.which >= 37 && event.which <= 40){
            event.preventDefault();
        }
        var $this = $(this);
        var num = $this.val().replace(/,/gi, "");
        var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
        //console.log(num2);
        $this.val(num2);
    });

    $(".btn-popup-deposit").bind("click", function () {
        $('#popup-deposit .popup-close').click();
        $("#slide-account").addClass('slide-menu-open');
        $("body").addClass('scrollOff');
        $('.cover').fadeIn();
        slideDepositOpen();
    });

    /*$(".backMenuAccount").bind("click", function () {
        slideDepositClose();
        slideWithdrawClose();
        slideTransferClose();
        slideBonusClose();
        slideSettingsClose();
        slideCouponClose();
    });*/

    /*Popup*/
    /*$('.btnSports').click(function(){popupTransfer()});
    $('.btnCasino').click(function(){popupDeposit()});
    function popupTransfer(){
        $('#popup-transfer').bPopup({easing: 'easeOutBack', speed: 400, positionStyle: 'fixed'});
    }
    function popupDeposit(){
        $('#popup-deposit').bPopup({easing: 'easeOutBack', speed: 400, positionStyle: 'fixed'});
    }*/
});