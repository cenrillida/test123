var req;
var tyear;
var month;
var dbhost0;
var dbname0;
var dbuser0;
var dbpass0;
var spisok0;
var result_id0;      //страница с результатом

function navigate_en(month,year,evt,dbhost,dbname,dbuser,dbpass,spisok,result_id) {

	setFade(0);

     dbhost='localhost';
     dbhost0=dbhost;
     dbname0=dbname;
     dbuser0=dbuser;
     dbpass0=dbpass;
     spisok0=spisok;
     result_id0=result_id;
    var url = "/dreamedit/filters/super_calendar_en.php?month="+month+"&year="+year+"&event="+evt+
              "&dbhost="+dbhost+"&dbname="+dbname+"&dbuser="+dbuser+"&dbpass="+dbpass+
              "&spisok="+spisok+"&result_id="+result_id;

	 if(window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("GET", url, true);
	req.onreadystatechange = callback;
	req.send(null);
	tyear=year;
    tmonth=month;
}


function callback() {
	if(req.readyState == 4) {
		var response = req.responseXML;
		var resp = response.getElementsByTagName("response");
		getObject("calendar").innerHTML = resp[0].getElementsByTagName("content")[0].childNodes[0].nodeValue;
		fade(70);
	}
}

function getObject(obj) {
	var o;
	if(document.getElementById) o = document.getElementById(obj);
	else if(document.all) o = document.all.obj;
	return o;
}

function fade(amt) {
	if(amt <= 100) {
		setFade(amt);
		amt += 10;
		setTimeout("fade("+amt+")", 5);
    }
}

function setFade(amt) {
	var obj = getObject("calendar");
	amt = (amt == 100)?99.999:amt;
	obj.style.filter = "alpha(opacity:"+amt+")";
	obj.style.KHTMLOpacity = amt/100;
	obj.style.MozOpacity = amt/100;
	obj.style.opacity = amt/100;
}

function showJump(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) {
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	var jump = document.createElement("div");
	jump.setAttribute("id","jump");
	jump.style.position = "absolute";
	jump.style.top = curtop+15+"px";
	jump.style.left = curleft+"px";

   var fordate = new Date();
	if (tyear=="")
	   tyear=fordate.getYear();
	   if (tyear < 2000) tyear=tyear+1900;
	if (tmonth==="")
	   tmonth=fordate.getMonth();
//
    if (tmonth[0]=="0")
    {
       tt=tmonth[1];
       tmonth=tt;
    }



	var output = '<select id="month">\n';
	var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
//	output += '<option value="'+tmonth+'">'+months[tmonth-1]+'  </option>\n';

	var n;
	for(var i=0;i<12;i++) {
		n = ((i+1)<10)? '0'+(i+1):i+1;
        if (n==tmonth)
           sel='selected="selected"';
		else
           sel='';
		output += '<option '+sel+'value="'+n+'">'+months[i]+'  </option>\n';
	}

	output += '</select> \n<select id="year">\n';
    var tdate=new Date();
	var year0=tdate.getFullYear();
//	output += '<option value="'+tyear+'">'+tyear+'  </option>\n';
	for(var i=year0;i>=1996;i=i-1) {
		if (i==tyear)
		   sel='selected="selected"';
		else
           sel='';
		output += '<option '+sel+'value="'+i+'">'+i+'  </option>\n';
	}
	output += '</select> <a href="javascript:jumpTo()"><img src="/calendar/images/calGo.gif" alt="go" /></a> <a href="javascript:hideJump()"><img src="/calendar/images/calStop.gif" alt="close" /></a>';
	jump.innerHTML = output;
	document.body.appendChild(jump);
}

function hideJump() {
	document.body.removeChild(getObject("jump"));
}

function jumpTo() {
	var m = getObject("month");
	var y = getObject("year");

    navigate_en(m.options[m.selectedIndex].value,y.options[y.selectedIndex].value,'evt',dbhost0,dbname0,dbuser0,dbpass0,spisok0,result_id0);
	hideJump();
}