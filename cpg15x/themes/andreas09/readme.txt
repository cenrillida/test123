CPG Theme Name: Andreas09 v1.0

Theme Name: WP-Andreas09
Theme URI: http://webgazette.co.uk/wordpress-themes/wp-andreas09/
Description: WP-Andreas09 theme for WordPress based on the open source template, andreas09 by <a href="http://www.andreasviklund.com/">Andreas Viklund</a> - Ported to WordPress by <a href="http://webgazette.co.uk/">Ainslie Johnson</a>.
Version: 2.1
Author: Andreas Viklund and Ainslie Johnson
Author URI: http://webgazette.co.uk/wordpress-themes/wp-andreas09/

andreas09 v1.0 (Dec 10th 2005) - An open source template by Andreas Viklund - http://andreasviklund.com. Free to use for any purpose as long as the proper credits are given to the original author.

Ported to WordPress by Ainslie Johnson - Last updated 28/07/06

Ported to Coppermine Photo Gallery by Billy Bullock - Oct. 2, 2006 : Last Update - Oct. 7, 2006
Porter URL: http://www.billygbullock.com
Coppermine Theme Version: 1.1

Ported to cpg1.5.x by eenemeenemuu

This theme uses an additional hack not found in the orginal theme for WordPress from "http://www.cssplay.co.uk/boxes/width2.html" to set a min-width in Internet Explorer. Without this min-width, the right sidebar flows over the main content.

If you change the name of the theme, you need to edit this line - "var urlToCSSDirectory = 'themes/andreas09-3/'; /" in the "changeStyle.js" file for the color selector to work.

If you wish to remove the theme color selector, you need to add a link in the head section of the template.html to the color theme of your choice. For example, to have a red color theme, add "<link rel="stylesheet" href="themes/andreas09/red.css" type="text/css" />" to the header section.

Two Config settings are overridden in the theme.php file. This is to keep the theme from breaking. They are:
$CONFIG['max_film_strip_items'] = 4; //overrides the number of thumbnails set in the admin configuration
$CONFIG['thumbcols'] = 4; //overrides the number of columns for thumbnails set in the admin configuration

To correctly display large intermediate images, I've change the function compute_img_size($width, $height) to resize any intermediate image larger than 420 pixels wide. This will keep the auto scroll bar from appearing on monitors or window sizes of 800 pixels wide. If you want it to be larger, change "$max = 420;" in this function.

Please enjoy the theme and make all the changes you need to suit your gallery.

Cheers,

Billy
http://www.billygbullock.com