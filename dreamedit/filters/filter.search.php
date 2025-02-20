
<?

$pg = new Pages();
$tpl0=$pg->getPageById($_REQUEST[page_id]);
if ($_SESSION[lang]!='/en')
{
  $search1='поиск...';
  $search2='найти';
  
}
else
{
  $search1='search text';
  $search2='search';

}
//print_r($tpl0);
?>
<script language="JavaScript">

function sw_search()
{
    var st=document.getElementById('spisok_search').style;
    if (st.display=='none')
       st.display='block';
    else
       st.display='none';
}
</script>


<div id="search"  >   <!-- 0486b0 -->
   <br />
    <? if ($_SESSION[jour]!='/jour') 
     {
  ?>	 
  <form action="<?=@$_SESSION[lang]?>/search.html" method="GET" id="sear">
  <?
  }
  else
  {
  ?>
   <form action="<?=@$_SESSION[lang]?>/jour/meimo/index.php?page_id=1179" method="POST" id="sear">
  <?
}
?>
   <table cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<? if(empty($_REQUEST['search'])) $search='поиск...';
			   else $search=$_REQUEST['search'];
			?>
				 <input id="search_txt" type="text" name="search" size=20 value="<?=$search1?>" onblur="if(this.value=='') this.value='<?=@$search1?>';" onfocus="if(this.value=='<?=@$search1?>') this.value='';" />
			 </td>
			 <td width="100%" align="left">
				 <a id="search_btn" style='cursor:pointer;cursor:hand; text-decoration:none;' onclick="document.getElementById('sear').submit();">
				    <span>
				          <?=@$search2?>
			    	</span>
			</td>
			<!--
			<td width="21" style="border-left:white solid 1px;">
		        <a style='cursor:pointer;cursor:hand;' onClick=sw_search()><img src="/image/search.png" title="Выбрать, где искать" border="0"></a>
	        </td> /-->
	  	</tr>

  	</table>

<!--		<div id='spisok_search' style="text-align:left;background-color:#ffffff;padding:1 2 2 1;display:none;color:#303030;">
		<div style='float:left;height: 40px;'>
			Выберите:&nbsp;&nbsp;
		</div>
			<a  style='cursor:pointer;cursor:hand;color:#303030;' onClick="location = '/search.php?search='+document.getElementById('search_txt').value; ">
			   &rarr; на сайте
			</a> <br />
			<a  style='cursor:pointer;cursor:hand;color:#303030;' onClick="location = '/index.php?page_id=652&search='+document.getElementById('search_txt').value; ">
			   &rarr; в публикациях
			</a>  <br />


		</div>
/-->
   </form>
</div>