function getObj(objID)
{
	return document.getElementById(objID)? document.getElementById(objID): false;
}

// определение размеров рабочей области браузера
function getSize()
{
/****************************************************
	 size[0] - ширина рабочей области окна браузера
	 size[1] - высота рабочей области окна браузера
	 size[2] - отступ по ширине для конкретного браузера
	 size[3] - отступ по высоте для конкретного браузера
*****************************************************/
	var size = new Array();

	if(window.innerWidth && window.innerHeight)
	{
		// для мозилы
		size[0] = window.innerWidth;
		size[1] = window.innerHeight;
	}
	else if(document.body)
	{
		// для IE
		size[0] = document.body.clientWidth;
		size[1] = document.body.clientHeight;
	}
	else
	{
		// по-умолчанию берем разрешение 1024 х 768
		size[0] = 995;
		size[1] = 621;
	}

	if(navigator.appName == "Netscape")
	{
		size[2] = 47;
		size[3] = 110;	
	}
	else if(navigator.appName == "Opera")
	{
		size[2] = 59;
		size[3] = 117;	
	}
	else
	{
		size[2] = 15;
		size[3] = 93;
	}

	return size;
}

leftGlobalWidth = 200;
leftGlobalForResize = 200;

// установка размеров рабочих блоков CMS
function setSize(leftWidth)
{
	var leftObj = getObj("left_block");
	var rightObj = getObj("right_block");

	// ширина левого окна по умолчанию
	leftWidth = (leftWidth == null)? 200: leftWidth;
	if(leftWidth > 0) {
        leftGlobalWidth = leftWidth;
    }
    leftGlobalForResize = leftWidth;

	if(leftObj && rightObj)
	{
		var size = getSize();

		// установка ширины и высоты правой и левой рабочих областей
		leftObj.style.width  = leftWidth;
		rightObj.style.width  = size[0] - leftWidth - size[2];
		leftObj.style.height = rightObj.style.height = size[1] - size[3];

		if(navigator.appName == "Netscape")
		{
			leftObj.style.width  = leftWidth - 6;
			rightObj.style.width  = size[0] - leftWidth - size[2] - 6;
			leftObj.style.height = rightObj.style.height = size[1] - size[3] - 6;
		}
	}
	else
	{
		alert("В течение загрузки рабочей области возникли ошибки! попробуйте обновить окно браузера. Если ошибки повторять, обратитесь к разработчику.");
	}
	if(leftWidth === 0) {
		toggleLeftMenu(document.getElementById('toggleMenuButton'));
	}
}

leftMenuToggled = 1;

function toggleLeftMenu(sender) {
    var leftObj = getObj("left_block");

	if(leftMenuToggled) {
        leftObj.parentElement.setAttribute("style", "display: none");
        if(sender != null) {
            sender.innerHTML = 'Развернуть меню';
        }
        setSize(-15);
        leftMenuToggled = 0;
    } else {
        leftObj.parentElement.setAttribute("style", "display: block");
        if(sender != null) {
            sender.innerHTML = 'Свернуть меню';
        }
        setSize(leftGlobalWidth);
        leftMenuToggled = 1;
	}

}

leftMenuExpanded = 0;

function expandLeftMenu(sender) {

	if(!leftMenuExpanded) {
		if(sender != null) {
			sender.innerHTML = 'Уменьшить меню';
		}
		setSize(700);
		leftMenuExpanded = 1;
	} else {
		if(sender != null) {
			sender.innerHTML = 'Увеличить меню';
		}
		setSize(200);
		leftMenuExpanded = 0;
	}

}

seoFieldsExpanded = 0;

function expandSeoFields(sender) {
	var fields = document.getElementsByClassName("seo_field");
	if(!seoFieldsExpanded) {
		if(sender != null) {
			sender.innerHTML = 'Скрыть поля SEO';
		}
		for (var i=0; i<fields.length; i++) {
			fields[i].style.display = '';
		}
		seoFieldsExpanded = 1;
	} else {
		if(sender != null) {
			sender.innerHTML = 'Раскрыть поля SEO';
		}
		for (var i=0; i<fields.length; i++) {
			fields[i].style.display = 'none';
		}
		seoFieldsExpanded = 0;
	}

}

function modBlockOver(obj)
{
	obj.className = "mod_block mod_block_active";
	
	var imgName = obj.getElementsByTagName("IMG")[0].src.split(".png");
	obj.getElementsByTagName("IMG")[0].src = imgName[imgName.length - 2] + "_a.png";
}

function modBlockOut(obj)
{
	obj.className = "mod_block";

	var imgName = obj.getElementsByTagName("IMG")[0].src.split("_a.png");
	obj.getElementsByTagName("IMG")[0].src = imgName[imgName.length - 2] + ".png";
}

function modBlockClick(obj)
{
	window.location.href = "index.php?mod=" + obj.getAttribute("mod");
}

function loading()
{
	getObj("loading").style.display = "none";
}

function get_selection(win)
{
	if(document.selection)
	{ // MSIE
		return win.document.selection.createRange();
	}
	else 
	{ // Gecko, Opera
		return win.document.createRange();
	}
	return null;
}
