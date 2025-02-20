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
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/trunk/cpg1.5.x/logs/log_header.inc.php $
  $Revision: 8683 $
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

?>Май 05, 2016 - 07:58 - While executing query 'INSERT INTO cpg15x_exif (pid, exifData) VALUES (2104, 'a:38:{s:16:\"ImageDescription\";s:31:\"                               \";s:4:\"Make\";s:4:\"Sony\";s:5:\"Model\";s:5:\"NEX-6\";s:11:\"xResolution\";s:27:\"350 dots per ResolutionUnit\";s:11:\"yResolution\";s:27:\"350 dots per ResolutionUnit\";s:14:\"ResolutionUnit\";s:4:\"Inch\";s:8:\"Software\";s:11:\"NEX-6 v1.00\";s:16:\"YCbCrPositioning\";s:11:\"Datum Point\";s:10:\"ExifOffset\";i:344;s:12:\"ExposureTime\";s:9:\"1/160 sec\";s:7:\"FNumber\";s:5:\"f/4.5\";s:15:\"ExposureProgram\";s:7:\"Program\";s:15:\"ISOSpeedRatings\";i:1250;s:11:\"ExifVersion\";s:11:\"version 2.3\";s:16:\"DateTimeOriginal\";s:19:\"2014:09:09 10:17:48\";s:23:\"ComponentsConfiguration\";s:5:\"YCbCr\";s:22:\"CompressedBitsPerPixel\";i:2;s:17:\"ExposureBiasValue\";s:4:\"0 EV\";s:16:\"MaxApertureValue\";s:5:\"f/4.5\";s:12:\"MeteringMode\";s:7:\"Pattern\";s:11:\"LightSource\";s:10:\"Unknown: 0\";s:5:\"Flash\";s:8:\"No Flash\";s:11:\"FocalLength\";s:5:\"55 mm\";s:15:\"FlashPixVersion\";s:9:\"version 1\";s:10:\"ColorSpace\";s:4:\"sRGB\";s:14:\"ExifImageWidth\";s:10:\"800 pixels\";s:15:\"ExifImageHeight\";s:10:\"534 pixels\";s:26:\"ExifInteroperabilityOffset\";i:36740;s:10:\"FileSource\";s:20:\"Digital Still Camera\";s:9:\"SceneType\";s:21:\"Directly Photographed\";s:14:\"CustomerRender\";i:0;s:12:\"ExposureMode\";i:0;s:12:\"WhiteBalance\";i:0;s:16:\"DigitalZoomRatio\";i:1;s:16:\"SceneCaptureMode\";i:0;s:8:\"Contrast\";i:0;s:10:\"Saturation\";i:0;s:9:\"Sharpness\";i:0;}')' in include/exif_php.inc.php on line 58 the following error was encountered: 
Duplicate entry '2104' for key 'PRIMARY'
---
May 13, 2016 at 11:20 PM - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='88' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
May 13, 2016 at 11:20 PM - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='88' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
May 17, 2016 at 05:58 PM - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='88' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Май 20, 2016 - 04:54 - While executing query 'SELECT r.pid, r.aid, filepath, filename, url_prefix, pwidth, pheight, filesize, ctime, r.title, r.keywords, r.votes, pic_rating, hits, caption, r.owner_id
                FROM cpg15x_pictures AS r
                INNER JOIN cpg15x_albums AS a ON a.aid = r.aid
                WHERE (1)
                AND approved = 'YES'
                AND hits > 0
                ORDER BY hits ASC, pid DESC
                 LIMIT 0 ,-12' in include/functions.inc.php on line 1612 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-12' at line 8
---
Май 23, 2016 - 07:39 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='36' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
May 26, 2016 at 03:22 PM - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures AS p
            INNER JOIN cpg15x_albums AS r ON r.aid = p.aid
            WHERE (1)
            AND approved = 'YES'
            AND (ctime > 
            OR ctime =  AND pid > 1837)' in include/functions.inc.php on line 2160 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR ctime =  AND pid > 1837)' at line 6
---
Май 27, 2016 - 14:48 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures AS p
            INNER JOIN cpg15x_albums AS r ON r.aid = p.aid
            WHERE (1)
            AND approved = 'YES'
            AND (hits > 
            OR hits =  AND pid < 2093)' in include/functions.inc.php on line 2211 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR hits =  AND pid < 2093)' at line 6
---
Jun 05, 2016 at 03:14 PM - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures AS p
            INNER JOIN cpg15x_albums AS r ON r.aid = p.aid
            WHERE (1)
            AND approved = 'YES'
            AND (ctime > 
            OR ctime =  AND pid > 2112)' in include/functions.inc.php on line 2160 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR ctime =  AND pid > 2112)' at line 6
---
Июнь 13, 2016 - 00:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures AS p
            INNER JOIN cpg15x_albums AS r ON r.aid = p.aid
            WHERE (1)
            AND approved = 'YES'
            AND (hits > 
            OR hits =  AND pid < 2111)' in include/functions.inc.php on line 2211 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR hits =  AND pid < 2111)' at line 6
---
Июнь 13, 2016 - 00:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures AS p
            INNER JOIN cpg15x_albums AS r ON r.aid = p.aid
            WHERE (1)
            AND approved = 'YES'
            AND (hits > 
            OR hits =  AND pid < 2095)' in include/functions.inc.php on line 2211 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'OR hits =  AND pid < 2095)' at line 6
---
Июнь 13, 2016 - 07:37 - While executing query 'SELECT r.pid, r.aid, filepath, filename, url_prefix, pwidth, pheight, filesize, ctime, r.title, r.keywords, r.votes, pic_rating, hits, caption, r.owner_id
                FROM cpg15x_pictures AS r
                INNER JOIN cpg15x_albums AS a ON a.aid = r.aid
                WHERE (1)
                AND approved = 'YES'
                AND hits > 0
                ORDER BY hits ASC, pid DESC
                 LIMIT 0 ,-3' in include/functions.inc.php on line 1612 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '-3' at line 8
---
Июль 14, 2016 - 12:05 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Июль 14, 2016 - 12:06 - While executing query 'SELECT COUNT(*) FROM cpg15x_pictures
                    WHERE ((aid='93' ) ) AND approved='YES'
                    AND (filename < '' OR filename = '' AND pid < )' in include/functions.inc.php on line 2088 the following error was encountered: 
You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 3
---
Авг 10, 2016 - 01:56 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '109.94.8.214', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-109.94.8.214' for key 'PRIMARY'
---
Авг 12, 2016 - 23:06 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '77.37.183.118', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-77.37.183.118' for key 'PRIMARY'
---
Авг 12, 2016 - 23:06 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '77.37.183.118', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-77.37.183.118' for key 'PRIMARY'
---
Авг 12, 2016 - 23:06 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '77.37.183.118', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-77.37.183.118' for key 'PRIMARY'
---
Авг 12, 2016 - 23:06 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '77.37.183.118', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-77.37.183.118' for key 'PRIMARY'
---
Март 09, 2017 - 12:03 - While executing query 'INSERT INTO cpg15x_mod_online (user_id, user_name, user_ip, last_action) VALUES ('0', 'Guest', '173.208.213.18', NOW())' in plugins/onlinestats/codebase.php on line 137 the following error was encountered: 
Duplicate entry '0-173.208.213.18' for key 'PRIMARY'
---
2017-05-24 11:59:56 - While executing query 'SELECT name, value FROM cpg15x_config' in include/init.inc.php on line 179 the following error was encountered: 
Can't open file: './imemon_photo/cpg15x_config.frm' (errno: 24)
---
2017-05-24 12:14:38 - While executing query 'SELECT name, value FROM cpg15x_config' in include/init.inc.php on line 179 the following error was encountered: 
Can't open file: './imemon_photo/cpg15x_config.frm' (errno: 24)
---
2017-07-05 01:51:54 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 02:53:04 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 03:10:18 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 05:47:32 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 06:50:39 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 06:50:48 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 06:59:27 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
2017-07-05 10:16:51 - Unable to connect to database: Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (111)
---
