/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	//config.language = 'ru';
	// config.uiColor = '#AADC6E';
    config.allowedContent = true;
    config.extraPlugins = 'autogrow,cmsperson,cmslinks,cleantags,citefooter,indentt,indenttext,ckeditorfa,customlinks';
    config.autoGrow_minHeight = 50;
    config.autoGrow_maxHeight = 99999;
    config.autoGrow_onStartup = true;
    config.autoGrow_bottomSpace = 15;
    //config.contentsCss = [ '/newsite/css/bootstrap.min.css', '/newsite/css/product.css', '/newsite/css/ck_additional.css','https://use.fontawesome.com/releases/v5.8.1/css/all.css'];
    //config.extraPlugins = 'N1ED'; //in future for inline editing

};
CKEDITOR.dtd.$removeEmpty['i'] = false;