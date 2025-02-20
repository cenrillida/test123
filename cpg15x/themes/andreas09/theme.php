<?php
/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2006 Coppermine Dev Team
  v1.1 originally written by Gregory DEMAR

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  ********************************************
  Coppermine version: 1.4.4
  $Source:
  $Revision:
  $Author:
  $Date:
**********************************************/

/*
Ported to Coppermine Photo Gallery by Billy Bullock - Oct. 2, 2006 : Last Update - Oct. 7, 2006
Porter URL: http://www.billygbullock.com
Coppermine Theme Version: 1.1

Ported to cpg1.5.x by eenemeenemuu
*/

define('THEME_HAS_NAVBAR_GRAPHICS', 1);
define('THEME_HAS_FILM_STRIP_GRAPHIC', 1);
define('THEME_IS_XHTML10_TRANSITIONAL',1); // Remove this if you edit this template until
                                           // you have validated it. See docs/theme.htm.
define('THEME_HAS_NO_SUB_MENU_BUTTONS', 1);

$CONFIG['max_film_strip_items'] = 4; //overrides the number of thumbnails set in the admin configuration
$CONFIG['thumbcols'] = 4; //overrides the number of columns for thumbnails set in the admin configuration


// HTML template for sys menu
$template_sys_menu = <<<EOT
                                        <ul class="level1">

<!-- BEGIN home -->
                                                <li><a href="{HOME_TGT}" title="{HOME_TITLE}">{HOME_LNK}</a></li>
<!-- END home -->
<!-- BEGIN my_gallery -->
                                                <li><a href="{MY_GAL_TGT}" title="{MY_GAL_TITLE}">{MY_GAL_LNK}</a></li>
<!-- END my_gallery -->
<!-- BEGIN allow_memberlist -->
                                                <li><a href="{MEMBERLIST_TGT}" title="{MEMBERLIST_TITLE}">{MEMBERLIST_LNK}</a></li>
<!-- END allow_memberlist -->
<!-- BEGIN my_profile -->
                                                <li><a href="{MY_PROF_TGT}" title="{MY_PROF_LNK}">{MY_PROF_LNK}</a></li>
<!-- END my_profile -->
<!-- BEGIN enter_admin_mode -->
                                                <li><a href="{ADM_MODE_TGT}" title="{ADM_MODE_TITLE}">{ADM_MODE_LNK}</a></li>
<!-- END enter_admin_mode -->
<!-- BEGIN leave_admin_mode -->
                                                <li><a href="{USR_MODE_TGT}" title="{USR_MODE_TITLE}">{USR_MODE_LNK}</a></li>
<!-- END leave_admin_mode -->
<!-- BEGIN contact -->
                                                <li><a href="{CONTACT_TGT}" title="{CONTACT_TITLE}">{CONTACT_LNK}</a></li>
<!-- END contact --> 
<!-- BEGIN sidebar -->
                                                <li><a href="{SIDEBAR_TGT}" title="{SIDEBAR_TITLE}">{SIDEBAR_LNK}</a></li>
<!-- END sidebar -->
<!-- BEGIN upload_pic -->
                                                <li><a href="{UPL_PIC_TGT}" title="{UPL_PIC_TITLE}">{UPL_PIC_LNK}</a></li>
<!-- END upload_pic -->
<!-- BEGIN register -->
                                                <li><a href="{REGISTER_TGT}" title="{REGISTER_TITLE}">{REGISTER_LNK}</a></li>
<!-- END register -->
<!-- BEGIN login -->
                                                <li><a href="{LOGIN_TGT}" title="{LOGIN_LNK}">{LOGIN_LNK}</a></li>
<!-- END login -->
<!-- BEGIN logout -->
                                                <li><a href="{LOGOUT_TGT}" title="{LOGOUT_LNK}">{LOGOUT_LNK}</a></li>
<!-- END logout -->
                                        </ul>

EOT;


// HTML template for sub menu
$template_sub_menu = <<<EOT
                                        <ul>
<!-- BEGIN custom_link -->
                                            <li><a href="{CUSTOM_LNK_TGT}" title="{CUSTOM_LNK_TITLE}">{CUSTOM_LNK_LNK}</a></li>
<!-- END custom_link -->
<!-- BEGIN album_list -->
                                            <li><a href="{ALB_LIST_TGT}" title="{ALB_LIST_TITLE}">{ALB_LIST_LNK}</a></li>
<!-- END album_list -->
                                            <li><a href="{LASTUP_TGT}" title="{LASTUP_LNK}">{LASTUP_LNK}</a></li>
                                            <li><a href="{LASTCOM_TGT}" title="{LASTCOM_LNK}">{LASTCOM_LNK}</a></li>
                                            <li><a href="{TOPN_TGT}" title="{TOPN_LNK}">{TOPN_LNK}</a></li>
                                            <li><a href="{TOPRATED_TGT}" title="{TOPRATED_LNK}">{TOPRATED_LNK}</a></li>
                                            <li><a href="{FAV_TGT}" title="{FAV_LNK}">{FAV_LNK}</a></li>
                                            <li><a href="{SEARCH_TGT}" title="{SEARCH_LNK}">{SEARCH_LNK}</a></li>
                                        </ul>

EOT;

// HTML template for gallery admin menu
$template_gallery_admin_menu = <<<EOT

        <ul class="level1">
            <!-- BEGIN admin_approval -->
                <li><a href="editpics.php?mode=upload_approval" title="{UPL_APP_TITLE}">{UPL_APP_ICO}{UPL_APP_LNK}</a></li>
            <!-- END admin_approval -->
            <!-- BEGIN config -->
                <li><a href="admin.php" title="{ADMIN_TITLE}">{ADMIN_ICO}{ADMIN_LNK}</a></li>
            <!-- END config -->
            <!-- BEGIN catmgr -->
                <li><a href="catmgr.php" title="{CATEGORIES_TITLE}">{CATEGORIES_ICO}{CATEGORIES_LNK}</a></li>
            <!-- END catmgr -->
            <!-- BEGIN albmgr -->
                <li><a href="albmgr.php{CATL}" title="{ALBUMS_TITLE}">{ALBUMS_ICO}{ALBUMS_LNK}</a></li>
            <!-- END albmgr -->
            <!-- BEGIN picmgr -->
                <li><a href="picmgr.php" title="{PICTURES_TITLE}">{PICTURES_ICO}{PICTURES_LNK}</a></li>
            <!-- end picmgr -->
            <!-- BEGIN groupmgr -->
                <li><a href="groupmgr.php" title="{GROUPS_TITLE}">{GROUPS_ICO}{GROUPS_LNK}</a></li>
            <!-- END groupmgr -->
            <!-- BEGIN usermgr -->
                <li><a href="usermgr.php" title="{USERS_TITLE}">{USERS_ICO}{USERS_LNK}</a></li>
            <!-- END usermgr -->
            <!-- BEGIN banmgr -->
                <li><a href="banning.php" title="{BAN_TITLE}">{BAN_ICO}{BAN_LNK}</a></li>
            <!-- END banmgr -->
            <!-- BEGIN admin_profile -->
                <li><a href="profile.php?op=edit_profile" title="{MY_PROF_TITLE}">{MY_PROF_ICO}{MY_PROF_LNK}</a></li>
            <!-- END admin_profile -->
            <!-- BEGIN review_comments -->
                <li><a href="reviewcom.php" title="{COMMENTS_TITLE}">{COMMENTS_ICO}{COMMENTS_LNK}</a></li>
            <!-- END review_comments -->
            <!-- BEGIN log_ecards -->
                <li><a href="db_ecard.php" title="{DB_ECARD_TITLE}">{DB_ECARD_ICO}{DB_ECARD_LNK}</a></li>
            <!-- END log_ecards -->
            <!-- BEGIN batch_add -->
                <li><a href="searchnew.php" title="{SEARCHNEW_TITLE}">{SEARCHNEW_ICO}{SEARCHNEW_LNK}</a></li>
            <!-- END batch_add -->
            <!-- BEGIN admin_tools -->
                <li><a href="util.php?t={TIME_STAMP}#admin_tools" title="{UTIL_TITLE}">{UTIL_ICO}{UTIL_LNK}</a></li>
            <!-- END admin_tools -->
            <!-- BEGIN keyword_manager -->
                <li><a href="keywordmgr.php" title="{KEYWORDMGR_TITLE}">{KEYWORDMGR_ICO}{KEYWORDMGR_LNK}</a></li>
            <!-- END keyword_manager -->
            <!-- BEGIN exif_manager -->
                <li><a href="exifmgr.php" title="{EXIFMGR_TITLE}">{EXIFMGR_ICO}{EXIFMGR_LNK}</a></li>
            <!-- END exif_manager -->
            <!-- BEGIN plugin_manager -->
                <li><a href="pluginmgr.php" title="{PLUGINMGR_TITLE}">{PLUGINMGR_ICO}{PLUGINMGR_LNK}</a></li>
            <!-- END plugin_manager -->
            <!-- BEGIN bridge_manager -->
                <li><a href="bridgemgr.php" title="{BRIDGEMGR_TITLE}">{BRIDGEMGR_ICO}{BRIDGEMGR_LNK}</a></li>
            <!-- END bridge_manager -->
            <!-- BEGIN view_log_files -->
                <li><a href="viewlog.php" title="{VIEW_LOG_FILES_TITLE}">{VIEW_LOG_FILES_ICO}{VIEW_LOG_FILES_LNK}</a></li>
            <!-- END view_log_files -->
            <!-- BEGIN overall_stats -->
                <li><a href="stat_details.php?type=hits&amp;sort=sdate&amp;dir=&amp;sdate=1&amp;ip=1&amp;search_phrase=0&amp;referer=0&amp;browser=1&amp;os=1&amp;mode=fullscreen&amp;page=1&amp;amount=50" title="{OVERALL_STATS_TITLE}">{OVERALL_STATS_ICO}{OVERALL_STATS_LNK}</a></li>
            <!-- END overall_stats -->
            <!-- BEGIN check_versions -->
                <li><a href="versioncheck.php" title="{CHECK_VERSIONS_TITLE}">{CHECK_VERSIONS_ICO}{CHECK_VERSIONS_LNK}</a></li>
            <!-- END check_versions -->
            <!-- BEGIN update_database -->
                <li><a href="update.php" title="{UPDATE_DATABASE_TITLE}">{UPDATE_DATABASE_ICO}{UPDATE_DATABASE_LNK}</a></li>
            <!-- END update_database -->
            <!-- BEGIN php_info -->
                <li><a href="phpinfo.php" title="{PHPINFO_TITLE}">{PHPINFO_ICO}{PHPINFO_LNK}</a></li>
            <!-- END php_info -->
            <!-- BEGIN show_news -->
                <li><a href="mode.php?what=news&amp;referer=$REFERER" title="{SHOWNEWS_TITLE}">{SHOWNEWS_ICO}{SHOWNEWS_LNK}</a></li>
            <!-- END show_news -->
            <!-- BEGIN documentation -->
                <li><a href="{DOCUMENTATION_HREF}" title="{DOCUMENTATION_TITLE}">{DOCUMENTATION_ICO}{DOCUMENTATION_LNK}</a></li>
            <!-- END documentation -->
        </ul>

EOT;

// HTML template for user admin menu
$template_user_admin_menu = <<<EOT

                        <ul>
                                <li><a href="albmgr.php" title="{ALBMGR_TITLE}" class="navmenu">{ALBMGR_LNK}</a></li>
                                <li><a href="modifyalb.php" title="{MODIFYALB_TITLE}" class="navmenu">{MODIFYALB_LNK}</a></li>
                                <li><a href="profile.php?op=edit_profile" title="{MY_PROF_TITLE}" class="navmenu">{MY_PROF_LNK}</a></li>
                                <li><a href="picmgr.php" title="{PICTURES_TITLE}" class="navmenu">{PICTURES_LNK}</a></li>
                        </ul>

EOT;

// HTML template for title row of the thumbnail view (album title + sort options)
$template_thumb_view_title_row = <<<EOT

                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                                <td width="100%" class="statlink"><h2>{ALBUM_NAME}</h2></td>
                        </tr>
                        </table>

EOT;

?>