<?
include dirname(__FILE__)."/../../../../../_include.php";


$pg = new Pages();
//$tabs = $pg->getChilds(49);

foreach($pg->getChilds(49) as $v1)
{
	$tabs[] = array("page_id" => $v1["page_id"], "page_name" => $v1["page_name"]);
 	foreach($pg->getChilds($v1["page_id"]) as $v2)
 	{
		$tabs[] = array("page_id" => $v2["page_id"], "page_name" => "...".$v2["page_name"]);
	 	foreach($pg->getChilds($v2["page_id"]) as $v3)
 		{
			$tabs[] = array("page_id" => $v3["page_id"], "page_name" => "......".$v3["page_name"]);
		 	foreach($pg->getChilds($v3["page_id"]) as $v4)
	 		{
				$tabs[] = array("page_id" => $v4["page_id"], "page_name" => ".........".$v4["page_name"]);
		 	}
	 	}
	}
}
$tabs[] = array("page_id" => "49", "page_name" => "ѕродукты и услуги");
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

		// инициализаци€ контента при загрузке
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

		function treeSelect(setType,setPageLink, setPageTitle, setServiceGroup, setServiceString)
		{

			this.className = "nodeSel";
			if (setType=='g')
				GetE('linkURL').value = "/index.php?page_id=178&gid=" + setPageLink;
            else
				GetE('linkURL').value = "/index.php?page_id=178&id=" + setPageLink;

			if(!titleIsSet)
				GetE('linkText').value = setPageTitle;

//			GetE('linkGroup').value = setServiceGroup;
//			GetE('linkString').value = setServiceString;

		}

		// кнопичка "ќ "
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
							<!-- блок ссылок - страницы сайта -->
							<select id="selector" onchange="selChange(this)">

							<?
							global $DB;
							$dr=new Directories();
							foreach($tabs as $v)
								echo "<option value='div".$v["page_id"]."'>".$v["page_name"]."</option>\n";
							?>
							</select><br /><br />
							<?
								//$treePages = Dreamedit::createTreeArrayFromPersons($persons->getPersons(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
								foreach($tabs as $v)
								{?>

								<div class="pages" id="div<?=$v["page_id"]?>" style="DISPLAY: none">
								<?
									$serv=$dr->getServiceAll();
/*									$DB->select(
									  "SELECT * FROM (
										  (SELECT DISTINCT c.el_id,c.el_id AS gid,'0' AS sid,c.icont_text AS usluga
										  FROM adm_directories_content AS c
										  INNER JOIN adm_directories_element AS e ON e.el_id=c.el_id AND itype_id=5
										  INNER JOIN adm_directories_content AS s ON c.el_id=c.el_id AND s.icont_var='value'
								          WHERE c.icont_var='text'

								          ORDER BY s.icont_text)
								          UNION
										  (SELECT DISTINCT c.el_id,d.el_id AS gid,c.el_id AS sid,
										  CONCAT(d.icont_text,'. ',c.icont_text) AS usluga
								          FROM adm_ilines_content AS c
								          INNER JOIN adm_ilines_element AS e ON e.el_id=c.el_id AND itype_id=4
								          INNER JOIN adm_ilines_content AS s ON e.el_id=s.el_id AND s.icont_var='sort'
								          INNER JOIN adm_ilines_content AS g ON g.el_id=s.el_id AND g.icont_var='gruppa'
								          INNER JOIN adm_directories_content AS d ON d.el_id=g.icont_text AND d.icont_var='text'
								          INNER JOIN adm_directories_content AS dd ON dd.el_id=d.el_id AND dd.icont_var='value'
								         WHERE  c.icont_var='title'
								         ORDER BY dd.icont_text,s.icont_text) ) AS z
								         ORDER BY z.gid,sid"
									);
*/


									$tree = new WriteTree("tree".$v["page_id"], null);
									//$tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
				//					$tree->displayTree(Dreamedit::translate("ѕерсоны сайта"), $v["page_id"]);
									$tree->displayServiceTree("”слуги",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$serv);
//                                    foreach($p2podr as $p)
//                                    	echo $p["fullname"]."<br />";
						//			$openTo = $pg->getRootPageId();
								//	$tree->openTreeTo($openTo["page_id"], false);
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