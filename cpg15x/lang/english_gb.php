<?php
/*************************
  Coppermine Photo Gallery
  ************************
  Copyright (c) 2003-2014 Coppermine Dev Team
  v1.0 originally written by Gregory Demar

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 3
  as published by the Free Software Foundation.

  ********************************************
  Coppermine version: 1.5.28
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/lang/english_gb.php $
  $Revision: 8683 $
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

// info about translators and translated language
$lang_translation_info['lang_name_english'] = 'English (British)';
$lang_translation_info['lang_name_native'] = 'English (British)';
$lang_translation_info['lang_country_code'] = 'en_gb';
$lang_translation_info['trans_name'] = 'Nibbler';
$lang_translation_info['trans_email'] = 'nibbler@coppermine-gallery.net';
$lang_translation_info['trans_website'] = 'http://coppermine-gallery.net/';
$lang_translation_info['trans_date'] = '2009-07-11';

// The various date formats
// See http://www.php.net/manual/en/function.strftime.php to define the variable below
$lang_date['album'] = '%B %d, %Y';
$lang_date['lastcom'] = '%m/%d/%y at %H:%M';
$lang_date['lastup'] = '%B %d, %Y';
$lang_date['register'] = '%B %d, %Y';
$lang_date['lasthit'] = '%B %d, %Y at %I:%M %p';
$lang_date['comment'] = '%B %d, %Y at %I:%M %p';
$lang_date['log'] = '%B %d, %Y at %I:%M %p';

$lang_meta_album_names['favpics'] = 'Favourite files';

$lang_common['captcha_help'] = 'To avoid spam, you have to confirm that you are an actual human being and not just a bot script by entering the displayed text.<br />Capitalisation does not matter, you can type in lowercase.'; // cpg1.5

$lang_main_menu['fav_title'] = 'Go to my favourites';
$lang_main_menu['fav_lnk'] = 'My Favourites';

$lang_thumb_view['zipdownload_username'] = 'This archive contains the zipped files from the favourites of %s'; // cpg1.5

$lang_bridgemgr_php['recovery_success_title'] = 'Authorisation successful';
$lang_bridgemgr_php['recovery_failure_title'] = 'Authorisation failed';

$lang_admin_php['enable_zipdownload'] = 'Allow ZIP-download of favourites'; // cpg1.5
$lang_admin_php['enable_zipdownload_no_textfile'] = 'just the favourites'; // cpg1.5
$lang_admin_php['enable_zipdownload_additional_textfile'] = 'favourites and readme file'; // cpg1.5

$lang_admin_php['transparent_overlay'] = 'Insert a transparent overlay to minimise image theft'; // cpg1.5

$lang_admin_php['watermark_transparency_featherx'] = 'Set colour transparent x'; // cpg1.5
$lang_admin_php['watermark_transparency_feathery'] = 'Set colour transparent y'; // cpg1.5

$lang_delete_php['anonymized_comments'] = '%s comment(s) anonymised';
$lang_delete_php['anonymized_uploads'] = '%s public upload(s) anonymised';

$lang_picinfo['addFav'] = 'Add to Favourites';
$lang_picinfo['addFavPhrase'] = 'Favourites';
$lang_picinfo['remFav'] = 'Remove from Favourites';

$lang_picinfo['ColorSpace'] = 'Colour Space';
$lang_picinfo['ColorMode'] = 'Colour Mode';

$lang_groupmgr_php['explain_greyed_out_title'] = 'Why is this row greyed out?';

$lang_usermgr_php['delete_files_no'] = 'keep public files (but anonymise)';
$lang_usermgr_php['delete_comments_no'] = 'keep comments (but anonymise)';
