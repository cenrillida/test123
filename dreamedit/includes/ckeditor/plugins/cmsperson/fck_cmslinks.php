<?
include dirname(__FILE__)."/../../../../_include.php";


$pg = new Pages();
//$tabs = $pg->getChilds(49);
foreach($pg->getChilds(65) as $v1)
{
    $tabs[] = array("page_id" => $v1["page_id"], "page_name" => $v1["page_name"]);
    foreach($pg->getChilds($v1["page_id"]) as $v2)
    {
        $tabs[] = array("page_id" => $v2["page_id"], "page_name" => "...".$v2["page_name"]);
        foreach($pg->getChilds($v2["page_id"]) as $v3)
        {
            $tabs[] = array("page_id" => $v3["page_id"], "page_name" => "......".$v3["page_name"]);
            foreach($pg->getChilds($v3["page_id"]) as $v4)
            {
                $tabs[] = array("page_id" => $v4["page_id"], "page_name" => ".........".$v4["page_name"]);
            }
        }
    }
}
$tabs[] = array("page_id" => "65", "page_name" => "������� �����");
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


        function goto (alf) {

            var hr=location.href;

            setCookie("bukva",alf);
            location.href=hr;


        }
        // Cookies
        function setCookie(name, value, expires, path, domain, secure) {
            var curCookie = name + "=" + escape(value) +
                ((expires) ? "; expires=" + expires.toGMTString() : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");

            document.cookie = curCookie;


        }

        function treeSelect(setPageLink, setPageTitle, setPersonOtdel, setPersonContact, setPersonDolj,setPersonUS, setPicBig,setPicSmall,setPersonUZ, setRAN, setEn)
        {

            var dialog = parent.CKEDITOR.dialog.getCurrent();

            dialog.setValueOf("tab-basic","link_text",setPageTitle);
            dialog.setValueOf("tab-basic","link_url","/index.php?page_id=555&id=" + setPageLink);

            /*this.className = "nodeSel";

            if (document.getElementById('chkEn').checked==false)
                GetE('linkURL').value = "/index.php?page_id=555&id=" + setPageLink;
            else
                GetE('linkURL').value = "/en/index.php?page_id=555&id=" + setPageLink;

            GetE('chkSmallPhoto').value = "/dreamedit/foto/" + setPicSmall;
            GetE('chkBigPhoto').value = "/dreamedit/foto/" + setPicBig;

            if(!titleIsSet)
                GetE('linkText').value = setPageTitle;

            GetE('linkOtdel').value = setPersonOtdel;
            GetE('linkContact').value = setPersonContact;
            GetE('linkDolj').value = setPersonDolj;
            GetE('linkUSZ').value = setRAN + ' ' + setPersonUS + ' '+ setPersonUZ + ' ';*/


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

                    <td colspan="2"><span fckLang="DlgCMSLinksObjectSelection">������� ���������� �:</span>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <!-- ���� ������ - �������� ����� -->
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo ord(�);?>')">� </a>&nbsp;
                        <a href="javascript:goto('<? echo (AZ);?>')">A..Z</a>&nbsp;
                        <br /><br />
                        <?
                        global $DB;

                        if (empty($_COOKIE[bukva]))
                        {
                            $bukva="�";
                        }
                        else
                        {
                            if ($_COOKIE[bukva]!="AZ") $bukva=chr($_COOKIE[bukva]);
                            else $bukva="AZ";
                        }
                        //$treePages = Dreamedit::createTreeArrayFromPersons($persons->getPersons(), "javascript:treeSelect(\'{URL}\', \'{PAGE_NAME}\'); ");
                        foreach($tabs as $v)
                        {?>

                            <div class="pages" id="div<?=$v["page_id"]?>">
                                <?
                                $persons = new Persons();
                                $p2podr = $persons->getPersonsAll($bukva);

                                //									$p2podr=$DB->select("SELECT surname FROM isras2008.persona WHERE substring(surname,1,1)= '".$bukva."' ORDER BY surname,name,fname");
                                //									print_r($p2podr);
                                $tree = new WriteTree("tree".$v["page_id"], null);
                                $tree->displayFlatTreeAlf("����������",$_CONFIG["global"]["paths"]["site"].$_CONFIG["global"]["paths"]["admin_dir"].$_CONFIG["global"]["paths"]["skin_path"]."/images/dTree/",$p2podr);
                                ?>
                            </div>

                            <?
                        }
                        ?>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
</body>
</html>