var s1 = $('.right-column-stick')[0];
var s2 = $('.left-column-container')[0];

var zIndexCounterDropdown = 1001;

$( ".dropdown-block" ).hover(
    function() {
        var dropdownElement = $( this ).find('.dropdown-element');
        if(dropdownElement.hasClass("dropdown-element-left")) {
            if (dropdownElement.width() + 30 > $(this).offset().left + $(this).width()) {
                dropdownElement.css("right", "-"+((dropdownElement.width() + 30)-($(this).offset().left + $(this).width()))+"px" );
            } else {
                dropdownElement.css("right", "0");
            }
        }
        dropdownElement.css("z-index", zIndexCounterDropdown);
        zIndexCounterDropdown++;
        dropdownElement.show();
    }, function() {
        $( this ).find('.dropdown-element').hide();
    }
);
$( ".menu-right-block" ).hover(
    function() {
        $( this ).find('.menu-right-block-element').show();
    }, function() {
        $( this ).find('.menu-right-block-element').hide();
    }
);
$( ".main-menu-block" ).on( "click", function(event) {
    event.preventDefault();
  	$(this).find('.main-menu-block-element').fadeToggle('fast','linear');
    $(this).find('.main-menu-block-element').css("z-index", zIndexCounterDropdown);
    zIndexCounterDropdown++;
  	$(this).toggleClass('white-menu');
});
$( ".main-menu-block-element" ).on( "click", function(event) {
	event.stopPropagation();
});
$( ".menu-mobile-button" ).on( "click", function(event) {
    event.preventDefault();
    $('.main-menu-block-mobile-element').fadeToggle('fast','linear');
    $('.main-menu-block-mobile-element').css('min-height', $(window).height() - 90);
    $(this).toggleClass('white-menu');
});
$( ".video-iframe-button" ).on( "click", function(event) {
    $(this).parent().parent().find('iframe').attr('src',$(this).parent().parent().find('iframe').attr('data-src'));
    $(this).hide();
    $(this).parent().parent().find('.video-iframe-image').hide();
});
$( "#showComments" ).on( "click", function(event) {
    event.preventDefault();
    $('.commentlist').fadeToggle('fast','linear',select_scroll);
    $('.add-comment-section').fadeToggle('fast','linear',select_scroll);
    //$('.commentlist').toggle();
    //$('.add-comment-section').toggle();
    if($(this).text()=="Показать")
        $(this).text('Скрыть');
    else if($(this).text()=="Скрыть")
        $(this).text('Показать');
    else if($(this).text()=="Show")
        $(this).text('Close');
    else if($(this).text()=="Close")
        $(this).text('Show');
    select_scroll();
});
$( "#showPublListFilters" ).on( "click", function(event) {
    event.preventDefault();
    $( "#showPublListFilters" ).hide();
    $('.publlist-filters-element').fadeToggle('fast','linear',select_scroll);
    if($(this).text()=="Показать фильтры")
        $(this).text('Скрыть фильтры');
    else if($(this).text()=="Скрыть фильтры")
        $(this).text('Показать фильтры');
    else if($(this).text()=="Show filters")
        $(this).text('Close filters');
    else if($(this).text()=="Close filters")
        $(this).text('Show filters');
    select_scroll();
});
$(".mobile-submenu-button").on( "click", function(event) {
    event.preventDefault();
    $(this).parent().find('.mobile-submenu').toggle();

    if($(this).html()=="<i class=\"fas fa-chevron-down\"></i>")
        $(this).html('<i class="fas fa-chevron-up"></i>');
    else
        $(this).html('<i class="fas fa-chevron-down"></i>');
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function shelfBuild() {
    $('.shelf-row').each(function( index ) {
        var heightElement = $(this).find('.shelf-book').height()-5;
        var shelfElement = $(this).find('.shelf-element');
        shelfElement.css('top',heightElement+"px");
        $(this).css('margin-bottom',shelfElement.height()+'px');
    });
}

$( window ).on( "load", function() {
    shelfBuild();
});

$( document ).ready(function() {
    shelfBuild();
    $('img[height]').removeAttr('height');
    $('.right-column-stick').css('width', $('.right-column').width()+'px');
});

$( window ).resize(function() {
    shelfBuild();
    $('.main-menu-block-mobile-element').css('min-height', $(window).height() - 90);
});



function select_scroll(e) {
    if($('.right-column-stick').height()<$('.left-column-container').height() && $(window).width()>=1200) {
        if(window.innerHeight<$('.right-column-stick').height()) {
            $('.right-column-stick').css('width', $('.right-column').width() + 'px');
            if (window.scrollY - 45 >
                (s2.offsetHeight + $('.left-column-container').offset().top) - window.innerHeight) {
                s1.style.position = 'absolute';
                s1.style.top = "unset";
                s1.style.bottom = "0";
            }
            else if (window.scrollY - 45 >
                (s1.offsetHeight + $('.right-column').offset().top) - window.innerHeight) {
                s1.style.position = 'fixed';
                if (window.innerHeight <= s1.offsetHeight) {
                    s1.style.bottom = "unset";
                    s1.style.top = -s1.offsetHeight
                        + window.innerHeight - 30 + "px";
                }
                else {
                    s1.style.top = "15px";
                    s1.style.bottom = "unset";
                }
            } else if (window.scrollY - 45 <
                (s1.offsetHeight + $('.right-column').offset().top) - window.innerHeight) {
                s1.style.position = 'absolute';
                s1.style.top = "15px";
                s1.style.bottom = "unset";
            }
        }
        else {
            $('.right-column-stick').css('width', $('.right-column').width() + 'px');
            if (window.scrollY > $('.left-column-container').offset().top-90) {
                s1.style.position = 'fixed';
                s1.style.top = "90px";
                s1.style.bottom = "unset";
            } else {
                s1.style.position = 'absolute';
                s1.style.top = "15px";
                s1.style.bottom = "unset";
            }
            if ($('.left-column-container').offset().top+$('.left-column-container').height() <
                $('.right-column-stick').offset().top+$('.right-column-stick').height()-15) {
                s1.style.position = 'absolute';
                s1.style.top = "unset";
                s1.style.bottom = "0";
            }
        }
    } else {
        $('.right-column-stick').css('width', $('.right-column').width() + 'px');
        if(s1 != undefined)
            s1.style.position = 'static';
    }
}

window.onresize = select_scroll;
document.addEventListener('scroll', select_scroll, false);

$(window).scroll(function () {
    if ($(this).scrollTop() > 1000) {
        $('.on-top-button').fadeIn();
    } else {
        $('.on-top-button').fadeOut();
    }
});

$(document).ready(function() {
    if(site_language=="ru") {
        my_calendar = $("#dncalendar-container").dnCalendar({
            minDate: "1995-01-15",
            maxDate: "2050-12-02",
            monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
            dayNames: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
            dayNamesShort: ['Вос', 'Пон', 'Вто', 'Сре', 'Чет', 'Пят', 'Суб'],
            dataTitles: {defaultDate: 'Сегодня', today: 'Сегодня'},
            notes: [
                {"date": "2018-07-25", "note": ["Пометка"]},
                {"date": "2018-07-12", "note": ["Пометка"]}
            ],
            showNotes: false,
            startWeek: 'monday',
            dayClick: function (date, view) {
                var month = (date.getMonth() + 1);
                if (month<10)
                    month = '0' + month;
                var day = date.getDate();
                if (day<10)
                    day = '0' + day;
                location.href = 'index.php?page_id=498&td1=' + date.getFullYear() + '.' + month + '.' + day + '&td2=' + date.getFullYear() + '.' + month + '.' + day;
            }
        });
    }
    else {
        my_calendar = $("#dncalendar-container").dnCalendar({
            minDate: "1995-01-15",
            maxDate: "2050-12-02",
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Sunday', 'Monday', "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dataTitles: {defaultDate: 'Today', today: 'Today'},
            notes: [],
            showNotes: false,
            startWeek: 'monday',
            dayClick: function (date, view) {
                var month = (date.getMonth() + 1);
                if (month<10)
                    month = '0' + month;
                var day = date.getDate();
                if (day<10)
                    day = '0' + day;
                location.href = '/en/index.php?page_id=498&td1=' + date.getFullYear() + '.' + month + '.' + day + '&td2=' + date.getFullYear() + '.' + month + '.' + day;
            }
        });
    }

    // init calendar
    my_calendar.build();

    var date = new Date();

    var lang = "ru";

    if(site_language=="ru") {
        lang = "ru";
    } else {
        lang = "en";
    }

    var jqxhr = $.ajax("/dreamedit/filters/dncalendar.php?month=" + (date.getMonth() + 1) + "&year=" + date.getFullYear() + "&lang=" + lang)
        .done(function (result) {
            var notesDay = [];
            result.forEach(function (entry) {
                notesDay.push({
                    "date": date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + entry.date_event,
                    "note": ["Пометка"]
                });
            });
            my_calendar.update({
                notes: notesDay
            });
        });


    // my_calendar.update({
    //     notes: [
    //         {"date": "2018-10-26", "note": ["Пометка"]},
    //         {"date": "2018-10-13", "note": ["Пометка"]}
    //     ]
    // });
    //
    // update calendar
    // my_calendar.update({
    // 	minDate: "2016-01-05",
    // 	defaultDate: "2016-05-04"

    // });
});

jQuery( document ).ready(function() {
    jQuery('#newsletter').submit(function(event) {
        event.preventDefault();
        jQuery.ajax({
            type: 'GET',
            url: jQuery('#newsletter').attr('action')+'?email='+jQuery('#newsletter_email').val(),
            success: function (data) {
                if(data==='Вы уже подписаны' || data==='Неверный email адрес' || data==='Повторную заявку можно отправить через 5 минут') {
                    jQuery('#newsletter_message').css("background-color", "red");
                    jQuery('#newsletter_message').text(data);
                    jQuery('#newsletter_message').show();
                }
                if(data==='Вам было отправлено письмо для подтверждения подписки на рассылку.') {
                    jQuery('#newsletter_message').css("background-color", "green");
                    jQuery('#newsletter_message').text(data);
                    jQuery('#newsletter_message').show();
                }
            }
        })
    });
});

$(document).ready(function(){
    $(".programm-name").delegate(".programm-name-link", "click", function(){
        $(this).parent().parent().find(".programm-text-full").stop().slideToggle();
    });
    $(".programm-name").delegate(".programm-name-link", "mouseover", function(){
        $(this).parent().parent().parent().find(".programm-line-circle").css("background-color", "#004769");
    });
    $(".programm-name").delegate(".programm-name-link", "mouseleave", function(){
        $(this).parent().parent().parent().find(".programm-line-circle").css("background-color", "white");
    });
});

$( ".programm-text-full-close-button" ).on( "click", function(event) {
    event.preventDefault();
    $(this).parent().parent().parent().parent().stop().slideToggle();
});

$( ".programm-day-button" ).on( "click", function(event) {
    event.preventDefault();
    var elementId = $(this).data('elementId');
    if(elementId === 'all') {
        $('.programm-day-element').show(200);
    } else {
        $('.programm-day-element').each(function(k, element) {
           if(element.dataset.elementId != elementId) {
               $(".programm-day-element[data-element-id=" + element.dataset.elementId + "]").hide(200);
           }
        });
        $(".programm-day-element[data-element-id='"+elementId+"']").show(200);
    }
    $('.programm-day-choose-button-current').removeClass("programm-day-choose-button-current");
    $(this).addClass("programm-day-choose-button-current");
});

function top_img_prim_toggle(){jQuery(".top-img-prim").toggleClass("transparent")}
function bottom_img_prim_toggle(){jQuery(".bottom-img-prim").toggleClass("transparent")}

jQuery( document ).ready(function() {
    jQuery('img.prim-cht-anim-img[data-src]').each(function() {
        var img = jQuery(this);
        img.attr('src', img.attr('data-src'));
        img.on('load', function() {
            img.removeAttr('data-src');
        });
    });
    if (jQuery('.top-img-prim').length) {
        setTimeout(top_img_prim_toggle, 1500);
        //setTimeout(bottom_img_prim_toggle, 1500);
    }
});

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/newsite/js/sw.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

$(document).on('change', '.custom-file-input', function () {
    var fileName = $(this).val().replace(/\\/g, '/').replace(/.*\//, '');
    $(this).parent('.custom-file').find('.custom-file-label').text(fileName);
});

// async function iframeCheckHeight(block) {
//     while (true) {
//         jQuery(block).height(jQuery('iframe').contents().find('html').height());
//         await new Promise(r => setTimeout(r, 700));
//     }
// }

// async function iframeCheckHeightTimeout(block) {
//     jQuery(block).height(jQuery(block).contents().find('html').height());
//     setTimeout(function () {
//         iframeCheckHeightTimeout(block);
//     }, 700);
// }

function checkDateInput() {
    var input = document.createElement('input');
    input.setAttribute('type','date');

    var notADateValue = 'not-a-date';
    input.setAttribute('value', notADateValue);

    return (input.value !== notADateValue);
}

jQuery( document ).ready(function() {
    if(checkDateInput()===false) {
        $('input[type="date"]').each(function( index ) {
            $(this).datepicker( );
            $(this).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $(this).datepicker('setDate', $(this).attr("value"));
        });
    }

});

$( "#checkAll" ).on( "click", function(event) {
    event.preventDefault();
    $('.form-check').find(".form-check-input").prop( "checked", true );
});

$( "#uncheckAll" ).on( "click", function(event) {
    event.preventDefault();
    $('.form-check').find(".form-check-input").prop( "checked", false );
});