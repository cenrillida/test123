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
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/plugins/link_target/configuration.php $
  $Revision: 8683 $
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$name = $lang_plugin_php['link_target_name'];
$description = $lang_plugin_php['link_target_description'] . '&nbsp;' . cpg_display_help('f=plugins.htm&amp;as=plugin_bundled_link_target&amp;ae=plugin_bundled_link_target_end', '400', '200');

$author='Coppermine dev team';
$version='1.2';
$plugin_cpg_version = array('min' => '1.5');
$install_info = $extra_info = $lang_plugin_php['link_target_extra'] . '<br />' . $lang_plugin_php['link_target_recommendation'];



?>