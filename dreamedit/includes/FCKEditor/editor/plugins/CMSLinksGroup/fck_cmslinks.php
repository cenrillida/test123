<?
include dirname(__FILE__)."/../../../../../_include.php";


$pg = new Pages();
$tabs = $pg->getChilds($pg->getRootPageId());
$tabs[] = array("page_id" => "0", "page_name" => "Страницы сайта");
$first = array_shift($tabs);
array_unshift($tabs, $first);
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
			GetE('div<?=$first["page_id"]?>').style.display = '' ;

			var oldCookie = Get_Cookie( "deLastIdTree" );
			if(oldCookie)
				GetE("selector").options[oldCookie].selected = true;

			// Load the selected link information (if any).
			LoadSelection() ;

			// Activate the "OK" button.
			window.parent.SetOkButton( true ) ;

		}

		// инициализация контента при загрузке
		function LoadSelection()
		{

			if(FCK.EditorDocument.selection)
				var selTxt = FCK.EditorDocument.selection.createRange().text
			else
				var selTxt = FCK.EditorWindow.getSelection().anchorNode.childNodes[A.anchorOffset];

			if(selTxt != "")
			{
				GetE('linkText').value = selTxt ;
				titleIsSet = true;
			}

			if ( !oLink ) { return ; }

			titleIsSet = true;

			// Get the actual Link href.
			var sHRef = oLink.getAttribute( '_fcksavedurl' ) ;
			if ( !sHRef || sHRef.length == 0 )
				sHRef = oLink.getAttribute( 'href' , 2 ) + '' ;
			
			// Get the target.
			var sTarget = oLink.target ;

			if ( sTarget && sTarget.length > 0 )
			{
				sTarget = sTarget.toLowerCase() ;
				GetE('cmbTarget').value = sTarget ;
			}

			// Get Advances Attributes
			GetE('linkTitle').value	= oLink.title ;
			GetE('linkURL').value = sHRef ;
		}

		function Set_Cookie( name, value, expires, path, domain, secure ) 
		{
			// set time, it's in milliseconds
			var today = new Date();
			today.setTime( today.getTime() );

			if ( expires )
			{
				expires = expires * 1000 * 60;
			}
			var expires_date = new Date( today.getTime() + (expires) );

			document.cookie = name + "=" +escape( value ) +
			( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + 
			( ( path ) ? ";path=" + path : "" ) + 
			( ( domain ) ? ";domain=" + domain : "" ) +
			( ( secure ) ? ";secure" : "" );
		}

		// this function gets the cookie, if it exists
		function Get_Cookie( name ) {
			
			var start = document.cookie.indexOf( name + "=" );
			var len = start + name.length + 1;
			if ( ( !start ) &&
			( name != document.cookie.substring( 0, name.length ) ) )
			{
				return null;
			}
			if ( start == -1 ) return null;
			var end = document.cookie.indexOf( ";", len );
			if ( end == -1 ) end = document.cookie.length;

			return unescape( document.cookie.substring( len, end ) );
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
			foreach($tabs as $v)
				echo "GetE('div".$v["page_id"]."').style.display = 'none' ;\n";
			?>
			GetE(obj.options[obj.selectedIndex].value).style.display = '' ;

			Set_Cookie( "deLastIdTree", obj.selectedIndex, "60" ) ;
		}

		function treeSelect(setPageLink, setPageTitle)
		{
			this.className = "nodeSel";
			GetE('linkURL').value = setPageLink;
			if(!titleIsSet)
				GetE('linkText').value = setPageTitle;
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

            if (document.getElementById('chkEn').checked==true) sUri=sUri+"&en";
			oLink.href = sUri ;
			SetAttribute( oLink, '_fcksavedurl', sUri ) ;

//			oLink.innerHTML = sInnerHtml ;		// Set (or restore) the innerHTML
			oLink.innerHTML = GetE('linkText').value ;		// Set (or restore) the innerHTML

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

						<td colspan="2"><span fckLang="DlgCMSLinksObjectSelection">Select object to create link to:</span>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							<!-- блок ссылок - страницы сайта -->
							<select id="selector" onchange="selChange(this)">
							<?
							foreach($tabs as $v)
								echo "<option value='div".$v["page_id"]."'>".$v["page_name"]."</option>\n";
							?>
							</select><br /><br />
							<?
								$treePages = Dreamedit::createTreeArrayFromPages($pg->getPages(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
								foreach($tabs as $v)
								{?>

								<div class="pages" id="div<?=$v["page_id"]?>" style="DISPLAY: none">
								<?
									$pg = new Pages();
									$tree = new WriteTree("d".$v["page_id"], $treePages);
									$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
									$tree->displayTree(Dreamedit::translate("Страницы сайта"), $v["page_id"]);

									$openTo = $pg->getRootPageId();
									$tree->openTreeTo($openTo["page_id"], false);
									?>
								</div>
								
								<?
								}
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
						<td nowrap><span fckLang="DlgCMSLinkEn">Английская версия</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkEn"  type="checkbox" name="chkEn" value=""></td>
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