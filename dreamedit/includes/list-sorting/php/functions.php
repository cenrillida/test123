<?
function listSorting($variable, $data)
{
	// Удаляем пустые элементы
	foreach ($data as $k => $v) 
	{
		if(empty($v))
			unset($data[$k]);
	}

	if(!count($data)) 
		return false;

?>
	<script>
		var dragsort = ToolMan.dragsort();
		var junkdrawer = ToolMan.junkdrawer();

		if(window.HTMLElement)
			window.addEventListener("load", eventOnLoad, false);
		else
			window.attachEvent("onload", eventOnLoad);

		function eventOnLoad()
		{
			junkdrawer.restoreListOrder("<?=$variable?>");
			dragsort.makeListSortable(document.getElementById("<?=$variable?>"), verticalOnly, saveOrder);		
		}

		function verticalOnly(item) {
			item.toolManDragGroup.verticalOnly();
		}

		function saveOrder(item) {
			var group = item.toolManDragGroup;
			var list = group.element.parentNode;
			var id = list.getAttribute("id");
			if (id == null) 
				return;
			group.register('dragend', function() {
				ToolMan.cookies().set("list-" + id, junkdrawer.serializeList(list), 365)
			})
		}

	</script>
<?

	echo "<ul id=\"".$variable."\" class=\"list-sorting\">\n";
	foreach($data as $id => $item)
		echo "<li itemID=\"".$id."\">".$item."</li>\n";
	echo "</ul>\n";
} 
?>