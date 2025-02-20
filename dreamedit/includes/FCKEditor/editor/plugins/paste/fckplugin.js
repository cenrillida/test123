
FCK.Events.AttachEvent("OnPaste", PluginPaste);

//////////////////////////////
// инициируем плагин
//////////////////////////////
function PluginPaste() 
{
	var str = FCK.GetClipboardHTML();
	// Инициализация
	PluginPasteCleanerInit();
	// Отчистка
	var str = PluginPasteCleaner(str);
	// Вставка	
	FCK.InsertHtml(str);

	return false;
}

// хорошие теги
var PasteGoodTags0 = "a,p,br,strong,b,em,i,u,strike,ul,ol,li,img,table,tr,th,td,small,big,sub,sup,hr,h1,h2,h3,h4,h5,h6,pre,div,span";

// хорошие атрибуты (допустимы у всех тегов)
var PasteGoodAttributes0		 = {};
PasteGoodAttributes0[""] 		 = "align,title"; // атрибуты для всех тегов
PasteGoodAttributes0["img"]      = "alt,src";
PasteGoodAttributes0["table"]    = "width,height,cellspacing,cellpadding";
PasteGoodAttributes0["th,td"]    = "colspan,rowspan";
PasteGoodAttributes0["tr,th,td"] = "nowrap,valign";
PasteGoodAttributes0["a"]        = "href,target";

// хорошие классы (не убиваем)
var PasteGoodClasses0 = "";

// Styles в attribute
var PasteGoodStyles0			= new Object();
PasteGoodStyles0["p,li"]		= "textAlign";
PasteGoodStyles0["table,th,td"] = "width,width";


var PasteGoodTags       = new Object();
var PasteGoodAttributes = new Object();
var PasteGoodClasses    = new Object();
var PasteGoodStyles     = new Object();


/////////////////////
// инициируем нужные элементы
/////////////////////
function PluginPasteCleanerInit() 
{
	// инициируем нужные теги
	var splittedTags = PasteGoodTags0.split(",");
	for (var i in splittedTags)
		PasteGoodTags[splittedTags[i].toLowerCase()] = true;

	// инициируем общие нужные аттрибуты
	var splittedArrts = PasteGoodAttributes0.split(",");
	PasteGoodAttributes[""] = new Object();
	for (var i in splittedArrts)
		PasteGoodAttributes[""][splittedArrts[i].toLowerCase()] = true;

	// инициируем отдельные аттрибуты для тегов
	for(var i in PasteGoodAttributes0)
	{
		var splittedAttrTags = i.split(",");
		var splittedAttrAttr = PasteGoodAttributes0[i].split(",");

		for(var tag in splittedAttrTags) 
		{
			var lowerAttrTag = splittedAttrTags[tag].toLowerCase();
			if (!PasteGoodAttributes[lowerAttrTag]) PasteGoodAttributes[lowerAttrTag] = new Object();
			for(var attr in splittedAttrAttr) 
				PasteGoodAttributes[lowerAttrTag][splittedAttrAttr[attr].toLowerCase()] = true;
		}
	}

	// инициируем общие нужные классы
	var splittedClasses = PasteGoodClasses0.split(",");
	for (var i in splittedClasses)
		PasteGoodClasses[splittedClasses[i]] = true;


	// инициируем отдельные стили для тегов
	var i = 0;
	for(var i in PasteGoodStyles0)
	{
		var splittedStyleTags = i.split(",");
		var splittedStyleAttr = PasteGoodStyles0[i].split(",");

		for(var tag in splittedStyleTags) 
		{
			if (!PasteGoodStyles[splittedStyleTags[tag]]) PasteGoodStyles[splittedStyleTags[tag]] = new Object();
			for(var attr in splittedStyleAttr) PasteGoodStyles[splittedStyleTags[tag]][splittedStyleAttr[attr]] = true;
		}
	}
}

/////////////////////
// начало чистки
/////////////////////
function PluginPasteCleaner(html) 
{
	var oBuffer = document.createElement("DIV"); // создаем объект для нашего кода

	oBuffer.innerHTML = html.replace(/<\/?\w+:\w+\s*[^>]*>/gi, ""); // уничтожаем "не" теги (<a:n>) и помещаем html в объект

	PluginPasteCleanTree(oBuffer, false); // начинаем чистку

	html = oBuffer.innerHTML; // получаем чистый html

// дополнительные подчистки
//	html = html.replace(/<p\ ?>&nbsp;<\/p>/gi, "<br />");
	
	return html;
}


/////////////////////
// очистка переданного объекта от "мусора"
/////////////////////
function PluginPasteCleanObject(obj)
{
	var tag = obj.tagName.toLowerCase();

	if(obj.outerHTML.substr(0,2) == "<?") 
		return;

	// Удаление неправильного тега
	if(!PasteGoodTags[tag]) 
	{
		obj.removeNode(false);
		return;
	}

	// Удаление неправильных стилей
	var objPasteGoodStyles = new Object();
	if(PasteGoodStyles[tag])
	{
		for(var gStyle in PasteGoodStyles[tag]) 
		{
			if(obj.style[gStyle]) 
				objPasteGoodStyles[gStyle] = obj.style[gStyle]; // сохраняем нужные стили
		}
	}

	obj.style.cssText = ""; // убираем все имеющиеся в объекте стили

	for(var nStyle in objPasteGoodStyles) 
		obj.style[nStyle] = objPasteGoodStyles[nStyle]; // ставим нужные стили на место
	
	// Работа с аттрибутами
	if (!obj.attributes) 
		return;

	// Удаление className
	if(obj.className != "")
	{
		var objPasteGoodClasses = new Object();
		var splittedClasses = obj.className.split(" ");
		for(var oClass in splittedClasses)
		{
			if(PasteGoodClasses[splittedClasses[oClass]])
				objPasteGoodClasses[splittedClasses[oClass]] = 1; // сохраняем имена нужных классов
		}

		obj.removeAttribute("className"); // сносим весь класс
		
		var first = true;
		for(var nClasses in objPasteGoodClasses)
		{
			if(!first)
				obj.className += " ";
			obj.className += nClasses; // ставим все нужные классы на место
			first = false;
		}
	}

	// Удаляем ненужные аттрибуты
	for (var name in obj.attributes) 
	{
		var lowerAttr = name.toLowerCase();
		if("" + obj.attributes[name] == "null" || (!PasteGoodAttributes[""][lowerAttr] && (!PasteGoodAttributes[tag] || !PasteGoodAttributes[tag][lowerAttr]) && lowerAttr != "classname"))
			obj.removeAttribute(name);
	}
}

/////////////////////
// Пробегаем по DOM дереву
/////////////////////
function PluginPasteCleanTree(obj, mustClean) 
{
	var children = obj.children;
	if(children) 
	{
		// начинаем чистку с ПОСЛЕДНЕГО children'а во избежани переиндексации массива (в случае  удаления элемента)
		for(var i = children.length - 1; i >= 0; i--)
			PluginPasteCleanTree(children[i], true);
	}

	if(mustClean) PluginPasteCleanObject(obj); // читсим текущий элемент
}