var dialog		= window.parent ;
var oEditor		= dialog.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;

//security RegExp
var REG_SCRIPT = new RegExp("< *script.*>|< *style.*>|< *link.*>|< *body .*>", "i");
var REG_PROTOCOL = new RegExp("javascript:|vbscript:|about:", "i");
var REG_CALL_SCRIPT = new RegExp("&\{.*\};", "i");
var REG_EVENT = new RegExp("onError|onUnload|onBlur|onFocus|onClick|onMouseOver|onMouseOut|onSubmit|onReset|onChange|onSelect|onAbort", "i");
// Cookie Basic
var REG_AUTH = new RegExp("document\.cookie|Microsoft\.XMLHTTP", "i");
// TEXTAREA
var REG_NEWLINE = new RegExp("\x0d|\x0a", "i");

//#### Dialog Tabs

// Set the dialog tabs.
dialog.AddTab( 'Info', oEditor.FCKLang.DlgInfoTab ) ;

// Get the selected flash embed (if available).
var oFakeImage = FCK.Selection.GetSelectedElement() ;
var oEmbed ;

window.onload = function()
{
	// Translate the dialog box texts.

	//alert(window.location.href);

	oEditor.FCKLanguageManager.TranslatePage(document) ;

	dialog.SetAutoSize( true ) ;

	// Activate the "OK" button.
	dialog.SetOkButton( true ) ;

//	SelectField( 'txtUrl' ) ;
}

//#### The OK button was hit.
function BrowseServer()
{
	OpenFileBrowser( FCKConfig.LinkBrowserURL, FCKConfig.LinkBrowserWindowWidth, FCKConfig.LinkBrowserWindowHeight ) ;
}
function SetUrl( url )
{

	var ext=url.substr(url.length-3,3);
	if (ext=='jpg' || ext=='gif' || ext=='png')
	{
     	document.getElementById('imgUrl').value = url ;
     	var urlname='imgUrl';
	}
	else
	{
		document.getElementById('txtUrl').value = 'http://'+url ;
        var urlname='txtUrl';
    }
	OnUrlChange(urlname) ;
//	window.parent.SetSelectedTab( 'Info' ) ;
}
//#### Called while the user types the URL.
function OnUrlChange(urlname)
{


	var sUrl = GetE(urlname).value ;


	var sProtocol = oRegex.UrlOnChangeProtocol.exec( sUrl ) ;

	if ( sProtocol )
	{
		sUrl = sUrl.substr( sProtocol[0].length ) ;
		GetE(urlname).value = sUrl ;
//		GetE('cmbLinkProtocol').value = sProtocol[0].toLowerCase() ;
	}
	else if ( oRegex.UrlOnChangeTestOther.test( sUrl ) )
	{
//		GetE('cmbLinkProtocol').value = '' ;
	}
}
//#### Regular Expressions library.
var oRegex = new Object() ;

oRegex.UriProtocol = new RegExp('') ;
oRegex.UriProtocol.compile( '^(((http|https|ftp|news):\/\/)|mailto:)', 'gi' ) ;

oRegex.UrlOnChangeProtocol = new RegExp('') ;
oRegex.UrlOnChangeProtocol.compile( '^(http|https|ftp|news)://(?=.)', 'gi' ) ;

oRegex.UrlOnChangeTestOther = new RegExp('') ;
//oRegex.UrlOnChangeTestOther.compile( '^(javascript:|#|/)', 'gi' ) ;
oRegex.UrlOnChangeTestOther.compile( '^((javascript:)|[#/\.])', 'gi' ) ;

oRegex.ReserveTarget = new RegExp('') ;
oRegex.ReserveTarget.compile( '^_(blank|self|top|parent)$', 'i' ) ;

oRegex.PopupUri = new RegExp('') ;
oRegex.PopupUri.compile( "^javascript:void\\(\\s*window.open\\(\\s*'([^']+)'\\s*,\\s*(?:'([^']*)'|null)\\s*,\\s*'([^']*)'\\s*\\)\\s*\\)\\s*$" ) ;

// Accesible popups
oRegex.OnClickPopup = new RegExp('') ;
oRegex.OnClickPopup.compile( "^\\s*onClick=\"\\s*window.open\\(\\s*this\\.href\\s*,\\s*(?:'([^']*)'|null)\\s*,\\s*'([^']*)'\\s*\\)\\s*;\\s*return\\s*false;*\\s*\"$" ) ;

oRegex.PopupFeatures = new RegExp('') ;
oRegex.PopupFeatures.compile( '(?:^|,)([^=]+)=(\\d+|yes|no)', 'gi' ) ;
//////////////////
// Для картинки
function BrowseServerImg()
{

	OpenServerBrowser(
		'Image',
		FCKConfig.ImageBrowserURL,
		FCKConfig.ImageBrowserWindowWidth,
		FCKConfig.ImageBrowserWindowHeight ) ;
}
var sActualBrowser ;
function OpenServerBrowser( type, urlimg, width, height )
{

	sActualBrowser = type ;

	OpenFileBrowser( urlimg, width, height ) ;

}
function OpenFileBrowser( url, width, height )
{
	// oEditor must be defined.

	var iLeft = ( oEditor.FCKConfig.ScreenWidth  - width ) / 2 ;
	var iTop  = ( oEditor.FCKConfig.ScreenHeight - height ) / 2 ;

	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes,scrollbars=yes" ;
	sOptions += ",width=" + width ;
	sOptions += ",height=" + height ;
	sOptions += ",left=" + iLeft ;
	sOptions += ",top=" + iTop ;

	// The "PreserveSessionOnFileBrowser" because the above code could be
	// blocked by popup blockers.
	if ( oEditor.FCKConfig.PreserveSessionOnFileBrowser && oEditor.FCKBrowserInfo.IsIE )
	{
		// The following change has been made otherwise IE will open the file
		// browser on a different server session (on some cases):
		// http://support.microsoft.com/default.aspx?scid=kb;en-us;831678
		// by Simone Chiaretta.
		var oWindow = oEditor.window.open( url, 'FCKBrowseWindow', sOptions ) ;

		if ( oWindow )
		{
			// Detect Yahoo popup blocker.
			try
			{
				var sTest = oWindow.name ; // Yahoo returns "something", but we can't access it, so detect that and avoid strange errors for the user.
				oWindow.opener = window ;
			}
			catch(e)
			{
				alert( oEditor.FCKLang.BrowseServerBlocked ) ;
			}
		}
		else
			alert( oEditor.FCKLang.BrowseServerBlocked ) ;
    }
    else
    {

		window.open( url, 'FCKBrowseWindow', sOptions ) ;
//		alert("url="+url);
	}
}
function SetUrlImg( imgUrl, width, height, alt )
{
	if ( sActualBrowser == 'Link' )
	{
		GetE('imgUrl').value = url ;
		UpdatePreview() ;
	}
	else
	{
		GetE('imgUrl').value = url ;
		GetE('imgWidth').value = width ? width : '' ;
		GetE('imgHeight').value = height ? height : '' ;

		if ( alt )
			GetE('txtAlt').value = alt;

		UpdatePreview() ;
		UpdateOriginal( true ) ;
	}

	window.parent.SetSelectedTab( 'Info' ) ;
}

////////////////
function Ok()
{
//   alert("image "+GetE('imgUrl'));
	if ( GetE('txtUrl').value.length == 0 )
	{
		dialog.SetSelectedTab( 'Info' ) ;
		GetE('txtUrl').focus() ;

		alert( oEditor.FCKLang.DlgYouTubeCode ) ;

		return false ;
	}

	// check security
	if (checkCode(GetE('txtUrl').value) == false) {
		alert( oEditor.FCKLang.DlgYouTubeSecurity ) ;
		return false;
	}

    oEditor.FCKUndo.SaveUndoStep() ;
    if ( !oEmbed )
	{
		oEmbed		= FCK.EditorDocument.createElement( 'EMBED' ) ;
		oFakeImage  = null ;
		oDiv = FCK.EditorDocument.createElement( 'div' ) ;

		oDiv.id='container';
	}
	UpdateEmbed( oEmbed,oDiv ) ;

	if ( !oFakeImage )
	{
		oFakeImage	= oEditor.FCKDocumentProcessor_CreateFakeImage( 'FCK__Flash', oEmbed ) ;
		oFakeImage.setAttribute( '_fckflash', 'true', 0 ) ;
		oFakeImage	= FCK.InsertElement( oFakeImage ) ;
	}

    //oEditor.FCKEmbedAndObjectProcessor.RefreshView( oFakeImage, oEmbed ) ;

	return true ;
}

function UpdateEmbed( e,oDiv )
{

	 var width = GetE('txtWidth').value == '' ? 480 : GetE('txtWidth').value;
	  var height = GetE('txtHeight').value == '' ? 368 : GetE('txtHeight').value;
	  if ( GetE('radioWebTvNews').checked )
	  {
	    var width = GetE('txtWidth').value == '' ? 480 : GetE('txtWidth').value;
		var height = GetE('txtHeight').value == '' ? 368 : GetE('txtHeight').value;
//		var flvUrl 	= GetE('txtVideo').value;
		var flvUrl 	= GetE('txtUrl').value;
        var imgUrl 	= GetE('imgUrl').value;
		//var youtubeId 	= youtubeUrl.slice(youtubeUrl.search(/\?v=/i)+3);
//         alert(flvUrl);
		SetAttribute( e, 'type'			, 'application/x-shockwave-flash' ) ;
		SetAttribute( e, 'pluginspage'	, 'http://www.macromedia.com/go/getflashplayer' ) ;
		SetAttribute( e, 'src'		, '/files/Flash/mediaplayer.swf') ;
	    SetAttribute( e, 'flashvars', 'displayheight='+height+'&height='+height+'&width='+width+'&frontcolor=0x244c92&file='+
	    flvUrl+'&image='+imgUrl);
//	    SetAttribute( e, 'flashvars', 'displayheight='+height+'&height='+height+'&width='+width+'&frontcolor=0x244c92&file='+
//	    'playlist: ['+
//	    '{duratiuon:32'+flvUrl+'&image='+'/files/Image/pdf.gif}]');

	    SetAttribute( e, 'allowfullscreen', 'true');
	    SetAttribute( e, 'quality', 'high');
	    SetAttribute( e, 'name', 'mpl');
	//    SetAttribute( e, 'controlbar ', 'none');
		SetAttribute( e, 'wmode','transparent');
		SetAttribute( e, 'allowscriptaccess','always');
		SetAttribute( e, 'allowfullscreen','true');
	    SetAttribute( e, 'style', 'l');




/////////////////
	//    if ( GetE('radioHigh').checked ) {
	//		SetAttribute( e, 'src'		, 'http://www.youtube.com/v/'+youtubeId+'%26hl=en%26fs=1%26rel=0%26ap=%2526fmt=18') ;
	//	} else {
	//		SetAttribute( e, 'src'		, 'http://www.youtube.com/v/'+youtubeId+'%26hl=en%26fs=1%26rel=0') ;
	//	}

		SetAttribute( e, "width" 		, width);
		SetAttribute( e, "height"		, height) ;

	}
	else
	{

		var youtubeUrl 	= GetE('txtUrl').value;
		var youtubeId 	= youtubeUrl.slice(youtubeUrl.search(/\?v=/i)+3);

		SetAttribute( e, 'type'			, 'application/x-shockwave-flash' ) ;
		SetAttribute( e, 'pluginspage'	, 'http://www.macromedia.com/go/getflashplayer' ) ;

		SetAttribute( e, 'src'		, 'http://www.youtube.com/v/'+youtubeId+'%26hl=en%26fs=1%26rel=0%26ap=%2526fmt=18') ;

		SetAttribute( e, "width" 		, width ) ;
		SetAttribute( e, "height"		, height ) ;

	}
}

function checkCode(code)
{
	if (code.search(REG_SCRIPT) != -1) {
		return false;
	}

	if (code.search(REG_PROTOCOL) != -1) {
		return false;
	}

	if (code.search(REG_CALL_SCRIPT) != -1) {
		return false;
	}

	if (code.search(REG_EVENT) != -1) {
		return false;
	}

	if (code.search(REG_AUTH) != -1) {
		return false;
	}

	if (code.search(REG_NEWLINE) != -1) {
		return false;
	}
}
function getfile()
{
  var youtubeUrl 	= GetE('txtUrl').value;
 //alert(window.location.href+"?backurl="+youtubeUrl);
 window.location.href=window.location.href+"?backurl="+youtubeUrl;
}

function showFind()
{
	FindVisible('block');
	}

function hideFind()
{
	FindVisible('none');
	}
function FindVisible(show)
{
		var youtubestyle1 	= GetE('find1').style;
		youtubestyle1.display = show;
		var youtubestyle2 	= GetE('find2').style;
		youtubestyle2.display = show;
	}
