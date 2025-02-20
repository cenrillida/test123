var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;

//#### Dialog Tabs

// Set the dialog tabs.
window.parent.AddTab( 'Info', FCKLang.DlgLnkInfoTab ) ;

if ( !FCKConfig.LinkDlgHideAdvanced )
	window.parent.AddTab( 'Advanced', FCKLang.DlgAdvancedTag ) ;

// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
	ShowE('divAttribs'	, ( tabCode == 'Advanced' ) ) ;
}

//#### Regular Expressions library.
var oRegex = new Object() ;

oRegex.UriProtocol = new RegExp('') ;
oRegex.UriProtocol.compile( '^(((http|https|ftp|news):\/\/)|mailto:)', 'gi' ) ;

oRegex.UrlOnChangeProtocol = new RegExp('') ;
oRegex.UrlOnChangeProtocol.compile( '^(http|https|ftp|news)://(?=.)', 'gi' ) ;

oRegex.UrlOnChangeTestOther = new RegExp('') ;
oRegex.UrlOnChangeTestOther.compile( '^(javascript:|#|/)', 'gi' ) ;

//#### Initialization Code
var oLink = FCK.Selection.GetSelectedElement() ;

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	// Load the selected link information (if any).
	LoadSelection() ;

	// Show/Hide the "Browse Server" button.
	GetE('divBrowseServer').style.display = FCKConfig.LinkBrowser ? '' : 'none' ;

	// Show the initial dialog content.
	GetE('divInfo').style.display = '' ;

	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
}

function LoadSelection()
{
	if ( !oLink ) return ;

	var sType = 'url' ;

	// Get the actual Link href.
	var sHRef = oLink.getAttribute('src',2) + '' ;

	// Search for the protocol.
	var sProtocol = oRegex.UriProtocol.exec( sHRef ) ;

	if ( sProtocol )
	{
		sProtocol = sProtocol[0].toLowerCase() ;
		GetE('cmbLinkProtocol').value = sProtocol ;

		// Remove the protocol and get the remainig URL.
		var sUrl = sHRef.replace( oRegex.UriProtocol, '' ) ;

		sType = 'url' ;
		GetE('txtUrl').value = sUrl ;
	}
	else					// It is another type of link.
	{
		sType = 'url' ;

		GetE('cmbLinkProtocol').value = '' ;
		GetE('txtUrl').value = sHRef ;
	}

	var fWidth  = (oLink.style.width  ? oLink.style.width  : oLink.width ) ;
	var fHeight = (oLink.style.height ? oLink.style.height : oLink.height ) ;

	// Get Advances Attributes
	GetE('txtAttId').value			= oLink.id ;
	GetE('txtAttName').value		= oLink.name ;

	if (fWidth.indexOf('%') >= 0)			// Percentual = %
	{
		fWidth = parseInt( fWidth.substr(0,fWidth.length - 1) ) ;
		document.getElementById('selWidthType').value = "percent" ;
	}
	else if (fWidth.indexOf('px') >= 0)		// Style Pixel = px
	{																										  //
		fWidth = fWidth.substr(0,fWidth.length - 2);
		document.getElementById('selWidthType').value = "pixels" ;
	}

	if (fHeight.indexOf('px') >= 0)		// Style Pixel = px
	{																										  //
		fHeight = fHeight.substr(0,fHeight.length - 2);
	}

	GetE('txtWidth').value		= fWidth ;
	GetE('txtHeight').value		= fHeight ;

	GetE('cmbScrolling').value		= GetAttribute( oLink, 'scrolling', 1 ) ; //oLink.scrolling ;
	GetE('cmbFrameborder').value	= GetAttribute( oLink, 'frameborder', 'auto' ) ;
	GetE('cmbAlign').value			= GetAttribute( oLink, 'align', 'left' ) ;

	if ( oEditor.FCKBrowserInfo.IsIE )
	{
		GetE('txtAttStyle').value	= oLink.style.cssText ;
	}
	else
	{
		GetE('txtAttStyle').value	= oLink.getAttribute('style',2) ;
	}
}

//#### Called while the user types the URL.
function OnUrlChange()
{
	var sUrl = GetE('txtUrl').value ;
	var sProtocol = oRegex.UrlOnChangeProtocol.exec( sUrl ) ;

	if ( sProtocol )
	{
		sUrl = sUrl.substr( sProtocol[0].length ) ;
		GetE('txtUrl').value = sUrl ;
		GetE('cmbLinkProtocol').value = sProtocol[0].toLowerCase() ;
	}
	else if ( oRegex.UrlOnChangeTestOther.test( sUrl ) )
	{
		GetE('cmbLinkProtocol').value = '' ;
	}
}

//#### The OK button was hit.
function Ok()
{
	var sUri ;
	var sAttributes ;

	sUri = GetE('txtUrl').value ;

	if ( sUri.length == 0 )
	{
		alert( FCKLang.DlnLnkMsgNoUrl ) ;
		return false ;
	}

	sUri = GetE('cmbLinkProtocol').value + sUri ;

	if ( oLink )	// Modifying an existent link.
	{
		//oEditor.FCKUndo.SaveUndoStep() ;
		//oLink.href = sUri ;
		SetAttribute( oLink, 'src'		, sUri ) ;

		// Advances Attributes
		SetAttribute( oLink, 'id'		, GetE('txtAttId').value ) ;
		SetAttribute( oLink, 'name'		, GetE('txtAttName').value ) ;		// No IE. Set but doesnt't update the outerHTML.

		SetAttribute( oLink, 'width'		, GetE('txtWidth').value + ( GetE('selWidthType').value == "percent" ? "%" : "") ) ;		// No IE. Set but doesnt't update the outerHTML.
		SetAttribute( oLink, 'height'		, GetE('txtHeight').value ) ;		// No IE. Set but doesnt't update the outerHTML.

		SetAttribute( oLink, 'scrolling' , GetE('cmbScrolling').value ) ;
		SetAttribute( oLink, 'frameborder' , GetE('cmbFrameborder').value ) ;
		SetAttribute( oLink, 'align' , GetE('cmbAlign').value ) ;

		if ( oEditor.FCKBrowserInfo.IsIE )
		{
			oLink.style.cssText = GetE('txtAttStyle').value ;
		}
		else
		{
			SetAttribute( oLink, 'style', GetE('txtAttStyle').value ) ;
		}
	}
	else			// Creating a new link.
	{
		sAttributes = " src=\"" + sUri + "\"";
		sAttributes += " id=\"" + GetE('txtAttId').value + "\"";
		sAttributes += " name=\"" + GetE('txtAttName').value + "\"";

		sAttributes += " width=\"" + GetE('txtWidth').value + ( GetE('selWidthType').value == "percent" ? "%" : "") + "\"";
		sAttributes += " height=\"" + GetE('txtHeight').value + "\"";

		sAttributes += " scrolling=\"" + GetE('cmbScrolling').value + "\"";
		sAttributes += " frameborder=\"" + GetE('cmbFrameborder').value + "\"";
		sAttributes += " align=\"" + GetE('cmbAlign').value + "\"";

		sAttributes += " style=\"" + GetE('txtAttStyle').value + "\"";

		oEditor.FCK.InsertHtml( "<iframe" + sAttributes + ">");
	}

	return true ;
}

function BrowseServer()
{
	// Set the browser window feature.
	var iWidth	= FCKConfig.LinkBrowserWindowWidth ;
	var iHeight	= FCKConfig.LinkBrowserWindowHeight ;

	var iLeft = (screen.width  - iWidth) / 2 ;
	var iTop  = (screen.height - iHeight) / 2 ;

	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
	sOptions += ",width=" + iWidth ;
	sOptions += ",height=" + iHeight ;
	sOptions += ",left=" + iLeft ;
	sOptions += ",top=" + iTop ;

	// Open the browser window.
	var oWindow = window.open( FCKConfig.LinkBrowserURL, "FCKBrowseWindow", sOptions ) ;
}

function SetUrl( url )
{
	document.getElementById('txtUrl').value = url ;
	OnUrlChange() ;
	window.parent.SetSelectedTab( 'Info' ) ;
}
