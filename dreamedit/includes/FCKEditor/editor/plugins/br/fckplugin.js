var MyFCKCommand = function()
{

}

MyFCKCommand.prototype.Execute = function()
{
    FCK.InsertHtml('<br />');
}
MyFCKCommand.prototype.GetState = function()
{
    return FCK_TRISTATE_OFF; 
}

//var oCMSLinksItem = new FCKToolbarButton( 'CMSLinks', FCKLang.CMSLinksBtn, FCKLang.CMSLinksBtn, null, false, true ); 
FCKCommands.RegisterCommand('BR', new MyFCKCommand());

//var oBrButton = new FCKToolbarButton( "BR", "BR", "BR", FCK_TOOLBARITEM_ONLYTEXT, false, false );
var oBrButton = new FCKToolbarButton( "BR", "BR", "BR", FCK_TOOLBARITEM_ONLYTEXT, false, false, false );

FCKToolbarItems.RegisterItem('BR', oBrButton);