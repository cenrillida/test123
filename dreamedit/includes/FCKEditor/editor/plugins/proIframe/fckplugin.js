// Register the related commands.
FCKCommands.RegisterCommand('proIframe', new FCKDialogCommand( FCKLang['DlgProIframeTitle'], FCKLang['DlgProIframeTitle'], FCKConfig.PluginsPath + 'proIframe/proIframe.html'	, 370, 300 ) ) ;

// Create the "proIframe" toolbar button.
var oproIframe		= new FCKToolbarButton( 'proIframe', FCKLang['DlgProIframeTitle'] ) ;
oproIframe.IconPath	= FCKConfig.PluginsPath + 'proIframe/proIframe.gif' ;

FCKToolbarItems.RegisterItem( 'proIframe', oproIframe ) ;	// 'proIframe' is the name used in the Toolbar config.
