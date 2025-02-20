<?
include dirname(__FILE__)."/../../../../_include.php";


$pg = new Pages();
$tabs = $pg->getChilds($pg->getRootPageId());
$tabs[] = array("page_id" => "0", "page_name" => "Страницы сайта");
$first = array_shift($tabs);
array_unshift($tabs, $first);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!--
* File Name: fck_cmslinks.php
* 	Plugin to insert links from CMS "DreamEdit"
*
* File Authors:
* 		Willfred di Vampo (divampo@gmail.com)
-->

<html>
	<head>
		<!--title>CMS Links - Made Simple CMS Link</title-->
		<meta http-equiv="Content-Type" content="text/html; charset=cp1251">
		<meta content="noindex, nofollow" name="robots">
		<script src="https://<?=$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."includes/dTree/dtree.js"?>" type="text/javascript"></script>

		<script type="text/javascript">


            window.onload = function()
            {
                // Translate the dialog box texts.
//			oEditor.FCKLanguageManager.TranslatePage(document) ;

                // Show the initial dialog content.
                //document.getElementById('div<?=$first["page_id"]?>').style.display = '' ;

                var oldCookie = Get_Cookie( "deLastIdTree" );
                if(oldCookie)
                    document.getElementById("selector").options[oldCookie].selected = true;

                // Activate the "OK" button.
                //window.parent.SetOkButton( true ) ;

            };

            function Set_Cookie( name, value, expires, path, domain, secure )
            {
                // set time, it's in milliseconds
                var today = new Date();
                today.setTime( today.getTime() );

                if ( expires )
                {
                    expires = expires * 1000 * 60;
                }
                var expires_date = new Date( today.getTime() + (expires) );

                document.cookie = name + "=" +escape( value ) +
                    ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
                    ( ( path ) ? ";path=" + path : "" ) +
                    ( ( domain ) ? ";domain=" + domain : "" ) +
                    ( ( secure ) ? ";secure" : "" );
            }

            // this function gets the cookie, if it exists
            function Get_Cookie( name ) {

                var start = document.cookie.indexOf( name + "=" );
                var len = start + name.length + 1;
                if ( ( !start ) &&
                    ( name != document.cookie.substring( 0, name.length ) ) )
                {
                    return null;
                }
                if ( start == -1 ) return null;
                var end = document.cookie.indexOf( ";", len );
                if ( end == -1 ) end = document.cookie.length;

                return unescape( document.cookie.substring( len, end ) );
            }

            // что происходит при выборе той или иной ссылки
            function onLinkSelect(obj)
            {
                if(obj.tagName == "SELECT")
                {
                    document.getElementById('linkID').value  = obj[obj.selectedIndex].value;
                }
                else
                {

                }
            }

            function selChange(obj)
            {
                <?
                foreach($tabs as $v)
                    echo "document.getElementById('div".$v["page_id"]."').style.display = 'none' ;\n";
                ?>
                document.getElementById(obj.options[obj.selectedIndex].value).style.display = '' ;

                Set_Cookie( "deLastIdTree", obj.selectedIndex, "60" ) ;
            }

            function treeSelect(setPageId)
            {
                var dialog = parent.CKEDITOR.dialog.getCurrent();

                dialog.setValueOf("tab-basic","link_id",setPageId);
            }

		</script>
		<style type="text/css">
			.pages {
				BACKGROUND: #ffffff;
				BORDER: 1px solid #a7a7a7;
				WIDTH: 556px;
				HEIGHT: 243px;
				PADDING: 5px;
				OVERFLOW: auto;
			}
			HTML>body .pages {
				WIDTH: 504px;
				HEIGHT: 231px;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="https://<?=$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"]."includes/dTree/dtree.css"?>" />
	</head>

	<body scroll="no" style="overflow:hidden;">
	<table height="100%" cellSpacing="0" cellPadding="0" width="100%" border="0">
		<tr>
			<td>
				<table width="100%">
					<tr>

						<td colspan="2"><span fckLang="DlgCMSLinksObjectSelection">Выберите страницу:</span>&nbsp;</td>
					</tr>
                    <tr>
                        <td colspan="2">
                            <?
                            $treePages = Dreamedit::createTreeArrayFromPages($pg->getPages(), "javascript:treeSelect(\'{ID}\'); ");
                            ?>

                                <div class="pages" id="div0" >
                                    <?
                                    $pg = new Pages();
                                    $tree = new WriteTree("d0", $treePages);
                                    $tree->setTreeConfig("imgPath", "https://".$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/");
                                    $tree->displayTree(Dreamedit::translate("Страницы сайта"), 0);

                                    $openTo = $pg->getRootPageId();
                                    $tree->openTreeTo($openTo["page_id"], false);
                                    ?>
                                </div>


                        </td>
                    </tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	</body>
</html>