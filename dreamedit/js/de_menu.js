// скорость открытия меню
var speed = 5;
// текущий статус меню
var isOpen  = 0;

var timeout = null;

function menuInit()
{
	var menuObj = getObj("menu_block");
	menuObj.onmouseover = slideInit;
	menuObj.onmouseout  = slideInit;

	var menuChilds = menuObj.getElementsByTagName("IMG");
	for(var i = 0; i < menuChilds.length; i++)
	{
		menuChilds[i].cancelBubble;
	}
}

function slideInit()
{
	clearTimeout(timeout);

	if(isOpen)
	{
		isOpen = 0;
		timeout = setTimeout("slideMenu(0, -35)", 1000);
	}
	else
	{
		isOpen = 1;
		slideMenu(-35, 0);
	}
}

function slideMenu(sLeft, fLeft)
{
	if(sLeft != fLeft)
	{
		if(sLeft > fLeft)
			sLeft -= speed;
		else
			sLeft += speed;

		getObj("menu_block").style.left = sLeft;
		timeout = setTimeout("slideMenu(" + sLeft + ", " + fLeft + ")", 0);
	}
	return;
}