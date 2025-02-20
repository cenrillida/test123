<?
include dirname(__FILE__)."/../../../../../_include.php";


$pg = new Pages();


$tabs[] = array("page_id" => "80", "page_name" => "Персоны");
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

		function treeSelect(setPageLink, setPageTitle, setPersonOtdel, setPersonContact, setPersonDolj,setPersonUS, setPicBig,setPicSmall,setPersonUZ, setRAN)
		{
			this.className = "nodeSel";
			GetE('linkURL').value = "/?page_id=80&id=" + setPageLink;
			GetE('chkSmallPhoto').value = "/dreamedit/foto/" + setPicSmall;
			GetE('chkBigPhoto').value = "/dreamedit/foto/" + setPicBig;

			if(!titleIsSet)
				GetE('linkText').value = setPageTitle;

			GetE('linkOtdel').value = setPersonOtdel;
			GetE('linkContact').value = setPersonContact;
			GetE('linkDolj').value = setPersonDolj;
			GetE('linkUSZ').value = setRAN + ' ' + setPersonUS + ' '+ setPersonUZ + ' ';


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
			if(GetE('chkUSZ').checked)
				name += ' ' + GetE('linkUSZ').value;
			if(GetE('chkDolj').checked)
				name += ' ' + GetE('linkDolj').value;
			if(GetE('chkOtdel').checked)
				name += ' ' + GetE('linkOtdel').value;
			if(GetE('chkContact').checked)
				name += ' ' + GetE('linkContact').value;
			if(GetE('chkSmallPhoto').checked)
				name += ' ' + '<img src="'+chkSmallPhoto.value + '" />'  ;
			if(GetE('chkBigPhoto').checked)
				name += ' ' + '<img src="'+chkBigPhoto.value + '" />' ;





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

<script language="javascript">

function goto (alf) {

var hr=location.href;

setCookie("bukva",alf);
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
<!--                            ***********************  <a href="javascript:windows.location.href=windows.location.href+&id=Б">Б</a>123
                            window.location.href=
                            window.location.reload(true);
-->
                            <a href="javascript:goto('<? echo ord(А);?>')">А </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Б);?>')">Б </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(В);?>')">В </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Г);?>')">Г </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Д);?>')">Д </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Е);?>')">Е </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ё);?>')">Ё </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ж);?>')">Ж </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(З);?>')">З </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(И);?>')">И </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(К);?>')">К </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Л);?>')">Л </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(М);?>')">М </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Н);?>')">Н </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(О);?>')">О </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(П);?>')">П </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Р);?>')">Р </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(С);?>')">С </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Т);?>')">Т </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(У);?>')">У </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ф);?>')">Ф </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Х);?>')">Х </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ц);?>')">Ц </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ч);?>')">Ч </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ш);?>')">Ш </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Щ);?>')">Щ </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Э);?>')">Э </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Ю);?>')">Ю </a>&nbsp;
                            <a href="javascript:goto('<? echo ord(Я);?>')">Я </a>&nbsp;
                            <a href="javascript:goto('<? echo (AZ);?>')">A..Z</a>&nbsp;
                            <br /><br />
							<?



                            if (empty($_COOKIE[bukva]))
                               $bukva="А";
                            else
                               if ($_COOKIE[bukva]!="AZ") $bukva=chr($_COOKIE[bukva]);
                               else $bukva="AZ";


        						foreach($tabs as $v)
								{?>

								<div class="pages" id="div<?=$v["page_id"]?>" style="DISPLAY: none">
								<?
									$persons = new ROSPersons();
								  	$p2podr = $persons->getPersonsAll($bukva);

									$tree = new WriteTree("tree".$v["page_id"], null);

									$tree->displayFlatTree("Персоналии",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr,$bukva);
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
						<td nowrap><span fckLang="DlgCMSLinksEn">Английская версия</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkUSZ"  type="checkbox" name="chkEn" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkText">ФИО (полностью)</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkUSZ"  type="checkbox" name="chkUSZ" value=""><input  id="linkUSZ" style="WIDTH: 400px;" type="text" name="linkUSZ" value=""></td>
					</tr>

  					<tr>
						<td nowrap><span fckLang="DlgCMSLinksTitle">О персоне</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkDolj"  type="checkbox" name="chkDolj" value=""><input id="linkDolj" style="WIDTH: 400px;" type="text" name="linkDolj" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkText">FIO )</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkOtdel"  type="checkbox" name="chkOtdel" value=""><input id="linkOtdel" style="WIDTH: 400px;" type="text" name="linkOtdel" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkText">Контактная информация</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkContact"  type="checkbox" name="chkContact" value=""><input id="linkContact" style="WIDTH: 400px;" type="text" name="linkContact" value=""></td>
					</tr>
					<tr>
						<td nowrap><span fckLang="DlgCMSLinksLinkText">Фото</span>&nbsp;</td>
						<td width="100%" style="align:right;"><input id="chkSmallPhoto"  type="checkbox" name="chkSmallPhoto" value="">Маленькое фото&nbsp;&nbsp;&nbsp;&nbsp;<input id="chkBigPhoto"  type="checkbox" name="chkBigPhoto" value="">Большое фото</td>
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