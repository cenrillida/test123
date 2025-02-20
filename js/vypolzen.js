var vypolzen_times = readCookie('vypolzen_times');
createCookie('vypolzen_times', vypolzen_times*1 + 1);
var vypolzen_max_times = 103;
var vypolzen_shown = false;
var vypolzen_showing = false;
var vypolzen_width = 375;
var vypolzen_disabled = vypolzen_times >= vypolzen_max_times;
if (navigator.userAgent.match(/iPad/) && screen.width<=1024) {
	var vypolzen_disabled = true;
}

function show_vypolzen() {
	//if ($('#vypolzen').css("left") == 0 || vypolzen_disabled) return;
	if (vypolzen_shown || vypolzen_disabled) return;
	//var vypolzen_times = readCookie('vypolzen_times');
	//if (vypolzen_times >= vypolzen_max_times) return;
	//createCookie('vypolzen_times', vypolzen_times*1 + 1);
	//console.log('showing vypolzen');
	vypolzen_shown = true;
	var img = document.getElementById('vypolzen_1x1');
	if (img) {
		img.src = 'http://gazeta.adfox.ru/getCode?p1=dwz&p2=bu&pe=b&pfc=jvy&pfb=dgrz&pr=eenfsqg';
	}
	if (vypolzen_showing) return;
	vypolzen_showing = true;
	$('.vypolzen_out').show();
	$('#vypolzen').show().animate({left: 0}, 400, 'swing', function () {
		$('.vypolzen_out').show();
		vypolzen_showing = false;
		if (!vypolzen_shown) {
			vypolzen_shown = true;
			hide_vypolzen();
		}
	});
}
function hide_vypolzen() {
	//if ($('#vypolzen').css("left") < 0) return;
	if (!vypolzen_shown) return;
	//console.log('hiding vypolzen');
	vypolzen_shown = false;
	if (vypolzen_showing) return;
	vypolzen_showing = true;
	$('#vypolzen').animate({left: 0-vypolzen_width}, 400, 'swing', function () { 
		$('.vypolzen_out').hide();
		vypolzen_showing = false;
		if (vypolzen_shown) {
			vypolzen_shown = false;
			show_vypolzen();
		}
	});
}

var vyp_height;

function setup_vypolzen_width() {
	vypolzen_width = Math.round($(window).width()*0.22 + 16);
	if (vypolzen_width < 228) {vypolzen_width = 228;}
	$('.vypolzen_out').css({width: '' + vypolzen_width + 'px'});
	$('.vypolzen_in').css({width: '' + vypolzen_width + 'px', left: vypolzen_shown ? '0px' : ('-' + vypolzen_width + 'px')});
}

function disable_vypolzen() {
	vypolzen_times = vypolzen_max_times;
//	createCookie('vypolzen_times', vypolzen_times*1 + 1);
	vypolzen_disabled = true;
	hide_vypolzen();
}

$(document).ready(function(){
	vyp_height = $('#vypolzen').height();
	//if (!vypolzen_shown) $('.vypolzen_out').hide();
	setup_vypolzen_width();
});

if (!navigator.userAgent.match(/iPad/)) {
	$(window).scroll(function () { 
		//if (textendmarker_top==0) textendmarker_top=
		var te_top = $('#text_end').offset().top;
		var tgb_top = 0;
		if($('#tgb_end').get(0))
			tgb_top = $('#tgb_end').offset().top;
		te_top = Math.max(te_top, tgb_top);
		var ve_top = $('#teaser_top').offset();
		ve_top = ve_top ? ve_top.top : ve_top;
		var doc_height = document.body.scrollHeight;
		var win_height = $(window).height();
		var div_height = win_height/3; //$('#vypolzen').height();
		if (div_height < vyp_height) div_height = vyp_height;
		
		if (doc_height - te_top < div_height) {
			var scr = $(document).scrollTop() + win_height;
		} else {
			var scr = $(document).scrollTop() + win_height - div_height;
		}
	
		//console.log([te_top, height, scr]);
		if (te_top < scr) {
			if (ve_top && $(document).scrollTop() + win_height > ve_top) {
				hide_vypolzen();
			} else {
				show_vypolzen();
			}
		} else {
			hide_vypolzen();
		}
	});
};