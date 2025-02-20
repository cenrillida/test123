function linkOver(obj)
{
	if(obj.className == "left_block_over")
	{
		obj.className = "left_block_out";
		window.status = "";
	}
	else
	{
		obj.className = "left_block_over";
		window.status = obj.innerText + " (ID: " + obj.getAttribute("itemID") + ")";
	}
}

function editItem(ID, actionName)
{
	var varstr = createGETVariables();

	window.location.href = window.location.href.split(/\?/)[0] + "?" + varstr + "action=" + actionName + "&id=" + ID;
	return;
}

// функци€ активаци панели action'ов
function activateActionPanel()
{
	var buttonObj = getObj("button_block");
	var preloadImg = new Image;

	buttonImgs = buttonObj.getElementsByTagName("IMG");

	// устанавливаем действи€ с кнопками (mouseover, mouseout, click) + подгружаем необходимые картинки
	for(var i = 0; i < buttonImgs.length; i++)
	{
		var tmp = buttonImgs[i].getAttribute("action").split("/");
		buttonImgs[i].setAttribute("id", tmp[tmp.length - 1]);

		preloadImg[i] = buttonImgs[i].src.split(".gif")[0] + "_a.gif";

		buttonImgs[i].onmouseover = buttonOver;
		buttonImgs[i].onmouseout  = buttonOut;
		buttonImgs[i].onclick     = buttonClick;
	}
}

// действие mouseover
function buttonOver()
{
	// замен€ем изображение кнопки на активное
	var imgName = this.src.split(".gif");
	this.src = imgName[imgName.length - 2] + "_a.gif";
}

// действие mouseout
function buttonOut()
{
	// замен€ем изображение кнопки на не  активное
	var imgName = this.src.split("_a.gif");
	this.src = imgName[imgName.length - 2] + ".gif";
}

// действие click
function buttonClick()
{
	var actionName   = this.getAttribute("action");
	var workFormName = this.getAttribute("formName");
	var workForm	 = workFormName ? getObj(workFormName): false;

	if(this.getAttribute("confirm") != "")
	{
		if(!confirm(this.getAttribute("confirm")))
			return;
	}

	var varstr = createGETVariables();

	if(!workForm)
	{
		window.location.href = window.location.href.split(/\?/)[0] + "?" + varstr + "action=" + actionName;
		return;
	}

	if(workForm.tagName == "FORM")
	{
		
		//workForm.action = workForm.action.split(/\?/)[0] + "?" + varstr + "action=" + actionName;
		var action_attr = workForm.getAttribute("action");
		var new_action_attr = action_attr.split(/\?/)[0] + "?" + varstr + "action=" + actionName;
		workForm.setAttribute("action", new_action_attr);
		var actionNode = document.createElement("INPUT");
		actionNode.type = "hidden";
		actionNode.name = "action";
		actionNode.value = actionName;

		if(actionName == "preview")
			workForm.target = "_blank";

		if(actionName == "open_on_site")
			workForm.target = "_blank";

		if(actionName == "open_on_site_iline")
			workForm.target = "_blank";

		workForm.appendChild(actionNode);
		workForm.submit();
		return; 
	}

	alert("Ќевозможно произвести действие");
}

function createGETVariables(fromLink)
{
	// массив допустимых передаваемых GET переменных
	var allowVars = new Object;
	allowVars["mod"] = 1;
	allowVars["id"] = 1;
	allowVars["type"] = 1;

	// получаем все переданные переменные
	var GETVariables = getGETVariables(fromLink);

	var varstr = "";
	for(var i in GETVariables)
	{
		if(allowVars[i])
			varstr += i + "=" + GETVariables[i] + "&";		
	}

	return varstr;
}

// получаем все переменные переданные GET'ом
function getGETVariables(hrefStr)
{
	hrefStr = hrefStr? hrefStr: window.location.href;

	var GETVariables = new Object;
	var queryString = hrefStr.split(/\?/);
	if(queryString[1])
	{
		var varArray = queryString[1].split(/&/);
		for(var i in varArray)
		{
			var tmp = varArray[i].split(/=/);
			GETVariables[tmp[0]] = tmp[1];
		}
	}
	return GETVariables;
}