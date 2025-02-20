<div id="container"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this rotator.</div>

	<script type="text/javascript" src="swfobject.js"></script>
	<script type="text/javascript">
//		var s1 = new SWFObject("imagerotator.swf","rotator","435","208","7");
		var s1 = new SWFObject("imagerotator.swf", "ngg_slideshow2", "200", "150", "7", "#000000");

		s1.addParam("allowfullscreen","true");
		s1.addVariable("file","slideshow.xml");
		s1.addVariable("rotatetime", "4");
		s1.addVariable("transition", "random");
		s1.addVariable("width","435");
		s1.addVariable("height","208");
		s1.write("container");
	</script>