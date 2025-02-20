<?
global $page_content;

$pg = new Pages();

//print_r($_SERVER);

if(strpos($_SERVER[REQUEST_URI],"page_id")!==false) $pref="&"; else $pref="?";
//if(strpos($_SERVER[REQUEST_URI],"&en") !== false || strpos($_SERVER[REQUEST_URI],"?en") !== false)
if ($_SESSION[lang]=='/en')
{
  $menu_start= 2;
  $param="/en/";
  $_REQUEST[en]=true;
}
else
{
  $param="";
  $menu_start=2;
}
if (!isset($_REQUEST[en]))
	$menuRes = $pg->getChilds($menu_start, 1);
else	
	$menuRes = $pg->getChildsEn($menu_start, 1);

$menuRes = $pg->appendContent($menuRes);

$page_content["RAZDEL"] = "";

$len = count($menuRes);
$lenfull=count($menuRes);
// Подсчитать количество

foreach($menuRes as $row)
{
	$lenfull=1;
	if (!isset($_REQUEST[en]))
		$submenu0=$pg->getChildsMenu($row[page_id],1);
	else
		$submenu0=$pg->getChildsMenuEn($row[page_id],1);
	
	$lenfull+=count($submenu0);

}

if(!empty($menuRes))
{

  echo '<ul id="topnav" class="clearfix">';
 if ($_SESSION[lang]!='/en')
  echo '
  <li class="home">
<a rel="nofollow" href="/">
<img height="34" width="37" alt="" src="/images/men_icon_home.png">
</a>
</li>';
else
 echo '
  <li class="home">
<a rel="nofollow" href="/en">
<img height="34" width="37" alt="" src="/images/men_icon_home.png">
</a>
</li>';
  
$position = 1;

$li_left = 6;
$li_right = 6;
$a_left = 6;
$a_right = 6;

$menu_li_count = 0;
$menu_chars_count = 0;
$countCol=10;
$submenu_count=18;
// Выводим

foreach($menuRes as $row)
{
	if (!isset($_REQUEST[en]))
		$submenu0=$pg->getChilds($row[page_id],1);
	else
		$submenu0=$pg->getChildsEn($row[page_id],1);
	$lenfull = count($submenu0);

///////////////////////////
	$menu_chars_count = strlen($row["page_name"]);
	if($menu_li_count >= count($menuRes)/2)
	{
		//левый край одномерной
		$margin = (($li_right+$a_right)+$menu_chars_count*13);

		$margin -=  (!empty($row[menu_picture]) ? 185 : 0);
		$margin -= 276; // + ($step-1)*180;

	}
	else
		$margin = 0;

	
	$margin -= 17;
	$menu_li_count++;

    $i=0;
    $kk=array();
	 foreach($submenu0 as $k=>$submenu)
      {
        if (!isset($_REQUEST[en]))
			$submenu2=$pg->getChildsMenu($submenu[page_id],1);
		else	
			$submenu2=$pg->getChildsMenuEn($submenu[page_id],1);
         $lenfull+=count($submenu2);
         $kk[$i]=$k;

         $i++;
      }
	if((isset($subBranch[$_REQUEST["page_id"]]) || $row["page_id"] == $_REQUEST["page_id"]))
		 $classname = 	"active";
	else
		$classname = 	"";

	$step=1;
    if ($lenfull <=$countCol &&  $lenfull>0)
    {
        $name_col="one";
        $step=1;
        $aver=$lenfull;
    }
    else if ($lenfull<=(2*$countCol))
	{
	    	$name_col="two";
	    	$step=2;
	    	$aver=$lenfull/2;
	}
	else
	{
	    	$name_col="three";
	    	$step=3;
            $aver=$lenfull/3;
	}

//	if(strpos($pg->getPageUrl($row["page_id"]),"?")!==false) $pref="&"; else $pref="?";


        $pref="";
		if ($_SESSION[lang]!='/en')
        echo	"<li id='nav' ".
        "  class='first-level' ><a class='first-level ".$classname.
        "'  id=\"m\" onmouseout=\"this.id='m';\" onmouseover=\"this.id='over_m';\" onclick=\"document.location='/index.php?page_id=".
        $row["page_id"]."'\" nowrap=\"nowrap\">".$row["page_name"]."</a>";
        else
       echo	"<li id='nav' ".
        "  class='first-level' ><a class='first-level ".$classname.
        "'  id=\"m\" onmouseout=\"this.id='m';\" onmouseover=\"this.id='over_m';\" onclick=\"document.location='/en/index.php?page_id=".
        $row["page_id"]."'\" nowrap=\"nowrap\">".$row["page_name_en"]."</a>";
 		


    if ($lenfull>0)
    {
		echo '<div style="margin-left: '.$margin.'px;" class="topnav-dd-outer topnav-dd-outer'.(!empty($row[menu_picture]) ? '-featured' : '').' topnav-dd-outer-'.$name_col.'-col'.(!empty($row[menu_picture]) ? '-featured' : '').'">'
	   .'<div class="topnav-dd-inner clearfix">';


	 echo '<ul class="'.$name_col.'-col clearfix">';
     $i=0;

       for ($j=0;$j<(count($kk)/$step);$j++)

        {
           $submenu=$submenu0[$kk[$j]];
		   if (!isset($_REQUEST[en]))
				$submenu2=$pg->getChildsMenu($submenu[page_id],1);
		   else		
   				$submenu2=$pg->getChildsMenuEn($submenu[page_id],1);
			 if (count($submenu2)>0)
			 {
			 	$sym="&nbsp;…";

			 }
			 else $sym="";
			 if ($_SESSION[lang]!='/en')
             echo '
				<li>'.
					'<a href=/index.php?page_id='.$submenu[page_id].'>'.$submenu[page_name].'</a>';
			else
            echo '
				<li>'.
					'<a href=/en/index.php?page_id='.$submenu[page_id].'>'.$submenu[page_name_en].'</a>';
			


			   if (count($submenu2)<$submenu_count)
			   {
			   if (count($submenu2)>0 && count($submenu2)<$submenu_count) echo "<ul class='topnav-dd-inner-sub'>";
              
				 foreach($submenu2 as $sub2)
				 {
                echo "<li>"; 
                if ($sub2[page_template]!='news_full' && $sub2[page_template]!='1publ' && $sub2[page_template]!='pers_full')
				{
					if ($_SESSION[lang]!='/en')
					echo '<a href=/index.php?page_id='.$sub2[page_id].'>'.$sub2[page_name].'</a>';
					else
					echo '<a href=/en/index.php?page_id='.$sub2[page_id].'>'.$sub2[page_name_en].'</a>';
					
                }
				else
				{
                  if ($_SESSION[lang]!='/en')  echo  $sub2[page_name];
				  else echo  $sub2[page_name_en];
                }
				  echo "</li>";
     			 }
     			 if (count($submenu2)>0 && count($submenu2)<$submenu_count) echo "</ul>";
				}
                echo '
				</li>  ';
               $i++;
		}
        echo "</ul>";

        if ($lenfull>=$countCol)
		{
		   ////////////////////////////
		   echo '<ul class="three-col clearfix">';

		for ($j=$j;$j<(count($kk)/$step*2);$j++)
        {
           $submenu=$submenu0[$kk[$j]];
           if (!isset($_REQUEST[en]))
				$submenu2=$pg->getChildsMenu($submenu[page_id],1);
		   else	
  				$submenu2=$pg->getChildsMenuEn($submenu[page_id],1);

	       if (count($submenu2)>0)
			 {
			 	$sym="&nbsp;…";
			 }
			else $sym="";

             if (!empty($submenu[page_name]) && !isset($_REQUEST[en]))
             echo '<li><a href=/index.php?page_id='.$submenu[page_id].'>'.$submenu[page_name].'</a>';
		     if (!empty($submenu[page_name_en]) && isset($_REQUEST[en]))
             echo '<li><a href=/en/index.php?page_id='.$submenu[page_id].'>'.$submenu[page_name_en].'</a>';


			   if (count($submenu2)>0 && count($submenu2)<10) echo "<ul class='topnav-dd-inner-sub'>";
               {
				 foreach($submenu2 as $sub2)
				 {
					 if ($sub2[page_template]!='news_full' && $sub2[page_template]!='1publ' && $sub2[page_template]!='pers_full' && $sub2[page_template]!= 'search_persona')
					{
						 if (!isset($_REQUEST[en]))
							echo '<li><a href=/index.php?page_id='.$sub2[page_id].'>'.@$sub2[page_name].'</a></li>';
						 else	
							echo '<li><a href=/en/index.php?page_id='.$sub2[page_id].'>'.@$sub2[page_name_en].'</a></li>';
					   
					 }
				 }
				}

				if (count($submenu2)>0 && count($submenu2)<10) echo "</ul>";
                if (!empty($submenu[page_name])) echo '</li>  ';

			}
		////	
			echo "</ul>";
        }
       

        if (!empty($row[menu_picture]))
        {

?>
			<div id="nav-media-center-feature" class="topnav-feature">
				<div class="cp_tile ">
					<div id="block-nodeblock-43333" class="clear-block block block-nodeblock ">
						<div class="content">
							<? if(!empty($row[menu_header])) { ?>
							<p class="menu-feature-title">
								  <?=@$row[menu_header];?>
							</p>
							<?=@$row[menu_link];?>
							<? } ?>
							<p >
							
							<a style="float: right;" href="<? preg_match_all('/<a href=\"(.*)\">(.*)<\/a>/', $row[menu_link], $match);
								echo $match[1][0]; ?>">
								 <?=@$row[menu_picture];?>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
<?
         }
?>

		</div>

	</div><!--/ .topnav-dd-outer, .topnav-dd-inner -->
<?
echo "</li>";
$position++;
}//на длину

}



echo '
<li class="cleaner">&nbsp;</li>
</ul>';

}


?>