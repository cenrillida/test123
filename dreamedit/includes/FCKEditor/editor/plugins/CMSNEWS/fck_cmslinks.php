<?
include dirname(__FILE__)."/../../../../../_include.php";
 $search = $_REQUEST["context"];
global $DB;
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
           LoadSelection() ;

		// Activate the "OK" button.
			window.parent.SetOkButton( true ) ;

		}
// инициализация контента при загрузке
		function LoadSelection()
		{
//alert(FCK.EditorWindow.getSelection().anchorNode.childNodes[A.anchorOffset]);
			if(FCK.EditorDocument.selection)
				var selTxt = FCK.EditorDocument.selection.createRange().text
			else
				var selTxt = FCK.EditorWindow.getSelection().anchorNode.childNodes[A.anchorOffset];
//alert("@"+selTxt);
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

		function treeSelect(setPageLink, setPageTitle,  setName2,page_id)
		{
			this.className = "nodeSel";
			if (document.getElementById('chkEn').checked==false)
				GetE('linkURL').value = "/?page_id="+page_id+"&id=" + setPageLink;
			else
				GetE('linkURL').value = "/?page_id="+page_id+"&id=" + setPageLink+"&en";
		
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

						<td colspan="2"><span fckLang="DlgCMSLinksObjectSelection">Select object to create link to:</span>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
							Поиск по контексту: <input id="linkSrch" style="WIDTH: 350px;" type="text" name="linkTitleSrch" value="<? echo $search;?>">
							<button onclick="selChange(this)">Искать</button>
							<br /><br />
							<?
								//$treePages = Dreamedit::createTreeArrayFromPersons($persons->getPersons(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
								?>

								<div class="pages" id="div<?=$search?>" style="DISPLAY: block;">
								<?
									$publications = new Publications();
			//					  	$p2podr = $publications->getPublicationsByContextSearch($search);
			 $new_list0=$DB->select("SELECT DISTINCT n.el_id AS id,n.icont_text AS name,t.icont_text AS name2,substring(y.icont_text,1,4) AS vid,
									IF (d2.icont_text<>'',d2.icont_text,'502') AS tip".
			                         " FROM adm_ilines_content AS n ".
									 " INNER JOIN adm_ilines_content AS y ON y.el_id=n.el_id AND y.icont_var='date'".
									 " INNER JOIN adm_ilines_content AS t ON t.el_id=n.el_id AND t.icont_var='prev_text'".
									 " INNER JOIN adm_ilines_element AS e ON e.el_id=n.el_id AND 
									        (e.itype_id='3' OR e.itype_id='1' OR e.itype_id='6' OR e.itype_id='4' OR e.itype_id='5')".
									 " LEFT OUTER JOIN adm_directories_content AS d1 ON d1.icont_text=e.itype_id AND d1.icont_var='news_line' ".
									 " LEFT OUTER JOIN adm_directories_content AS d2 ON d2.el_id=d1.el_id AND d2.icont_var='value' ".
									 " WHERE n.icont_var='title'"
			 );
//print_r($new_list0);
									$tree = new WriteTree("tree".$v["page_id"], null);
									//$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");

					//				$vids = а$publications->getPublicationVidArray();
                                    $years=$DB->select("SELECT DISTINCT substring(icont_text,1,4) AS year FROM adm_ilines_content WHERE icont_var='date' ORDER BY substring(icont_text,1,4)  DESC");                   
									$i=0;
									foreach($years as $y)
									{
									   $year[$i]=$y[year];
									   $i++;
									}
	
	$tree->displayNewsTree("Новости, объявления",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$new_list0,$year);
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
						<td nowrap><span fckLang="DlgCMSLinkEn">Английская версия</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkEn"  type="checkbox" name="chkEn" value=""></td>
					</tr>
  					<tr>
						<td nowrap><span fckLang="DlgCMSLinksTitle">Краткий текст</span>&nbsp;</td>
						<td width="100%" VALIGN="top" style="align:right;"><input id="chkName2"  type="checkbox" name="chkName2" value=""><textarea id="linkName2" rows="10" cols="45" name="linkName2" value=""></textarea></td>
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