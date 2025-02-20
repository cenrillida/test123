<script type="text/javascript" src="/swfobject.js"></script>
<?

 $h_screen=244;
 $v_screen=183;
 $time=5;
 $playlist="slidelist.xml";

						echo "<div class='player'  style='text-align:center; background-color:#ffffff;'>\n";
			 			echo "<div id='player2' style='color:white;'>Если Вы не видете изображение, пожалуйста, <a href=http://get.adobe.com/flashplayer/>скачайте flash player с официального сайта Adobe</a></div>\n";
		 				echo "<script type='text/javascript'>\n";

							echo "  var so = new SWFObject('/files/Flash/imagerotator.swf','ngg_slideshow2',
							'".$h_screen."','".$v_screen."','4');\n";
							echo "  so.addParam('allowfullscreen','true');\n";
							echo "  so.addVariable('displayheight','".$v_screen."');\n";
							echo "  so.addVariable('repeat','true');\n";
							echo "  so.addVariable('height','".$v_screen."');\n";
							echo "  so.addVariable('width','".$h_screen."');\n";
                            echo "  so.addVariable('rotatetime', '".$time."');\n";
                            echo "	so.addVariable('transition', 'random');\n";
                      //      echo "	so.addVariable('screencolor','0x0486b0');\n";
							 echo "	so.addVariable('screencolor','0xffffff');\n";
						echo "	so.addVariable('frontcolor','0xffffff');\n";

						echo "	so.addVariable('file','/".$playlist."?id=2');\n";
						echo "	so.write('player2');\n";
						echo "</script>\n";
							echo "<a href=/cpg15x/index.php title='Открыть фотоальбом'>Перейти в фотоальбом</a></font>";
						echo "</div>\n";


                        echo "<br />";
?>