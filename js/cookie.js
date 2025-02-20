// Cookies
function setCookie(name, value, expires, path, domain, secure) {


  var curCookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;


}
function getCookie(name) {

	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;

	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}

	return(setStr);
}
function strpos( haystack, needle, offset){ // Find position of first occurrence of a string
    //
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

    var i = haystack.indexOf( needle, offset ); // returns -1
    return i >= 0 ? i : false;
}
function explode( delimiter, string ) { // Split a string by string
	    //
	    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: kenneth
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	    var emptyArray = { 0: '' };

	    if ( arguments.length != 2
	        || typeof arguments[0] == 'undefined'
	        || typeof arguments[1] == 'undefined' )
	    {
	        return null;
	    }

	    if ( delimiter === ''
	        || delimiter === false
	        || delimiter === null )
	    {
	        return false;
	    }

	    if ( typeof delimiter == 'function'
	        || typeof delimiter == 'object'
	        || typeof string == 'function'
	        || typeof string == 'object' )
	    {
	        return emptyArray;
	    }

	    if ( delimiter === true ) {
	        delimiter = '1';
	    }

	    return string.toString().split ( delimiter.toString() );
	}