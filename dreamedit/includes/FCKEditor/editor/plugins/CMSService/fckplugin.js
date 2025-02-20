FCKCommands.RegisterCommand(
	'CMSService',
	new FCKDialogCommand(
		'CMSService',
		FCKLang.CMSSericeDlgTitle,
		FCKPlugins.Items['CMSService'].Path + 'fck_cmslinks.php',
		700,
		760
	)
);

var oCMSServiceItem = new FCKToolbarButton( 'CMSService', FCKLang.CMSServiceBtn, FCKLang.CMSServiceBtn, null, false, true );
oCMSServiceItem.IconPath = FCKConfig.PluginsPath + 'CMSService/cmsuslugi.png';

FCKToolbarItems.RegisterItem('CMSService', oCMSServiceItem);