<?
include dirname(__FILE__)."/../../../../../_include.php";
 $search = $_REQUEST["context"];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!--
* File Name: fck_cmslinks.php
* 	Plugin to insert links from CMS "DreamEdit"
*
* File Authors:
* 		Willfred di Vampo (divampo@gmail.com)
-->

<html>
	<head>
		<!--title>CMS Links - Made Simple CMS Link</title-->
		<meta http-equiv="Content-Type" content="text/html; charset=cp1251">
		<meta content="noindex, nofollow" name="robots">
		<script src="../../dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="https://<?=$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."includes/dTree/dtree.js"?>" type="text/javascript"></script>

		<script type="text/javascript">

		var titleIsSet	= false;
		var oEditor		= window.parent.InnerDialogLoaded() ;
		var FCK			= oEditor.FCK ;
		var FCKLang		= oEditor.FCKLang ;
		var FCKConfig	= oEditor.FCKConfig ;

		// если курсор стоит на ссылке - выбираем все сылку
		var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
		if ( oLink )
			FCK.Selection.SelectNode( oLink ) ;


		window.onload = function()
		{
			// Translate the dialog box texts.
//			oEditor.FCKLanguageManager.TranslatePage(document) ;

			// Show the initial dialog content.

			// Activate the "OK" button.
			window.parent.SetOkButton( true ) ;

		}

// Если выбран номер журнала
        function goto (alf) {

            var jj=GetE('jname').selectedIndex;

			var hr=location.href;
			setCookie("jid",alf);
			setCookie("jname",GetE("jname").value);
			setCookie("link_id",GetE('j_page').options[jj].value);
			setCookie("journal_name",GetE('journal_name').options[jj].value);
			location.href=hr;

}
// Cookies
function setCookie(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;


}
function getCookie(name)
{
cookie_name = name + "=";

cookie_length = document.cookie.length;
cookie_begin = 0;
while (cookie_begin < cookie_length)
{
value_begin = cookie_begin + cookie_name.length;
if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
{
var value_end = document.cookie.indexOf (";", value_begin);
if (value_end == -1)
{
value_end = cookie_length;
}
return unescape(document.cookie.substring(value_begin, value_end));
}
cookie_begin = document.cookie.indexOf(" ", cookie_begin) + 1;
if (cookie_begin == 0)
{
break;
}
}
return null;
}
		// что происходит при выборе той или иной ссылки
		function onLinkSelect(obj)
		{
			if(obj.tagName == "SELECT")
			{
				GetE('linkURL').value  = obj[obj.selectedIndex].value;
			}
			else
			{

			}
		}

		function selChange(obj)
		{
			<?
			//foreach($searches as $search)
			//	echo "GetE('div".$search."').style.display = 'none' ;\n";
			?>

			window.location = '<? echo $_SERVER["SCRIPT_NAME"];?>' + '?context=' + GetE('linkSrch').value;

		}

		function treeSelect(setPageLink, setPageTitle,  setName2)
		{
			this.className = "nodeSel";
//*************
			var link_id=getCookie('link_id');
			alert(link_id);
			GetE('linkURL').value = "/?page_id="+link_id+"&id=" + setPageLink;
			if(!titleIsSet)
				GetE('linkText').value = setPageTitle;

			GetE('linkName2').value = setName2;


		}

		// кнопичка "ОК"
		function Ok()
		{
			var sUri, sInnerHtml ;

			sUri = GetE('linkURL').value ;

			if ( sUri.length == 0 )
			{
				alert( FCKLang.DlnLnkMsgNoUrl ) ;
				return false ;
			}

			// No link selected, so try to create one.
			if ( !oLink )
				oLink = oEditor.FCK.CreateLink( sUri ) ;
			if ( oLink )
			{
//				sInnerHtml = oLink.innerHTML ;		// Save the innerHTML (IE changes it if it is like a URL).
			}
			else
			{
				// If no selection, use the uri as the link text (by dom, 2006-05-26)
//				sInnerHtml = sUri;

				// try to built better text for empty link
				// built new anchor and add link text
				oLink = oEditor.FCK.CreateElement( 'A' ) ;
			}

			oEditor.FCKUndo.SaveUndoStep() ;

			oLink.href = sUri ;
			SetAttribute( oLink, '_fcksavedurl', sUri ) ;

//			oLink.innerHTML = sInnerHtml ;		// Set (or restore) the innerHTML


			var name = GetE('linkText').value;

			if(GetE('chkName2').checked)
				name += ' ' + GetE('linkName2').value;


			oLink.innerHTML = name;		// Set (or restore) the innerHTML

			// Target
			if( GetE('cmbTarget').value != '' )
				SetAttribute( oLink, 'target', GetE('cmbTarget').value ) ;

			// Advances Attributes
			SetAttribute( oLink, 'title'	, GetE('linkTitle').value ) ;

			// Select the link.
			oEditor.FCKSelection.SelectNode(oLink);

			return true ;
		}
        function journal_change()
        {


           var jj=GetE('jname').value;

           var objSel = document.getElementById("jour0");
           var objSelNew = document.getElementById("jour");

           if (jj!=0)
           {
           objSelNew.length=0;
           	   objSelNew.options[objSelNew.options.length] = new Option("", "");
           }
           for(var i=0;i<objSel.length;i=i+1)
           {
           	   var aa=objSel.options[i].value;
          	   var ss=aa.split("#");
               if (ss[0]==jj)
	           	   objSelNew.options[objSelNew.options.length] = new Option(objSel.options[i].text, ss[1]);
           }

        }
		</script>
		<style type="text/css">
			.pages {
				BACKGROUND: #ffffff;
				BORDER: 1px solid #a7a7a7;
				WIDTH: 856px;
				HEIGHT: 243px;
				PADDING: 5px;
				OVERFLOW: auto;
			}
			HTML>body .pages {
				WIDTH: 504px;
				HEIGHT: 231px;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="https://<?=$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."includes/dTree/dtree.css"?>" />
	</head>

	<body scroll="no" style="overflow:hidden;">
	Выбрать журнал
<?   $mz = new Magazine();
     $rowsm=$mz->getMagazineNameAll();
//     print_r($rowsm);
     echo "<select onChange='journal_change();' name='jname' id='jname'>";
     echo "<option value='0'></option>";
     foreach ($rowsm as $rm)
     {
        echo "<option value=".$rm[page_id].">".$rm[page_name]."</option>";

     }
     echo "</select>";
     echo "<div style='display:none;'>";
     echo "<select name='j_page' id='j_page'>";
     echo "<option value='0'></option>";
     foreach ($rowsm as $rm)
     {
        echo "<option value=".$rm[link_id]."></option>";

     }
     echo "</select>";
     echo "<select name='journal_name' id='journal_name'>";
     echo "<option value='0'></option>";
     foreach ($rowsm as $rm)
     {
        echo "<option value=".$rm[page_name]."></option>";

     }
     echo "</select>";
     echo "</div>";
?>
	<table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0">
		<tr>
			<td>
				<table width="100%">
					<tr>

						<td colspan="2"><span fckLang="DlgCMSLinksObjectSelection">Выберите статью для ссылки:
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						если перед номер статьи стоит минус, значит этот номер журнала еще не опубликован
						</span>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
					<!--		Поиск по контексту: <input id="linkSrch" style="WIDTH: 350px;" type="text" name="linkTitleSrch" value="<? echo $search;?>">
							<button onclick="selChange(this)">Искать</button>
					/-->
					    Выберите номер:
<?


						$numberAll=$mz->getNumbersAllMagazine();
				//		print_r($numberAll);

						echo "<select onChange={goto(this.value);} name='jour' id ='jour'></select>";
						echo "<div style='display:none;'><select name='jour0' id = 'jour0'>";
						echo "<option value=''></option>";
						echo "<option value=''>Все номера</option>";
						foreach ($numberAll as $num)
						{
						     echo "<option value=".$num[journal]."#".$num[page_id].">".$num[page_name]." ".$num[year]."</option>";
						}
                        echo "</select></div>";
?>

						<br /><br />
							<?
								//$treePages = Dreamedit::createTreeArrayFromPersons($persons->getPersons(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
								?>

								<div class="pages" id="div<?=$search?>" style="DISPLAY: block;">
								<?
//
/*
                                    if (empty($_REQUEST[jid]))
                                    {

								  	$p2podr = $mz->getPagesArticleNone("1");

										$tree = new WriteTree("tree".$v["page_id"], null);
										$tree->displayArticlesTree("Статьи",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr);
									}
									else
									{

*/
									if (!empty($_REQUEST[jid]))
									{
									  $p2podr=$mz->getMagazineNumber($_REQUEST[jid]);
					                   $mag=$DB->select("SELECT a.*,m.page_name AS journal_name
					                   						FROM adm_article AS a
					                   						INNER JOIN adm_magazine AS m ON m.page_id = a.journal
					                   						WHERE a.page_id=".$_REQUEST[jid]);

//echo $_REQUEST[jid]."**";print_r($mag);
										   $tree = new WriteTree("tree".$v["page_id"], null);

   									   $tree->displayArticlesTree2($mag[0][journal_name]." №".$mag[0][page_name]." ".$p2podr[$_REQUEST[jid]][year],$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr);

									}
//									}
									?>
								</div>

								<?
							?>

						</td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkText">Link text</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="linkText" style="WIDTH: 400px;" type="text" name="linkText" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkURL">Link URL</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="linkURL" style="WIDTH: 400px;" type="text" name="linkURL" value=""></td>
					</tr>
  					<tr>
						<td nowrap><span fckLang="DlgCMSLinksTitle">Библиограф. сссылка</span>&nbsp;</td>
						<td width="100%" VALIGN="top" style="align:right;">
						<input id="chkName2"  type="checkbox" name="chkName2" value="">
						<textarea id="linkName2" rows="10" cols="45" name="linkName2" value="Вестник Института социологии"></textarea></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksTitle">Title</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="linkTitle" style="WIDTH: 400px;" type="text" name="linkTitle" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgLnkTarget">Target</span>&nbsp;</td>
						<td width="100%" style="align:right;">
							<select id="cmbTarget">
								<option value="" fckLang="DlgGenNotSet" selected="selected">&lt;not set&gt;</option>
								<option value="_blank" fckLang="DlgLnkTargetBlank">New Window (_blank)</option>
								<option value="_top" fckLang="DlgLnkTargetTop">Topmost Window (_top)</option>
								<option value="_self" fckLang="DlgLnkTargetSelf">Same Window (_self)</option>
								<option value="_parent" fckLang="DlgLnkTargetParent">Parent Window (_parent)</option>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	</body>
</html>