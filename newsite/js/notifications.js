function getNotification(cnt, element, right = false) {
    var subMenuElement = $('#add_menu__element_'+element);
    subMenuElement.addClass('position-relative');
    subMenuElement.addClass('notification-submenu');

    if(subMenuElement.length > 0) {
        var menuElement = $('.add-menu-open-button');
        menuElement.addClass('position-relative');
        menuElement.addClass('notification-menu-button');
    }

    var mobileSubMenuElement = $('.mobile-submenu-element-'+element);
    mobileSubMenuElement.addClass('position-relative');
    mobileSubMenuElement.addClass('notification-submenu');
    if(right) {
        mobileSubMenuElement.addClass('notification-right-before');
    }

    if(mobileSubMenuElement.length > 0) {
        var mobileMenuElement = $('.menu-mobile-button');
        mobileMenuElement.addClass('position-relative');
        mobileMenuElement.addClass('notification-menu-button');
    }

    var menuElementLink = $('#menu__element_'+element);
    menuElementLink.addClass('position-relative');
    menuElementLink.addClass('notification-menu-element');

    $('<style>#add_menu__element_'+element+':before{content:"'+cnt+'"}</style>').appendTo('head');

    $('<style>#menu__element_'+element+':before{content:"'+cnt+'"}</style>').appendTo('head');
    $('<style>.mobile-submenu-element-'+element+':before{content:"'+cnt+'"}</style>').appendTo('head');
}

function addMenuNotification(cnt) {
    $('<style>.notification-menu-button:before{content:"'+cnt+'"}</style>').appendTo('head');
}

jQuery( document ).ready(function() {
    jQuery.ajax({
        type: 'GET',
        url: '/rest?method=getNotifications',
        success: function (data) {
            if(data.items!==undefined && data.items.length>0) {
                var countUnShowed = [];
                countUnShowed[59] = 0;
                countUnShowed[62] = 0;
                allUnShowed = 0;
                data.items.forEach(function (el) {
                    var notificationShowed = getCookie('notification-'+el.id+'-showed');
                    if(notificationShowed !== "1") {
                        countUnShowed[el.ilineId]++;
                        allUnShowed++;
                    }
                });

                if(countUnShowed[59]>0) {
                    getNotification(countUnShowed[59], 1333);
                }
                if(countUnShowed[62]>0) {
                    //getNotification(countUnShowed[62], 1580, true);
                    //getNotification(countUnShowed[62], 2009);
                }
            }
        }
    })
});