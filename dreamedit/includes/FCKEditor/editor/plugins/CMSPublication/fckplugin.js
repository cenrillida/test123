FCKCommands.RegisterCommand(
	'CMSPublication',
	new FCKDialogCommand(
		'CMSPublication',
		FCKLang.CMSPublicationDlgTitle,
		FCKPlugins.Items['CMSPublication'].Path + 'fck_cmslinks.php',
		700,
		760
	)
);

var oCMSPublicationItem = new FCKToolbarButton( 'CMSPublication', FCKLang.CMSPublicationBtn, FCKLang.CMSPublicationBtn, null, false, true );
oCMSPublicationItem.IconPath = FCKConfig.PluginsPath + 'CMSPublication/cmspublication.gif';

FCKToolbarItems.RegisterItem('CMSPublication', oCMSPublicationItem);