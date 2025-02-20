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

			var hr=location.href;
			setCookie("jid",alf);
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
			GetE('linkURL').value = "/?page_id=1510&id=" + setPageLink;
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

		</script>
		<style type="text/css">
			.pages {
				BACKGROUND: #ffffff;
				BORDER: 1px solid #a7a7a7;
				WIDTH: 556px;
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
                        $mz = new Magazine();
						$numberAll=$mz->getNumbersAll();
						echo "<select onChange={goto(this.value);} name='jour'>";
						echo "<option value=''></option>";
						echo "<option value=''>Все номера</option>";
						foreach ($numberAll as $num)
						{
						     echo "<option value=".$num[page_id].">".$num[page_name]." ".$num[year]."</option>";
						}
                        echo "</select>";
?>

						<br /><br />
							<?
								//$treePages = Dreamedit::createTreeArrayFromPersons($persons->getPersons(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
								?>

								<div class="pages" id="div<?=$search?>" style="DISPLAY: block;">
								<?

                                    if (empty($_REQUEST[jid]))
                                    {
								  	$p2podr = $mz->getPagesArticleNone("1");
									$tree = new WriteTree("tree".$v["page_id"], null);
									//$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");

//									$vids = $publications->getPublicationVidArray();
//  print_r($p2podr);
									//echo count($p2podr);
									$tree->displayArticlesTree("Статьи",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr);
									}
									else
									{

									   $p2podr=$mz->getMagazineNumber($_REQUEST[jid]);
//print_r($p2podr);
									   $tree = new WriteTree("tree".$v["page_id"], null);
   									   $tree->displayArticlesTree2("Статьи номера",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr);

									}
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