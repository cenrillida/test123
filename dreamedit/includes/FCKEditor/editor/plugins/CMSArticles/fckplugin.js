FCKCommands.RegisterCommand(
	'CMSArticles',
	new FCKDialogCommand(
		'CMSArticles',
		FCKLang.CMSArticlesDlgTitle,
		FCKPlugins.Items['CMSArticles'].Path + 'fck_cmslinks.php',
		700,
		760
	)
);

var oCMSArticlesItem = new FCKToolbarButton( 'CMSArticles', FCKLang.CMSArticlesBtn, FCKLang.CMSArticlesBtn, null, false, true );
oCMSArticlesItem.IconPath = FCKConfig.PluginsPath + 'CMSArticles/cmsarticles.gif';

FCKToolbarItems.RegisterItem('CMSArticles', oCMSArticlesItem);