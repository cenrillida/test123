
/* This script and many more are available free online at
The JavaScript Source!! http://javascript.internet.com
Created by: Pascal Vyncke :: http://www.SeniorenNet.be 

Edited HTML code by Billy Bullock :: http://www.billygbullock.com to use a drop-down list to select colors. Oct. 3, 2006
*/

// These are the variables; you can change these if you want
var expDays = 365;  // How many days to remember the setting
var standardStyle = '2'; // This is the number of your standard style sheet; this will be used when the user did not do anything.
var nameOfCookie = 'switchstyle'; // This is the name of the cookie that is used.
var urlToCSSDirectory = 'themes/andreas09/'; // This is the URL to your directory where your .css files are placed on your site.  For example: http://www.seniorennet.be/URL_TO_STYLESHEET_DIRECTORY_OF_YOUR_SITE/

// These are the names of your different .css files; use the name exactly as on your Web site
var ScreenCSS_1 = 'red.css';
var ScreenCSS_2 = 'red2.css';
var ScreenCSS_3 = 'blue.css';
var ScreenCSS_4 = 'blue2.css';
var ScreenCSS_5 = 'black.css';
var ScreenCSS_6 = 'black2.css';
var ScreenCSS_7 = 'green.css';
var ScreenCSS_8 = 'green2.css';
var ScreenCSS_9 = 'purple.css';
var ScreenCSS_10 = 'purple2.css';
var ScreenCSS_11 = 'orange.css';
var ScreenCSS_12 = 'orange2.css';
var ScreenCSS_13 = 'pink.css';


/***********************************************************************************************

	DO NOT CHANGE ANYTHING UNDER THIS LINE, UNLESS YOU KNOW WHAT YOU ARE DOING

***********************************************************************************************/

// This is the main function that does all the work
function switchStyleOfUser(){
	var fontSize = GetCookie(nameOfCookie);
	if (fontSize == null) {
		fontSize = standardStyle;
	}

	if (fontSize == "1") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_1 + '" media="screen">'); }
	if (fontSize == "2") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_2 + '" media="screen">'); }
	if (fontSize == "3") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_3 + '" media="screen">'); }
	if (fontSize == "4") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_4 + '" media="screen">'); }
	if (fontSize == "5") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_5 + '" media="screen">'); }
	if (fontSize == "6") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_6 + '" media="screen">'); }
	if (fontSize == "7") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_7 + '" media="screen">'); }
	if (fontSize == "8") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_8 + '" media="screen">'); }
	if (fontSize == "9") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_9 + '" media="screen">'); }
	if (fontSize == "10") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_10 + '" media="screen">'); }
	if (fontSize == "11") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_11 + '" media="screen">'); }
	if (fontSize == "12") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_12 + '" media="screen">'); }
	if (fontSize == "13") { document.write('<link rel="stylesheet" type"text/css" href="' + urlToCSSDirectory + ScreenCSS_13 + '" media="screen">'); }

	var fontSize = "";
	return fontSize;
}

var exp = new Date();
exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

// Function to get the settings of the user
function getCookieVal (offset) {
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1)
	endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

// Function to get the settings of the user
function GetCookie (name) {
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen) {
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
		return getCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) break;
	}
	return null;
}

// Function to remember the settings
function SetCookie (name, value) {
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape (value) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");
}

// Function to remove the settings
function DeleteCookie (name) {
	var exp = new Date();
	exp.setTime (exp.getTime() - 1);
	var cval = GetCookie (name);
	document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}

// This function is used when the user gives his selection
function doRefresh(){
	location.reload();
}

// This will call the main function.  Do not remove this, because otherwise this script will do nothing...
document.write(switchStyleOfUser());
