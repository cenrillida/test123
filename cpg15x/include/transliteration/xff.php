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
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/include/transliteration/xff.php $
  $Revision: 8683 $
**********************************************/

$base = array(
  0x00 => NULL, '!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/',
  0x10 => '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', '>', '?',
  0x20 => '@', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
  0x30 => 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '[', '\\', ']', '^', '_',
  0x40 => '`', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
  0x50 => 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '{', '|', '}', '~', NULL,
  0x60 => NULL, '.', '[', ']', ',', '*', 'wo', 'a', 'i', 'u', 'e', 'o', 'ya', 'yu', 'yo', 'tu',
  0x70 => '+', 'a', 'i', 'u', 'e', 'o', 'ka', 'ki', 'ku', 'ke', 'ko', 'sa', 'si', 'su', 'se', 'so',
  0x80 => 'ta', 'ti', 'tu', 'te', 'to', 'na', 'ni', 'nu', 'ne', 'no', 'ha', 'hi', 'hu', 'he', 'ho', 'ma',
  0x90 => 'mi', 'mu', 'me', 'mo', 'ya', 'yu', 'yo', 'ra', 'ri', 'ru', 're', 'ro', 'wa', 'n', ':', ';',
  0xA0 => '', 'g', 'gg', 'gs', 'n', 'nj', 'nh', 'd', 'dd', 'r', 'lg', 'lm', 'lb', 'ls', 'lt', 'lp',
  0xB0 => 'rh', 'm', 'b', 'bb', 'bs', 's', 'ss', '', 'j', 'jj', 'c', 'k', 't', 'p', 'h', NULL,
  0xC0 => NULL, NULL, 'a', 'ae', 'ya', 'yae', 'eo', 'e', NULL, NULL, 'yeo', 'ye', 'o', 'wa', 'wae', 'oe',
  0xD0 => NULL, NULL, 'yo', 'u', 'weo', 'we', 'wi', 'yu', NULL, NULL, 'eu', 'yi', 'i', NULL, NULL, NULL,
  0xE0 => '/C', 'PS', '!', '-', '|', 'Y=', 'W=', NULL, '|', '-', '|', '-', '|', '#', 'O', NULL,
  0xF0 => NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{', '|', '}', '', '', '', '',
);
