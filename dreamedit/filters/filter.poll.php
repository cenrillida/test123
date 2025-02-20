<?

//sUrl = "poll.php";
?>
<script language="JavaScript">
var req;
var reqTimeout;
//_____________________
function loadXMLDoc(url)
{

    req = null;
    if (window.XMLHttpRequest) {
        try {

            req = new XMLHttpRequest();

        } catch (e){}
        } else if (window.ActiveXObject) {
        try {
            req = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e){
        try {
            req = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (e){}
    }
    }

    if (req) {
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
        reqTimeout = setTimeout("req.abort();", 5000);
	return true;
    } else {

//      alert("Извините, Вы не сможете проголосовать, Ваш браузер не поддерживает AJAX");
      return false;
}
}


//_________________________
function processReqChange() {


    if (req.readyState == 4) {
        clearTimeout(reqTimeout);


        if (req.status == 200) {
     document.form1.status.value = req.readyState;
     dd=new Date();
     var largeExpDate = new Date ();
     largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));

//     myDomain='www.isras.ru';
     setCookie("israspoll",document.form1.id_poll.value,largeExpDate);


     showResults(req.responseText);
        } else {
            alert("Не удалось получить данные:\n" + req.statusText);

        }
    }


}
//___________________
function stat(n)
// Статус
 {

  switch (n) {
  case 0:
        return "не инициализирован";
        break;

case 1:
      return "загрузка...";
      break;

  case 2:
      return "загружено";
      break;

case 3:
      return "в процессе...";
      break;

 case 4:
      return "готово";
     break;

default:
      return "неизвестное состояние";
}
}

//_______________________
function requestdata(params)
{
// Запрос к серверу
  loadXMLDoc(params);


//         makeAJAXCall(sUrl+"?choice="+selIndex);

}


//____________________________

// Cookies
function setCookie(name, value, expires, path, domain, secure) {
  var curCookie = name + "=" + escape(value) +
  ((expires) ? "; expires=" + expires.toGMTString() : "") +
  ((path) ? "; path=" + path : "") +
  ((domain) ? "; domain=" + domain : "") +
  ((secure) ? "; secure" : "");

  document.cookie = curCookie;


}
//_____________________///////////////////////////////__________________

//вывод на страницу результатов опроса
    function showResults(xml){


    var divElement = document.getElementById("poll");
    while (divElement.hasChildNodes()) divElement.removeChild(divElement.lastChild); //очищаем содержимое div'а
    divElement.appendChild(document.createElement("br"));
    divElement.appendChild(document.createElement("br"));
   var ie;
   if (document.implementation.createDocument){

       // Mozilla, create a new DOMParser
       var parser = new DOMParser();
       xmldoc = parser.parseFromString(xml, "text/xml");
      ie=false;
   } else {

   if (window.ActiveXObject){
   ie=true;
// Internet Explorer, create a new XML document using ActiveX
// and use loadXML as a DOM parser.
      xmldoc = new ActiveXObject("Microsoft.XMLDOM");
//      xmldoc.async="false";
      xmldoc.loadXML(xml);

}
}
////
    var quest=divElement.appendChild(document.createElement("strong"));
        quest.appendChild(document.createTextNode(document.form1.vopros.value));

    divElement.appendChild(document.createElement("br"));
    divElement.appendChild(document.createElement("br"));

    var choices = xmldoc.documentElement.getElementsByTagName("choice");                // получение всех вариантов ответа из XML

    var totalVoted = xmldoc.documentElement.getElementsByTagName("totalVoted")[0].firstChild.data;

    for (var i=0; i<document.form1.votetotal.value;i++){
    if (ie==false)     {
        var divtotal = divElement.appendChild(document.createElement("div"));
            divtotal.setAttribute("style"," margin-top: 10px;" );
    } else {
        var divtotal = divElement.appendChild(document.createElement("<div " +
           "style=  margin-top: 5px;>" ));

    }
            var choice = choices[i].firstChild.firstChild.data;                          //получение варианта ответа из XML
            var percent = choices[i].childNodes[1].firstChild.data;                      //получение процентов проголосовавших из XML
            if (i==0) choice=document.form1.votetext1.value;
            if (i==1) choice=document.form1.votetext2.value;
            if (i==2) choice=document.form1.votetext3.value;
            if (i==3) choice=document.form1.votetext4.value;
            if (i==4) choice=document.form1.votetext5.value;
            if (i==5) choice=document.form1.votetext6.value;
            if (i==6) choice=document.form1.votetext7.value;
            if (i==7) choice=document.form1.votetext8.value;
            if (i==8) choice=document.form1.votetext9.value;
            if (i==9) choice=document.form1.votetext10.value;

//            divtotal.appendChild(document.createElement("div"));


            var pp=divtotal.appendChild(document.createElement("p"));
            var li=pp.appendChild(document.createElement("li"));
            li.appendChild(document.createTextNode(choice));
            li.appendChild(document.createElement("br"));

           if (ie==false) {
               var divimg = li.appendChild(document.createElement("div"));
	       divimg.setAttribute("style","width: "+
                 (percent*2/totalVoted*100)+
	         "px; height: 10px; float: left;  margin: 3px 5px 0px 13px;  background-image: url(http://www.isras.ru/img/gradusnik.jpg);");
           } else {
              var divimg = divtotal.appendChild(document.createElement("<div "+ "style= 'width: "+
                (percent*2/totalVoted*100)+
	         "px; height: 1px; float: left;  margin: 3px 5px 0px 7px;  background-image: url(http://www.isras.ru/img/gradusnik.jpg) ';>"));
          }
          if (ie==false) {
             var pr=divtotal.appendChild(document.createElement("font"));
	     pr.setAttribute("style","float: none;");
	} else {
	     var pr1=divtotal.appendChild(document.createElement("<font " +   "float= none; >"));
	     var pr=pr1.appendChild(document.createElement("<font " +   "size= 1px;>"));

	}
        if (ie==false) {
	    pr.appendChild(document.createTextNode( percent+" ("+
	    (Math.round(percent/totalVoted*10000)/100)+ "%)"));      //добавление результата
	    pr.setAttribute("size","1px");
	} else {
//	    var prdiv= pr.appendChild(document.createElement("<div "+"style= 'float: none; size: 1px;'>"));
	    pr.appendChild(document.createTextNode( percent+" ("+
                (Math.round(percent/totalVoted*10000)/100)+ "%)" ));      //добавление результата

//	    pr.setAttribute("size", "1");
	}
            divtotal.appendChild(document.createElement("br"));


    }
    divElement.appendChild(document.createElement("br"));
//получение количества проголосовавших
    var totalVoted = xmldoc.documentElement.getElementsByTagName("totalVoted")[0].firstChild.data;
    divElement.appendChild(document.createTextNode("Всего голосов: "+totalVoted)); //добавление на страницу
}
var init = true;
//______________________
function MyFBCheck()
{

   var ch;
   var err=false;

   for (var j=0;j<document.form1.votetotal.value;j++) {
       if  (document.form1.vote[j].checked == true) err=true;
    }
   if (err==false)
   {
       alert("Вы не выбрали свой вариант ответа");
       return false;
   }
       for (var i=0; i<document.form1.votetotal.value; i++) {
           if (document.form1.vote[i].checked== true) ch=i+1;
               document.form1.vote[i].checked = false;
       }
   var domain=document.form1.dbhost.value
   var ret=loadXMLDoc("http://"+domain+"dreamedit/filters/poll_rec.php?chois="+ch+"&id_poll="+document.form1.id_poll.value+
   "&dbname="+document.form1.dbname.value+
   "&dbpswd="+document.form1.dbpswd.value+
   "&dbuser="+document.form1.dbuser.value
      );

  if (ret == true) {
       var cur = document.getElementById('vote').style;
       cur.display="none";
       var cur2 = document.getElementById('poll').style;
       cur2.display="block";
       return false;
   } else {

       var largeExpDate = new Date ();
       largeExpDate.setTime(largeExpDate.getTime() + (365 * 24 * 3600 * 1000));

       setCookie("israspoll",document.form1.id_poll.value,largeExpDate);
       setCookie("poll",ch,largeExpDate);
       return true;
  }

}

</script>
<?


global $DB, $_CONFIG, $page_content;

//print_r($_CONFIG);
//echo "<br /> cookie ".$_COOKIE;
//Найти активный опрос
$result= $DB->select("
SELECT c.el_id AS id_poll, ct.icont_text AS poll_title, cc.icont_text AS poll_comment,
       cd.icont_text AS poll_date, cv1.icont_text AS variant1,
       cv2.icont_text AS variant2,cv3.icont_text AS variant3,
       cv4.icont_text AS variant4,cv5.icont_text AS variant5,
       cv6.icont_text AS variant6,
       cv7.icont_text AS variant7,cv8.icont_text AS variant8,
       cv9.icont_text AS variant9,cv10.icont_text AS variant10
      FROM adm_polls_content AS c
           INNER JOIN adm_polls_content AS ct ON ct.el_id = c.el_id
                 AND ct.icont_var = 'title'
	   INNER JOIN adm_polls_content cd ON cd.el_id = c.el_id
	         AND cd.icont_var = 'date'
	   INNER JOIN adm_polls_content cc ON cc.el_id = c.el_id
	         AND cc.icont_var='comment'
	   INNER JOIN adm_polls_content cv1 ON cv1.el_id=c.el_id
	         AND cv1.icont_var='variant1'
	   INNER JOIN adm_polls_content cv2 ON cv2.el_id=c.el_id
	         AND cv2.icont_var='variant2'
	   INNER JOIN adm_polls_content cv3 ON cv3.el_id=c.el_id
	         AND cv3.icont_var='variant3'
	   INNER JOIN adm_polls_content cv4 ON cv4.el_id=c.el_id
	         AND cv4.icont_var='variant4'
	   INNER JOIN adm_polls_content cv5 ON cv5.el_id=c.el_id
	         AND cv5.icont_var='variant5'
	   INNER JOIN adm_polls_content cv6 ON cv6.el_id=c.el_id
	         AND cv6.icont_var='variant6'
	   INNER JOIN adm_polls_content cv7 ON cv7.el_id=c.el_id
	         AND cv7.icont_var='variant7'
	   INNER JOIN adm_polls_content cv8 ON cv8.el_id=c.el_id
	         AND cv8.icont_var='variant8'
	   INNER JOIN adm_polls_content cv9 ON cv9.el_id=c.el_id
	         AND cv9.icont_var='variant9'
	   INNER JOIN adm_polls_content cv10 ON cv10.el_id=c.el_id
	         AND cv10.icont_var='variant10'
	   INNER JOIN adm_polls_content cst ON cst.el_id=c.el_id
	         AND cst.icont_var='status'
	   WHERE cst.icont_text='1' AND c.icont_var='title'
	   ORDER BY cd.icont_text DESC LIMIT 1

	  ");

// Допустим, что не голосовал. На самом деле надо проверить куку для poll_id
$form1visible="block";
//print_r($_COOKIE);
if (isset($_COOKIE[israspoll]))
{
if (isset($_COOKIE[poll]))
{
//   echo "надо записать результат";
   $res0=$DB->select("SELECT * FROM poll WHERE poll_id=".$_COOKIE[israspoll]);

   if (empty($res0))
      $ins=$DB->query("INSERT INTO poll VALUES(0,".$_COOKIE[israspoll].",0,0,0,0,0,0,0,0,0,0,".
            "'".date(Ymd)."')");

      $nn="choice".$_COOKIE[poll];
      $iii=$res0[0][$nn]+1;


      $a=mysql_query("UPDATE poll SET choice".$_COOKIE['poll'] . "=".$iii.
            ", date ='".date(Ymd)."' ".
            " WHERE poll_id=".$_COOKIE[israspoll]);
}

   if ($_COOKIE[israspoll]==$result[0]['id_poll']) {
// Выводим результат
       $form1visible="none";

       $res=$DB->select("
       SELECT choice1 AS c1,choice2 AS c2,choice3 AS c3,choice4 AS c4,choice5 AS c5,
              choice6 AS c6,choice7 AS c7,choice8 AS c8,choice9 AS c9,choice10 AS c10
          FROM poll
          WHERE poll_id=".$result[0]['id_poll']
         );

         $totalVoted=$res[0][c1]+$res[0][c2]+$res[0][c3]+$res[0][c4]+$c5[0][c5]+
                     $res[0][c6]+$res[0][c7]+$res[0][c8]+$res[0][c9]+$c5[0][c10];

         if ($totalVoted > 0)
	 {
            echo "<br />";
	    echo "<p><span align='center'><strong>".$result[0][poll_title]."</strong></span><br />";
            echo "<br />";
	    echo "<table>";
            for ($i=1;$i<11;$i++)
            {
                if ($result[0]['variant'.($i)]!="")
                {
	            echo "<tr><td>";
                    echo " ".$result[0]['variant'.$i]."";
		    echo "</td></tr><tr><td>";
		    echo "<div style= 'width: ". ($res[0][c.($i)]*2/$totalVoted*100).
                         "px; height: 10px; float: left;  margin: 0px 5px 0px 8px;  background-image: url(/img/gradusnik.jpg); background-repeat: no-repeat '></div> ";
                    echo "<font style= 'float: none; '><font size='1px'>".($res[0][c.($i)]." (".ceil($res[0][c.($i)]/$totalVoted*10000)/100). "%)</font></font>";

		    echo "</td></tr>";

                }
            }
	    echo "</table>";
            echo "<br />Всего голосов: ".$totalVoted."<br />";
	 }
         else   $form1visible="block";  //Нет голосов
         echo "<br />";
//print_r($_TPL_REPLACMENT);
	 echo "<a href=/index.php?page_id=".$page_content['POLL_PAGE'].">Результаты других опросов</a>";
   }
}
//Рисуем форму

echo "<div id = 'vote' style='display:".$form1visible."'>";
echo "<form name=form1 action=''  enctype='multipart/form-data' method='post' onSubmit='return MyFBCheck()'>";
echo "<p><span align='center'><strong>".$result[0][poll_title]."</strong></span><br />";
//echo $result[0][poll_comment]."</p>";

echo "<br /><input  type=hidden name='id_poll' value=".$result[0][id_poll]."></input>";
echo "<input type=hidden name='vopros' value='".$result[0][poll_title]."'>";
echo "<input type=hidden name='dbname' value='".$_CONFIG["global"]["db_connect"]["db_name"]."'>";
echo "<input type=hidden name='dbuser' value='".$_CONFIG["global"]["db_connect"]["login"]."'>";
echo "<input type=hidden name='dbpswd' value='".$_CONFIG["global"]["db_connect"]["password"]."'>";
echo "<input type=hidden name='dbhost' value='".$_CONFIG["global"]["paths"]["site"]."'>";

$votetotal=0;
echo "<table>";
for ($i=1;$i<11;$i++)
{
   if ($result[0]['variant'.$i]!="")
   {
     echo "<tr><td valign='top'>";
     echo "<input type='radio' name='vote' value='".$i."'>";
     echo "</td><td>";
     echo $result[0]['variant'.$i]."</input><br>";
     echo "<input type='hidden' name='votetext".$i."' value='".$result[0]['variant'.$i]."'>"."</input>";
     echo "</td></tr>";
     $votetotal++;
   }
}
echo "</table>";
echo "<input type='hidden' name='votetotal' value='".$votetotal."'></input>";
echo  "<br />	  <input type='submit' name='Submit' value='Голосовать'>";
echo "<input type=hidden disabled size=10 type=text name='status' value=''>";
echo "</form>";
echo "</div>";

echo "<div id='poll' style='display: none'>";
echo "<form name='form2'>";
echo "<text align='center'><strong>".$result[0][poll_title]."</strong><br />";
//echo "<input text name='v1' value=0>"."##"."</text>";
echo "</form>";

echo "</div>";


?>