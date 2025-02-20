
<span id='crumb'>
<?
if ($_SESSION[jour]=='/jour') {
    $pref_jour = "/jour/".$_SESSION[jour_url];
} else {
    $pref_jour = "/";
}

if ($_SESSION[lang]!="/en")
{ 
	echo '<a href="'.$pref_jour.'">Главная</a>';
	$param="";

}
	else 
	{
		echo  '<a href="/en'.$pref_jour.'">Main page</a>';
		$param="/en";
	}	
?>
&nbsp;>&nbsp;
<?

// "Хлебные крошки"
$pg = new Pages();

$parent=$pg->getParents($_REQUEST[page_id]);
//print_r($parent);
foreach($parent as $k=>$pp)
{
//echo "<br />";print_r($pp);
if ($k > 2 && $pp[page_status]==1 && $k != $_REQUEST[page_id] && $pp[page_id]!=100)

  if (substr($pp[page_template],0,8)=='magazine')
  {
     
	 $param=$_SESSION[lang]."/jour/".$_SESSION[jour_url];
  
  }
  if($pp[page_status]) {
      if ($pp[page_name] != "Дополнительные страницы" && $pp[page_name] != "Эксперименты. архивные и рабочие материалы"
          && $pp[page_name] != 'Верхнее меню' && $pp[page_name] != 'Страница журнала' && $pp[page_name] != 'Серое меню' && $pp[page_name] != 'Дополнительная страница'
          && $pp[page_name] != 'Главная страница' && $pp[page_name] != 'ПЧ 2019 Программы' && $pp[page_name] != 'Главное меню' &&
          $pp[page_id] != $_REQUEST[page_id]
      ) {
          if ($_SESSION[lang] == "/en") $pp[page_name] = $pp[page_name_en];
          if ($pp[page_template] != 'magazine_page')
              echo "<a href=" . $param . "/index.php?page_id=" . $pp[page_id] . ">" . $pp[page_name] . '</a>&nbsp;>&nbsp;';
          else
              echo "<a href=" . $param . "/index.php?page_id=" . $pp[page_id] . "&jid=" . $_GET[jid] . ">" . $pp[page_name] . '</a>&nbsp;>&nbsp;';

      }
  }

}

if($parent[$_REQUEST[page_id]]['page_template']=="mag_archive" && !empty($_REQUEST['article_id'])) {
    if ($_SESSION[lang] == '/en') $parent[$_REQUEST[page_id]][page_name] = $parent[$_REQUEST[page_id]][page_name_en];
    echo "<a href=" . $param . "/index.php?page_id=" . $_REQUEST[page_id] . ">" . $parent[$_REQUEST[page_id]][page_name] . '</a>&nbsp;>&nbsp;';

    $mz = new Article();

    $parentMag = $mz->getParents($_REQUEST['article_id']);

    foreach ($parentMag as $magArticle) {
        switch ($magArticle['page_template']) {
            case 'jarticle':
                if ($_SESSION[lang] == "/en") $magArticle[name] = $magArticle[name_en];
                $articleName = $magArticle[name];
                break;
            case 'jnumber':
                if($_SESSION[lang] == "/en") {
                    if(!empty($magArticle[page_name_en])) {
                        $magArticle[page_name] = $magArticle[page_name_en];
                    } else {
                        $magArticle[page_name] = str_replace("т.", "vol.", $magArticle[page_name]);
                    }
                }
                $articleName = $magArticle[page_name];
                break;
            case 'jrubric':
                if ($_SESSION[lang] == "/en") $magArticle[page_name] = $magArticle[name_en];
                $articleName = $magArticle[page_name];
                break;
            case '0':
                if($magArticle['page_name']==$magArticle['year'] && strlen($magArticle['page_name'])==4) {

                    $articleName = $magArticle[page_name];
                    break;
                } else {
                    continue;
                }
                break;
            default:
                continue;
        }
        if(empty($articleName)) {
            continue;
        }
        if($magArticle['page_id']!=$_REQUEST['article_id']) {
            echo "<a href=" . $param . "/index.php?page_id=" . $_REQUEST[page_id] . "&article_id=" . $magArticle['page_id'] . ">" . $articleName . '</a>&nbsp;>&nbsp;';
        } else {
            echo $articleName;
        }
    }


} else {

    if ($parent[$_REQUEST[page_id]][page_name] != "Дополнительные страницы" && $parent[$_REQUEST[page_id]][page_name] != "Эксперименты. архивные и рабочие материалы") {
        if ($_SESSION[lang] == '/en') $parent[$_REQUEST[page_id]][page_name] = $parent[$_REQUEST[page_id]][page_name_en];
        echo $parent[$_REQUEST[page_id]][page_name];
    }
}



echo "
</span>
<br>
";

?>

