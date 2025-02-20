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
		FCKLang.CMSLinksDlgTitle,
		FCKPlugins.Items['CMSLinks'].Path + 'fck_cmslinks.php',
		600,
		700
	)
);
 
// Create the "CMSLinks" toolbar button.
// FCKToolbarButton( commandName, label, tooltip, style, sourceView, contextSensitive )
var oCMSLinksItem = new FCKToolbarButton( 'CMSLinks', FCKLang.CMSLinksBtn, FCKLang.CMSLinksBtn, null, false, true ); 
oCMSLinksItem.IconPath = FCKPlugins.Items['CMSLinks'].Path + 'cmslinks.gif'; 

// 'CMSLinks' is the name that is used in the toolbar config.
FCKToolbarItems.RegisterItem( 'CMSLinks', oCMSLinksItem );