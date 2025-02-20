FCKCommands.RegisterCommand(
	'CMSNEWS',
	new FCKDialogCommand(
		'CMSNEWS',
		FCKLang.CMSNEWSDlgTitle,
		FCKPlugins.Items['CMSNEWS'].Path + 'fck_cmslinks.php',
		700,
		760
	)
);

var oCMSNEWSItem = new FCKToolbarButton( 'CMSNEWS', FCKLang.CMSNEWSBtn, FCKLang.CMSNEWSBtn, null, false, true );
oCMSNEWSItem.IconPath = FCKConfig.PluginsPath + 'CMSNEWS/cmsNEWS.gif';

FCKToolbarItems.RegisterItem('CMSNEWS', oCMSNEWSItem);