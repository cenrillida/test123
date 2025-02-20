/**
 * jquery.snow - jQuery Snow Effect Plugin
 *
 * Available under MIT licence
 *
 * @version 1 (21. Jan 2012)
 * @author Ivan Lazarevic
 * @requires jQuery
 * @see http://workshop.rs
 *
 * @params minSize - min size of snowflake, 10 by default
 * @params maxSize - max size of snowflake, 20 by default
 * @params newOn - frequency in ms of appearing of new snowflake, 500 by default
 * @params flakeColor - color of snowflake, #FFFFFF by default
 * @example $.fn.snow({ maxSize: 200, newOn: 1000 });
 */
(function($){
	
	$.fn.snow = function(options){
	
			var $flake 			= $('<div id="flake" />').css({'position': 'absolute', 'top': '-50px', 'background-size': 'cover'}),
				documentHeight 	= $(document).height(),
				documentWidth	= $(document).width(),
				defaults		= {
									minSize		: 10,
									maxSize		: 20,
									newOn		: 700,
									flakeColor	: "#FFFFFF"
								},
				options			= $.extend({}, defaults, options);
				
			
			var interval		= setInterval( function(){
				var startPositionLeft 	= Math.random() * documentWidth - 100,
					startOpacity		= 0.1 + (Math.floor(Math.random() * (5 - 1)) + 1)/10,
					sizeFlake			= options.minSize + Math.random() * options.maxSize,
					endPositionTop		= documentHeight - 40,
					endPositionLeft		= startPositionLeft - 100 + Math.random() * 200,
					durationFall		= (documentHeight * 10 + Math.random() * 5000)/((Math.floor(Math.random() * (18 - 7)) + 7)/10),
					widthAnim = Math.floor(Math.random() * (150 - 15)) + 15,
					opAnim = Math.floor(Math.random() * (500 - 50)) + 50;
				$flake
					.clone()
					.appendTo('body')
					.css(
						{
							left: startPositionLeft,
							opacity: startOpacity,
							'font-size': sizeFlake,
							color: options.flakeColor,
							width: sizeFlake, 
							height: sizeFlake,
							'background-image': 'url(/images/snowflake' + (Math.floor(Math.random() * (7 - 1)) + 1) + '.gif)'
						}
					)
					.animate({'border-spacing': endPositionTop },{ 
				        step: function(p, fx) {
				            s = Math.sin(p/50);
				            op = Math.cos(p/opAnim);
				            y = s * (20 + widthAnim) + 70 + startPositionLeft;
				            var move = {top: p-50 + "px", left: y + "px", opacity: 0.2 + Math.abs(Math.abs(op)-0.4)};
				            $(fx.elem).css(move);
				        }, duration: durationFall, complete: function () { $(this).remove(); }
					});
			}, options.newOn);
	
	};
	
})(jQuery);