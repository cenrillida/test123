function setCookie(name, value, expires, path, domain, secure) {
//  domain='elearning';
    path="/";

    var curCookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");

    document.cookie = curCookie;


}
function getCookie(name)
{
    cookie_name = name + "=";

    cookie_length = document.cookie.length;
    cookie_begin = 0;
    while (cookie_begin < cookie_length)
    {
        value_begin = cookie_begin + cookie_name.length;
        if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
        {
            var value_end = document.cookie.indexOf (";", value_begin);
            if (value_end == -1)
            {
                value_end = cookie_length;
            }
            return unescape(document.cookie.substring(value_begin, value_end));
        }
        cookie_begin = document.cookie.indexOf(" ", cookie_begin) + 1;
        if (cookie_begin == 0)
        {
            break;
        }
    }
    return null;
}