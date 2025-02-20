<?
global $DB,$page_content;

$pg = new Pages();

//print_r($_SERVER);

if(strpos($_SERVER[REQUEST_URI],"page_id")!==false) $pref="&"; else $pref="?";
$param="";$menu_start=2; 

if ($_SESSION[jour]=='/jour_cut')  /// Сделать для многих журналов
{
  $menu_start=$_SESSION[jour_id];
  $param.='/jour_cut';
}
$jourId=$DB->select("SELECT p.page_id AS page_start,pc2.page_id AS 'text_page' 
                       FROM adm_pages_content AS pc 
					   INNER JOIN adm_pages AS p ON p.page_id=pc.page_id AND p.page_template='magazine'
					   INNER JOIN adm_pages_content AS pc2 ON pc2.cv_name='itype_jour' AND pc2.cv_text='".$_SESSION[jour_id]."'".
					 " INNER JOIN adm_pages AS p2 ON p2.page_id=pc2.page_id AND p2.page_template='magazine_full' ".
					 " WHERE pc.cv_name='itype_jour' AND pc.cv_text='".$_SESSION[jour_id]."'"	);
					   

$page_start=$jourId[0][page_start];					   
$text_page=$jourId[0][text_page];
if ($_SESSION[lang]=='/en')
{
//  $menu_start= 2;
  $param.="/en/";
  $_REQUEST[en]=true;
}
else
{
  $param.="";
//  $menu_start=2;
}
if ($_SESSION[jour]=='/jour_cut')
			$pagej=$text_page."&id=";
		else $pagej="";
$pageid=$pg->getBranch($page_start);
$pid=array();$i=0;
foreach($pageid as $pp)
{
	
	if (substr($pp[page_template],0,8)=='magazine')
	{
	   $pid[$pp[page_template]][page_id]=$pp[page_id];
	   $pid[$pp[page_template]][page_name]=$pp[page_name];
	   $pid[$pp[page_template]][page_name_en]=$pp[page_name_en];
	   
	}   

	}
if ($_SESSION[lang]!='/en')
{
	$menuRes = $pg->getChildsJour($menu_start,1,null,null,null,$_SESSION[jour]);
}
	else	
{	
	$menuRes = $pg->getChildsJourEn($menu_start, 1,null,null,null,$_SESSION[jour]);
}
if (!empty($_SESSION[jour]))
{

$prefjour="/jour_cut/".$_SESSION[jour_url];

// Текущий номер
if($_SESSION[jour_url]!='god_planety')
{
$ppp=$pid[magazine_page][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_page][page_id];
$menuRes[$ppp][page_name]="Номер";
$menuRes[$ppp][page_name_en]="Current Issue";
// Архив
$ppp=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_name]="Архив номеров";
$menuRes[$ppp][page_name_en]="Archive Issues";
}
else
{
$ppp=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_archive][page_id];
$menuRes[$ppp][page_name]="Архив";
$menuRes[$ppp][page_name_en]="Archive";
}
// Авторский указатель
$ppp=$pid[magazine_authors_index][page_id];
$menuRes[$ppp][page_id]=$pid[magazine_authors_index][page_id];
$menuRes[$ppp][page_name]="Авторский указатель";
$menuRes[$ppp][page_name_en]="Authors Index";
}
else $prefjour="";
$menuRes = $pg->appendContent($menuRes);

$page_content["RAZDEL"] = "";

$len = count($menuRes);
$lenfull=count($menuRes);
// Подсчитать количество

foreach($menuRes as $row)
{
//	print_r($row);
	$lenfull=1;
	if ($_SESSION!='/en')
		$submenu0=$pg->getChildsMenuJour($row[page_id],1,null,null,null,$_SESSION[jour]);
	else
		$submenu0=$pg->getChildsMenuJourEn($row[page_id],1,null,null,null,$_SESSION[jour]);
	
	$lenfull+=count($submenu0);

}

if ($_SESSION[jour]=='/jour_cut') $main=$_SESSION[lang].'/jour_cut/'.$_SESSION[jour_url];
else $main="/".ltrim($_SESSION[lang],"/");
if(!empty($menuRes))
{

  echo '<ul id="topnav" class="clearfix">';
// if ($_SESSION[lang]!='/en')
  echo '
  <li class="home"> 
<a rel="nofollow" href='.$main.'>
<img height="34" width="37" alt="" src="/images/men_icon_home.png">
</a>
</li>';
//else
// echo '
//  <li class="home">
//<a rel="nofollow" href="/en">
//<img height="34" width="37" alt="" src="/images/men_icon_home.png">
//</a>
//</li>';
  
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
	
	if ($_SESSION[lang]!='/en')
		$submenu0=$pg->getChildsJour($row[page_id],1,null,null,null,$_SESSION[jour]);
	else
		$submenu0=$pg->getChildsJourEn($row[page_id],1,null,null,null,$_SESSION[jour]);
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
        
		if (substr($submenu[page_template],0,8)=='magazine' || $_SESSION[jour]=='/jour_cut')
			$prefjour="/jour_cut/".$_SESSION[jour_url];
		else
            $prefjour="";		
		if (!isset($_REQUEST[en]))
			$submenu2=$pg->getChildsMenuJour($submenu[page_id],1);
		else	
			$submenu2=$pg->getChildsMenuJourEn($submenu[page_id],1);
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
		if ($_SESSION[jour]=='/jour_cut' && ($row[page_template]=='text' || $row[page_template]=='magazine_page_archive')) 
		$page=$pagej; else $page="";
		if ($_SESSION[lang]!='/en')
        echo	"<li id='nav' ".
        "  class='first-level' ><a class='first-level ".$classname.
        "'  id=\"m\" onmouseout=\"this.id='m';\" onmouseover=\"this.id='over_m';\" onclick=\"document.location='".$prefjour."/index.php?page_id=".$page.
        $row["page_id"]."'\" nowrap=\"nowrap\">".$row["page_name"]."</a>";
        else
       echo	"<li id='nav' ".
        "  class='first-level' ><a class='first-level ".$classname.
        "'  id=\"m\" onmouseout=\"this.id='m';\" onmouseover=\"this.id='over_m';\" onclick=\"document.location='/en".$prefjour."/index.php?page_id=".$page.
        $row["page_id"]."'\" nowrap=\"nowrap\">".$row["page_name_en"]."</a>";
 		


    if ($lenfull>0)
    {
		echo '<div style="margin-left: '.$margin.'px;" class="topnav-dd-outer topnav-dd-outer'.(!empty($row[menu_picture]) ? '-featured' : '').' topnav-dd-outer-'.$name_col.'-col'.(!empty($row[menu_picture]) ? '-featured' : '').'">'
	   .'<div class="topnav-dd-inner clearfix">';


	 echo '<ul class="'.$name_col.'-col clearfix">';
     $i=0;


if($row[page_id]==492 || $row[page_id]==495 || $row[page_id]==494)
{

$opt_page=0;

if($row[page_id]==492)
	$opt_page=3;
if($row[page_id]==495)
	$opt_page=1;
if($row[page_id]==494)
	$opt_page=-1;


for ($j=0;$j<((count($kk)/$step)+$opt_page);$j++)

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
			 if ($_SESSION[jour]=='/jour_cut' && ($submenu[page_template]=='text' || $submenu[page_template]=='magazine_page_archive')) 
			 $page=$pagej; else $page="";
			 if ($_SESSION[lang]!='/en')
             echo '
				<li>'.
					'<a href='.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name].'</a>';
			else
            echo '
				<li>'.
					'<a href=/en'.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name_en].'</a>';
			


			   if (count($submenu2)<$submenu_count)
			   {
			   if (count($submenu2)>0 && count($submenu2)<$submenu_count) echo "<ul class='topnav-dd-inner-sub'>";
              
				 foreach($submenu2 as $sub2)
				 {
			
				if (substr($sub2[page_template],0,8)=='magazine'|| $_SESSION[jour]=='/jour_cut')
					$prefjour="/jour_cut/".$sub2[page_journame];
				else
				$prefjour="";		
				 if ($_SESSION[jour]=='/jour_cut' && ($row[page_template]=='text' || $row[page_template]=='magazine_page_archive')) 
				 $page=$pagej; else $page="";
                echo "<li>"; 
                if ($sub2[page_template]!='news_full' && $sub2[page_template]!='1publ' && $sub2[page_template]!='pers_full')
				{
					if ($_SESSION[lang]!='/en')
					echo '<a href='.$prefjour.'/index.php?page_id='.$page.$sub2[page_id].'>'.$sub2[page_name].'</a>';
					else
					echo '<a href='.$prefjour.'/en/index.php?page_id='.$page.$sub2[page_id].'>'.$sub2[page_name_en].'</a>';
					
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



}
else
{

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
			 if ($_SESSION[jour]=='/jour_cut' && ($submenu[page_template]=='text' || $submenu[page_template]=='magazine_page_archive')) 
			 $page=$pagej; else $page="";
			 if ($_SESSION[lang]!='/en')
             echo '
				<li>'.
					'<a href='.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name].'</a>';
			else
            echo '
				<li>'.
					'<a href=/en'.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name_en].'</a>';
			


			   if (count($submenu2)<$submenu_count)
			   {
			   if (count($submenu2)>0 && count($submenu2)<$submenu_count) echo "<ul class='topnav-dd-inner-sub'>";
              
				 foreach($submenu2 as $sub2)
				 {

					if($sub2[page_id]!=563)
					{
				if (substr($sub2[page_template],0,8)=='magazine'|| $_SESSION[jour]=='/jour_cut')
					$prefjour="/jour_cut/".$sub2[page_journame];
				else
				$prefjour="";		
				 if ($_SESSION[jour]=='/jour_cut' && ($row[page_template]=='text' || $row[page_template]=='magazine_page_archive')) 
				 $page=$pagej; else $page="";
                echo "<li>"; 
                if ($sub2[page_template]!='news_full' && $sub2[page_template]!='1publ' && $sub2[page_template]!='pers_full')
				{
					if ($_SESSION[lang]!='/en')
					echo '<a href='.$prefjour.'/index.php?page_id='.$page.$sub2[page_id].'>'.$sub2[page_name].'</a>';
					else
					echo '<a href='.$prefjour.'/en/index.php?page_id='.$page.$sub2[page_id].'>'.$sub2[page_name_en].'</a>';
					
                }
				else
				{
                  if ($_SESSION[lang]!='/en')  echo  $sub2[page_name];
				  else echo  $sub2[page_name_en];
                }
				  echo "</li>";
				  
			  }
     			 }
     			 if (count($submenu2)>0 && count($submenu2)<$submenu_count) echo "</ul>";
				}
                echo '
				</li>  ';
               $i++;
		}
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
            if (substr($row[page_template],0,8)=='magazine'|| $_SESSION[jour]=='/jour_cut')
					$prefjour="/jour_cut/".$_SESSION[jour_url];
				else
				$prefjour="";	
             if (!empty($submenu[page_name]) && $_SESSION[lang]!='/en')
             echo '<li><a href='.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name].'</a>';
		     if (!empty($submenu[page_name_en]) && $_SESSION[lang]=='/en')
             echo '<li><a href=/en'.$prefjour.'/index.php?page_id='.$page.$submenu[page_id].'>'.$submenu[page_name_en].'</a>';

              if ($_SESSION[jour]=='/jour_cut' && ($row[page_template]=='text' || $row[page_template]=='magazine_page_archive')) $page=$pagej; else $page="";
			   if (count($submenu2)>0 && count($submenu2)<10) echo "<ul class='topnav-dd-inner-sub'>";
               {
				 foreach($submenu2 as $sub2)
				 {
         //       print_r($sub2);
				if (substr($sub2[page_template],0,8)=='magazine') $prefjour='/jour_cut/'.$sub2[page_journame];
				else $prefjour="";
					if ($sub2[page_template]!='news_full' && $sub2[page_template]!='1publ' && $sub2[page_template]!='pers_full' && $sub2[page_template]!= 'search_persona')
					{
						if($prefjour=="")
						{
						 if ($_SESSION[lang]!='/en')
							echo '<li><a href=/index.php?page_id='.$page.$sub2[page_id].'>'.@$sub2[page_name].'</a></li>';
						 else	
							echo '<li>	<a href=/en/index.php?page_id='.$page.$sub2[page_id].'>'.@$sub2[page_name_en].'</a></li>';
					    }
						else
						{
							if ($_SESSION[lang]!='/en')
							echo '<li><a href='.$prefjour.'/index.php?page_id='.$page.$sub2[page_id].'>'.@$sub2[page_name].'</a></li>';
						 else	
							echo '<li>	<a href=/en/'.$prefjour.'/index.php?page_id='.$page.$sub2[page_id].'>'.@$sub2[page_name_en].'</a></li>';
						}
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