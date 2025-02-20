(function($) {
    // This is the connector function.
    // It connects one item from the navigation carousel to one item from the
    // stage carousel.
    // The default behaviour is, to connect items with the same index from both
    // carousels. This might _not_ work with circular carousels!
    var connector = function(itemNavigation, carouselStage) {
        return carouselStage.jcarousel('items').eq(itemNavigation.index());
    };
    var connector2 = function(itemNavigation, carouselStage) {
        return carouselStage1.jcarousel('items').eq(itemNavigation.index());
    };
    var connector3 = function(itemNavigation, carouselStage) {
        return carouselStage2.jcarousel('items').eq(itemNavigation.index());
    };
    var connector4 = function(itemNavigation, carouselStage) {
        return carouselStage21.jcarousel('items').eq(itemNavigation.index());
    };
    $(function() {
        // Setup the carousels. Adjust the options for both carousels here.
        var carouselStage      = $('.carousel-stage').jcarousel();
        var carouselStage1      = $('.carousel-stage1').jcarousel();
        var carouselStagedynkinphoto      = $('.carousel-stage-dynkin-photo').jcarousel();
        var carouselStagedynkinphoto1      = $('.carousel-stage-dynkin-photo1').jcarousel();
        var carouselStage2      = $('.carousel-stage2').jcarousel();
        var carouselStage21      = $('.carousel-stage21').jcarousel();
        var carouselStagedynkinvideo      = $('.carousel-stage-dynkin-video').jcarousel();
        var carouselStagedynkinvideo1      = $('.carousel-stage-dynkin-video1').jcarousel();
        var carouselStage_ph_h      = $('.carousel-stage-ph-h').jcarousel();
        var carouselStage_ph_h1      = $('.carousel-stage-ph-h1').jcarousel();
        var carouselStage_ph_v      = $('.carousel-stage-ph-v').jcarousel();
        var carouselStage_ph_v1      = $('.carousel-stage-ph-v1').jcarousel();
        var carouselStage_ph_outofprint      = $('.carousel-stage-ph-outofprint').jcarousel();
        var carouselStage_ph_outofprintfp      = $('.carousel-stage-ph-outofprint-fp').jcarousel();
        var carouselStage_ph_dynkin_sidebar      = $('.carousel-stage-ph-dynkin-sidebar').jcarousel();
        var carouselStage_ph_dynkin_sidebar1      = $('.carousel-stage-ph-dynkin-sidebar1').jcarousel();
        var carouselStage_ph_dynkin_sidebar2      = $('.carousel-stage-ph-video-sidebar').jcarousel();
        var carouselStage_ph_dynkin_sidebar3      = $('.carousel-stage-ph-video-sidebar1').jcarousel();
        var carouselNavigation = $('.carousel-navigation').jcarousel();

        // We loop through the items of the navigation carousel and set it up
        // as a control for an item from the stage carousel.
        carouselNavigation.jcarousel('items').each(function() {
            var item = $(this);

            // This is where we actually connect to items.
            var target = connector(item, carouselStage);
            var target1 = connector2(item, carouselStage1);
            var target2=connector3(item, carouselStage3);

            item
                .on('jcarouselcontrol:active', function() {
                    carouselNavigation.jcarousel('scrollIntoView', this);
                    item.addClass('active');
                })
                .on('jcarouselcontrol:inactive', function() {
                    item.removeClass('active');
                })
                .jcarouselControl({
                    target: target,
                    target1: target1,
                    target2: target2,
                    carousel: carouselStage,
                    carousel1: carouselStage1,
                    carousel2: carouselStage2
                });
        });
        // Setup controls for the stage carousel
        $('.prev-stage')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1',
                target1: '-=1'
            });

        $('.next-stage')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1',
                target1: '+=1'
            });
        $('.prev-stage-dynkin-photo')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1',
                target1: '-=1'
            });

        $('.next-stage-dynkin-photo')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1',
                target1: '+=1'
            });
        $('.prev-stage2')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage2')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
        $('.prev-stage-dynkin-video')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-dynkin-video')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.prev-stage-ph-h')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-h')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
        $('.prev-stage-ph-v')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-v')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
        $('.prev-stage-ph-outofprint')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-outofprint')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
                    $('.prev-stage-ph-outofprint-fp')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-outofprint-fp')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        $('.prev-stage-ph-dynkin-sidebar')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-dynkin-sidebar')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
        $('.prev-stage-ph-video-sidebar')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-stage-ph-video-sidebar')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });


        // Setup controls for the navigation carousel
        $('.prev-navigation')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.next-navigation')
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
        $('.carousel-stage').jcarouselAutoscroll({
            interval: 5000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage1').jcarouselAutoscroll({
            interval: 5000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage1').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-dynkin-photo').jcarouselAutoscroll({
            interval: 5000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-dynkin-photo1').jcarouselAutoscroll({
            interval: 5000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-dynkin-photo').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-dynkin-photo1').jcarousel({
        wrap: 'circular'
        });



        $('.carousel-stage2').jcarouselAutoscroll({
            interval: 3000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage21').jcarouselAutoscroll({
            interval: 3000,
            target: '+=1',
            autostart: true
        });


        $('.carousel-stage-ph-h').jcarouselAutoscroll({
            interval: 2000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-h1').jcarouselAutoscroll({
            interval: 2000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-v').jcarouselAutoscroll({
            interval: 2000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-v1').jcarouselAutoscroll({
            interval: 2000,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-h').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-ph-h1').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-ph-v').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-ph-v1').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-ph-outofprint').jcarouselAutoscroll({
            interval: 4555,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-outofprint').jcarousel({
        wrap: 'circular'
        });
        $('.carousel-stage-ph-outofprint-fp').jcarouselAutoscroll({
            interval: 4555,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-outofprint-fp').jcarousel({
        wrap: 'circular'
        });

        $('.carousel-stage-ph-dynkin-sidebar').jcarouselAutoscroll({
            interval: 2225,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-dynkin-sidebar1').jcarouselAutoscroll({
            interval: 2225,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-video-sidebar').jcarouselAutoscroll({
            interval: 3225,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-video-sidebar1').jcarouselAutoscroll({
            interval: 3225,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-dynkin-video').jcarouselAutoscroll({
            interval: 3225,
            target: '+=1',
            autostart: true
        });
        $('.carousel-stage-ph-video-dynkin-video1').jcarouselAutoscroll({
            interval: 3225,
            target: '+=1',
            autostart: true
        });
    });
})(jQuery);


