/*******************************************
* File Name: fckplugin.js
* 	Plugin to expanded clearning of html
* 
* File Authors:
* 		Willfred di Vampo (divampo@gmail.com)
********************************************/

// Register the related commands.
FCKCommands.RegisterCommand( 
	'CleanTags',
	new FCKDialogCommand( 
		'CleanTags',
		FCKLang.CleanTagsTitle,
		FCKPlugins.Items['CleanTags'].Path + 'CleanTagsConfig.html',
		450, 
		485 
	) 
) ;

// Create the "CleanTags" toolbar button.
// FCKToolbarButton( commandName, label, tooltip, style, sourceView, contextSensitive )
var oCleanTags = new FCKToolbarButton( 'CleanTags', FCKLang.CleanTagsBtn ) ;
oCleanTags.IconPath = FCKPlugins.Items['CleanTags'].Path + 'CleanTags.gif' ;

// 'CMSLinks' is the name that is used in the toolbar config.
FCKToolbarItems.RegisterItem( 'CleanTags', oCleanTags ) ;




