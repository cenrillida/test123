FCKCommands.RegisterCommand(
	'CMSPerson',
	new FCKDialogCommand(
		'CMSPerson',
		FCKLang.CMSPersonDlgTitle,
		FCKPlugins.Items['CMSPerson'].Path + 'fck_cmslinks.php',
		700,
		760
	)
);

var oCMSPersonItem = new FCKToolbarButton( 'CMSPerson', FCKLang.CMSPersonBtn, FCKLang.CMSPersonBtn, null, false, true );
oCMSPersonItem.IconPath = FCKConfig.PluginsPath + 'CMSPerson/cmsperson.gif';

FCKToolbarItems.RegisterItem('CMSPerson', oCMSPersonItem);