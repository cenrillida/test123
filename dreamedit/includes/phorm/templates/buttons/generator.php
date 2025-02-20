<?
global $_CONFIG;

if($_GET[debug]==5) {
    var_dump($generate_fields);
}

echo "<img src=\"".$_CONFIG["global"]["paths"]["skin_path"]."images/buttons/".$btnName.".png\" onclick=\"buttons_".$name."_".$btnName."()\" style=\"CURSOR: hand; CURSOR: pointer;\" align=\"absmiddle\" alt=\"".Dreamedit::translate("Сгенерировать адрес")."\" title=\"".Dreamedit::translate("Сгенерировать адрес")."\" width=\"17\" height=\"17\" />";
?>

<script>
function buttons_<?=$name."_".$btnName?>()
{

    var obj = "";
    var latName = "";

    <?php foreach ($generate_fields as $generate_field):?>

    obj = getObj('<?=$generate_field?>').value;

    if(latName === "" && obj !== "") {
        latName = cyrToLat(obj);
    }

    <?php endforeach;?>

    latName = latName.replace(/\(/g, "-");
    latName = latName.replace(/\)/g, "-");
    latName = latName.replace(/[^a-zA-Z-\d ]/g,"");
    latName = latName.replace(/ +/g," ");
    latName = latName.trim();
    latName = latName.replace(/ /g, "-");
    latName = latName.replace(/-+/g, "-");
    latName = latName.replace(/^-+|-+$/g,'');
    latName = latName.toLowerCase();
    latName = cyrToLatExcl(latName);

    getObj('<?=$name?>').value = latName;

}

function cyrToLat(text) {
    var cyr = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
        'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
        'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
        'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'];
    var lat = [
        'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
        'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
        'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
        'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
    ];
    var latText = replaceBulk(text, cyr, lat);
    return latText;
}

function cyrToLatExcl(text) {
    var exclArr = {
        'dinkin':'dynkin',
        'voytolovsk': 'voitolovsk',
        'voitolovskiy': 'voitolovsky',
        'fedor': 'feodor',
        'fiodor': 'feodor'
    };


    for (var key in exclArr) {
        text = text.replace(key, exclArr[key]);
    }

    return text;
}

function replaceBulk( str, findArray, replaceArray ){
    var i, regex = [], map = {};
    for( i=0; i<findArray.length; i++ ){
        regex.push( findArray[i].replace(/([-[\]{}()*+?.\\^$|#,])/g,'\\$1') );
        map[findArray[i]] = replaceArray[i];
    }
    regex = regex.join('|');
    str = str.replace( new RegExp( regex, 'g' ), function(matched){
        return map[matched];
    });
    return str;
}
</script>