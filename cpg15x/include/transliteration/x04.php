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
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/include/transliteration/x04.php $
  $Revision: 8683 $
**********************************************/

$base = array(
  0x00 => 'Jo', 'Yo', 'Dj', 'Gj', 'Ie', 'Dz', 'I', 'Yi', 'J', 'Lj', 'Nj', 'Tsh', 'Kj', 'I', 'U', 'Dzh',
  0x10 => 'A', 'B', 'V', 'G', 'D', 'E', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
  0x20 => 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Shch', '', 'Y', '', 'E', 'Yu', 'Ya',
  0x30 => 'a', 'b', 'v', 'g', 'd', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
  0x40 => 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya',
  0x50 => 'je', 'yo', 'dj', 'gj', 'ie', 'dz', 'i', 'yi', 'j', 'lj', 'nj', 'tsh', 'kj', 'i', 'u', 'dzh',
  0x60 => 'O', 'o', 'E', 'e', 'Ie', 'ie', 'E', 'e', 'Ie', 'ie', 'O', 'o', 'Io', 'io', 'Ks', 'ks',
  0x70 => 'Ps', 'ps', 'F', 'f', 'Y', 'y', 'Y', 'y', 'u', 'u', 'O', 'o', 'O', 'o', 'Ot', 'ot',
  0x80 => 'Q', 'q', '*1000*', '', '', '', '', NULL, '*100.000*', '*1.000.000*', NULL, NULL, '"', '"', 'R\'', 'r\'',
  0x90 => 'G\'', 'g\'', 'G\'', 'g\'', 'G\'', 'g\'', 'Zh\'', 'zh\'', 'Z\'', 'z\'', 'K\'', 'k\'', 'K\'', 'k\'', 'K\'', 'k\'',
  0xA0 => 'K\'', 'k\'', 'N\'', 'n\'', 'Ng', 'ng', 'P\'', 'p\'', 'Kh', 'kh', 'S\'', 's\'', 'T\'', 't\'', 'U', 'u',
  0xB0 => 'U\'', 'u\'', 'Kh\'', 'kh\'', 'Tts', 'tts', 'Ch\'', 'ch\'', 'Ch\'', 'ch\'', 'H', 'h', 'Ch', 'ch', 'Ch\'', 'ch\'',
  0xC0 => '`', 'Zh', 'zh', 'K\'', 'k\'', NULL, NULL, 'N\'', 'n\'', NULL, NULL, 'Ch', 'ch', NULL, NULL, NULL,
  0xD0 => 'a', 'a', 'A', 'a', 'Ae', 'ae', 'Ie', 'ie', '@', '@', '@', '@', 'Zh', 'zh', 'Z', 'z',
  0xE0 => 'Dz', 'dz', 'I', 'i', 'I', 'i', 'O', 'o', 'O', 'o', 'O', 'o', 'E', 'e', 'U', 'u',
  0xF0 => 'U', 'u', 'U', 'u', 'Ch', 'ch', NULL, NULL, 'Y', 'y', NULL, NULL, NULL, NULL, NULL, NULL,
);

// Overrides for Kyrgyz input.
$variant['kg'] = array(
  0x01 => 'E',
  0x16 => 'C',
  0x19 => 'J',
  0x25 => 'X',
  0x26 => 'TS',
  0x29 => 'SCH',
  0x2E => 'JU',
  0x2F => 'JA',
  0x36 => 'c',
  0x39 => 'j',
  0x45 => 'x',
  0x46 => 'ts',
  0x49 => 'sch',
  0x4E => 'ju',
  0x4F => 'ja',
  0x51 => 'e',
  0xA2 => 'H',
  0xA3 => 'h',
  0xAE => 'W',
  0xAF => 'w',
  0xE8 => 'Q',
  0xE9 => 'q',
);
