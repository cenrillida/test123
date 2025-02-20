left_scroll_last = -1;

function collumns_scroll() {
    if($(window).width()>=1200) {
        var heightMeasure = 800;
        if($(window).height()<heightMeasure || $('.right-column-container')[0].scrollHeight<heightMeasure || $('.left-column-container')[0].scrollHeight<heightMeasure)
            heightMeasure = 100;
        if($(window).scrollTop()>$('.left-column-container')[0].scrollHeight && $(window).scrollTop()>heightMeasure) {
            if($('.right-column').hasClass('col-xl-4')) {
                left_scroll_last = $('.left-column-container')[0].scrollHeight-($('.left-column')[0].scrollHeight-$('.left-column-container')[0].scrollHeight);
                $('.right-column').removeClass('col-xl-4');
            }
            if(!$('.right-column').hasClass('col-xl-12')) {
                $('.right-column').addClass('col-xl-12');
            }
            $('.left-column').hide();
            $('.right-changable-12-4').removeClass('col-xl-12');
            $('.right-changable-12-4').addClass('col-xl-4');
            $('.right-changable-4-2').removeClass('col-xl-4');
            $('.right-changable-4-2').addClass('col-xl-2');
        } else {
            left_scroll_last = -1;
            if(!$('.right-column').hasClass('col-xl-4')) {
                $('.right-column').addClass('col-xl-4');
            }
            if($('.right-column').hasClass('col-xl-12')) {
                $('.right-column').removeClass('col-xl-12');
            }
            $('.left-column').show();
            $('.right-changable-12-4').removeClass('col-xl-4');
            $('.right-changable-12-4').addClass('col-xl-12');
            $('.right-changable-4-2').removeClass('col-xl-2');
            $('.right-changable-4-2').addClass('col-xl-4');
        }

        if($(window).scrollTop()>$('.right-column-container')[0].scrollHeight && $(window).scrollTop()>heightMeasure) {
            if($('.left-column').hasClass('col-xl-8')) {
                $('.left-column').removeClass('col-xl-8');
            }
            if(!$('.left-column').hasClass('col-xl-12')) {
                $('.left-column').addClass('col-xl-12');
            }
            $('.right-column').hide();
            $('.left-changable-12-4').removeClass('col-xl-12');
            $('.left-changable-12-4').addClass('col-xl-4');
            $('.left-changable-4-2').removeClass('col-xl-4');
            $('.left-changable-4-2').addClass('col-xl-2');
            $('.left-changable-12-6').removeClass('col-xl-12');
            $('.left-changable-12-6').addClass('col-xl-6');
        } else {
            if(!$('.left-column').hasClass('col-xl-8')) {
                $('.left-column').addClass('col-xl-8');
            }
            if($('.left-column').hasClass('col-xl-12')) {
                $('.left-column').removeClass('col-xl-12');
            }
            $('.right-column').show();
            $('.left-changable-12-4').removeClass('col-xl-4');
            $('.left-changable-12-4').addClass('col-xl-12');
            $('.left-changable-4-2').removeClass('col-xl-2');
            $('.left-changable-4-2').addClass('col-xl-4');
            $('.left-changable-12-6').removeClass('col-xl-6');
            $('.left-changable-12-6').addClass('col-xl-12');
        }
    } else {
        $('.left-column').show();
        $('.right-column').show();
        if(!$('.left-column').hasClass('col-xl-8')) {
            $('.left-column').addClass('col-xl-8');
        }
        if(!$('.right-column').hasClass('col-xl-4')) {
            $('.right-column').addClass('col-xl-4');
        }
        if($('.left-column').hasClass('col-xl-12')) {
            $('.left-column').removeClass('col-xl-12');
        }
        if($('.right-column').hasClass('col-xl-12')) {
            $('.right-column').removeClass('col-xl-12');
        }
        $('.right-changable-12-4').removeClass('col-xl-4');
        $('.right-changable-12-4').addClass('col-xl-12');
        $('.right-changable-4-2').removeClass('col-xl-2');
        $('.right-changable-4-2').addClass('col-xl-4');
        $('.left-changable-12-4').removeClass('col-xl-4');
        $('.left-changable-12-4').addClass('col-xl-12');
        $('.left-changable-4-2').removeClass('col-xl-2');
        $('.left-changable-4-2').addClass('col-xl-4');
        $('.left-changable-12-6').removeClass('col-xl-6');
        $('.left-changable-12-6').addClass('col-xl-12');
    }
}

window.onresize = collumns_scroll;
document.addEventListener('scroll', collumns_scroll, false);

$(window).scroll(function () {

});