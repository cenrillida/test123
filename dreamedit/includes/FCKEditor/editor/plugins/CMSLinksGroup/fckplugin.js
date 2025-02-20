/*******************************************
* File Name: fckplugin.js
* 	Plugin to insert links from CMS "DreamEdit"
*
* File Authors:
* 		Willfred di Vampo (divampo@gmail.com)
********************************************/

// Register the related commands.
FCKCommands.RegisterCommand(
	'CMSLinks',
	new FCKDialogCommand(
		'CMSLinks',
		FCKLang.CMSPersonDlgTitle,
		FCKPlugins.Items['CMSLinksGroup'].Path + 'fck_cmslinks.php',
		600,
		560
	)
);

// Create the "CMSLinks" toolbar button.
// FCKToolbarButton( commandName, label, tooltip, style, sourceView, contextSensitive )
var oCMSLinksItem = new FCKToolbarButton( 'CMSLinks', FCKLang.CMSLinksBtn, FCKLang.CMSLinksBtn, null, false, true );
oCMSLinksItem.IconPath = FCKConfig.PluginsPath + 'CMSLinksGroup/cmslinks.gif';

// 'CMSLinks' is the name that is used in the toolbar config.
FCKToolbarItems.RegisterItem( 'CMSLinks', oCMSLinksItem );