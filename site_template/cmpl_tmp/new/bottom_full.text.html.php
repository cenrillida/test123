</section>
<?
				if (!isset($_REQUEST[printmode]) )
				{
if($_SESSION[jour_url]=='')
{
?>
		</td><td align=right>
		
		<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=23590912&amp;from=informer"
target="_blank" rel="nofollow" style="display: none;"><img src="//bs.yandex.ru/informer/23590912/3_0_205386FF_003366FF_1_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:23590912,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter23590912 = new Ya.Metrika({id:23590912,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/23590912" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
		
		
		<!----------------------------------------------------------------------->
    <? /* ?>
		<!--Rating@Mail.ru COUNTER--><script language="JavaScript"><!--
d=document;a='';a+=';r='+escape(d.referrer)
js=10//--></script><script language="JavaScript1.1"><!--
a+=';j='+navigator.javaEnabled()
js=11//--></script><script language="JavaScript1.2"><!--
s=screen;a+=';s='+s.width+'*'+s.height
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth)
js=12//--></script><script language="JavaScript1.3"><!--
js=13//--></script><script language="JavaScript"><!--
d.write('<a href="http://top.mail.ru/jump?from=270684"'+
' target=_top><img src="http://top.list.ru/counter'+
'?id=270684;t=130;js='+js+a+';rand='+Math.random()+
'" alt="Рейтинг@Mail.ru"'+' border=0 height=40 width=88></a>')
if(js>11)d.write('<'+'!-- ')//--></script><noscript><a
target=_top href="http://top.mail.ru/jump?from=270684"><img
src="http://top.list.ru/counter?js=na;id=270684;t=130"
border=0 
alt="Рейтинг@Mail.ru"></a></noscript><script language="JavaScript"><!--
if(js>11)d.write('--'+'>')//--></script><!--/COUNTER-->

<?
 */
}
else
{
	echo '</td><td align=right style="width: 200px;">';
	global $DB;
	$date = date("Y-m-d");
	$stats_today = $DB->select("SELECT views, hosts FROM magazine_visits WHERE magazine='".$_SESSION[jour_url]."' AND date='".$date."'");
	$stats_all = $DB->select("SELECT SUM(views) AS 'views' FROM magazine_visits WHERE magazine='".$_SESSION[jour_url]."'");
	if($_SESSION[lang]!='/en')
	{
		echo "Просмотров сегодня: ".$stats_today[0]['views']."<br>";
		echo "Уникальных посетителей сегодня: ".$stats_today[0]['hosts']."<br>";
		echo "Просмотров всего: ".$stats_all[0]['views']."<br>";
	}
	else
	{
		echo "Views today: ".$stats_today[0]['views']."<br>";
		echo "Unique users today: ".$stats_today[0]['hosts']."<br>";
		echo "Total views: ".$stats_all[0]['views']."<br>";
	}
}
?>
		</td>
		</tr></table>
		</div>
	</div> <!-- #content /-->
	
<?
	}
	if (isset($_REQUEST[printmode]))
{

echo "<br clear='all' />";
   if (empty($_SERVER[REDIRECT_URL]))
   {
       echo "<hr /><div style='text-align:center;height:50px;'><a href=/index.php?".str_replace('&printmode','',$_SERVER[QUERY_STRING])." >
       <font size='3' color='red'><b>полная версия страницы</b></font></a>";
	    echo "<br />© ИМЭМО РАН, ".date("Y")." (<a href=https://www.imemo.ru>https://www.imemo.ru</a>)";
	   echo "</div>";
   }
   else
   {
      echo "<hr /><div style='text-align:center;height:50px;'><table><tr><td><a  href=/".substr($_SERVER[REDIRECT_URL],1)."?".str_replace('&printmode','',$_SERVER[QUERY_STRING])." >
      <font size='3' color='#FFAE00'><b>полная версия страницы</b></font></a>";
	   echo "<br />© ИМЭМО РАН, ".date("Y")." (<a href=https://www.imemo.ru>https://www.imemo.ru</a>)";
	  echo "</td></tr></table></div>";
  }

}

	global $_CONFIG, $site_templater;
	$site_templater->displayResultFromPath($_CONFIG["global"]["paths"]["template_path"]."bottom.html");
?>