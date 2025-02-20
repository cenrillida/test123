<?
// Список услуг на главной странице
?>
<script language="JavaScript">
 function ch_usluga(id,focus)
 {

    var a=document.getElementById("a"+id).style;
    var b=document.getElementById("b"+id).style;

    if (focus=='focus')
    {
       a.display='block';
       b.color='#FFAE00';
    }
    else
    {
    	a.display='none';
    	b.color='#303030';
    }
 }
</script>

<?
global $DB,$_CONFIG;

$str=$DB->select("SELECT h1.el_id,h1.icont_text AS text,en.icont_text AS text_en,h2.icont_text AS sort
				FROM adm_directories_content AS h1
                 LEFT OUTER JOIN adm_directories_content AS en ON en.el_id=h1.el_id AND en.icont_var='text_en'
                 INNER JOIN adm_directories_content AS h2 ON h2.el_id=h1.el_id AND h2.icont_var='value'
                 INNER JOIN adm_directories_content AS h3 ON h3.el_id=h1.el_id AND h3.icont_var='cclass'
                 INNER JOIN adm_directories_element AS e ON e.el_id=h1.el_id AND e.itype_id=5
	 WHERE h1.icont_var='text' AND h3.icont_text='Услуга'
	 ORDER BY h2.icont_text ");
     echo "<ul  class='speclist'>";
     foreach($str as $s)
     {
        $rows=$DB->select("SELECT a.el_id,a.icont_text AS name,aen.icont_text AS name_en
                           FROM adm_ilines_content AS a
                           LEFT OUTER JOIN adm_ilines_content AS aen ON aen.el_id=aen.el_id AND aen.icont_var='title_en'
                           INNER JOIN adm_ilines_content AS g ON g.el_id=a.el_id AND g.icont_var='gruppa'
                           INNER JOIN adm_ilines_content AS s ON s.el_id=a.el_id AND s.icont_var='sort'
                           INNER JOIN adm_ilines_content AS ss ON ss.el_id=a.el_id AND ss.icont_var='status' AND ss.icont_text='1'
                           INNER JOIN adm_directories_content AS d ON d.el_id=g.icont_text AND d.icont_var='value'

                           WHERE a.icont_var='title' AND d.el_id=".$s[el_id].
                           " ORDER BY s.icont_text");
        if(!(isset($_REQUEST[en]) && empty($s[text_en])))
        echo "<li >";



        if (count($rows)>1)
        {
        	echo "<div   _onmousemove=javascript:ch_usluga(".$s[el_id].",'focus');  _onmouseout=javascript:ch_usluga(".$s[el_id].",'blur'); >
        	<a  href=/index.php?page_id=".$page_content["USLUGA_LIST"]."&gid=".$s[el_id].
        	" _onclick=javascript:ch_usluga(".$s[el_id]."); id='b".$s[el_id]."' style='cursor:pointer;'  >".$s[text]."</a>";
        	echo "<div id='a".$s[el_id]."' style='display:none;'>";

        	echo "<ul>";
            foreach($rows as $r)
            {
                if (!isset($_REQUEST[en]))
	                echo "<li><a href=/index.php?page_id=".$page_content["USLUGA_PAGE"]."&id=".$r[el_id].">".$r[name]."</a></li>";
	            else
	                echo "<li><a href=/index.php?page_id=".$page_content["USLUGA_PAGE"]."&id=".$r[el_id].">".$r[name_en]."</a></li>";

            }
            echo "</ul>";
            echo "</div>";
            echo "</div>";
         }
        elseif (count($rows)==1)
        {
        	if (!isset($_REQUEST[en]))
	        	echo "<a  id='b".$s[el_id]."' href=/index.php?page_id=".$page_content["USLUGA_PAGE"]."&id=".$rows[0][el_id].">".$s[text]."</a>";
	        else
	        {
	        	if (!empty($s[text_en]))
	        		echo "<a  id='b".$s[el_id]."' href=/index.php?page_id=".$page_content["USLUGA_PAGE"]."&id=".$rows[0][el_id].">".$s[text_en]."</a>";
            }
        }
        else
            echo $s[text];
        if(!(isset($_REQUEST[en]) && empty($s[text_en]))) echo "</li>";
     }
     echo "</ul>";
?>
