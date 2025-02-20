var goodTags       = new Object();
var goodAttributes = new Object();
var goodClasses    = new Object();
var goodStyles     = new Object();
var cleanPinsideTD = 0;
var cleanSpaninsideTD = 0;

if(window.HTMLElement){
    HTMLElement.prototype.removeNode = function(removeChildren)
    {
        if (Boolean(removeChildren))
            return this.parentNode.removeChild(this);
        else {
            var r=document.createRange();
            r.selectNodeContents(this);
            return this.parentNode.replaceChild(r.extractContents(),this);
        }
    };
    String.prototype.ltrim = function() {
        return this.replace(/^\s+/,"");
    }

}

function CleanerInit(replaceHtml, need_tags, need_attr, need_attr_other_tags_attr, need_attr_other_tags_tags, need_class_list, good_styles_attr, good_styles_tags, clean_p_inside_td, clean_span_inside_td)
{
    cleanPinsideTD = clean_p_inside_td;
    cleanSpaninsideTD = clean_span_inside_td;
    // инициируем нужные теги
    var splittedTags = need_tags.split(",");
    for (var i in splittedTags)
        goodTags[splittedTags[i].toLowerCase()] = true;

    // инициируем общие нужные аттрибуты
    var splittedArrts = need_attr.split(",");
    goodAttributes[""] = new Object();
    for (var i in splittedArrts)
        goodAttributes[""][splittedArrts[i].toLowerCase()] = true;

    // инициируем отдельные аттрибуты для тегов

    for(var i = 0; i < need_attr_other_tags_attr.length; i++) {
        var splittedAttrTags = need_attr_other_tags_tags[i].value.split(",");
        var splittedAttrAttr = need_attr_other_tags_attr[i].value.split(",");

        for(var tag in splittedAttrTags)
        {
            var lowerAttrTag = splittedAttrTags[tag].toLowerCase();
            if (!goodAttributes[lowerAttrTag]) goodAttributes[lowerAttrTag] = new Object();
            for(var attr in splittedAttrAttr)
                goodAttributes[lowerAttrTag][splittedAttrAttr[attr].toLowerCase()] = true;
        }
    }


    // инициируем общие нужные классы
    var splittedClasses = need_class_list.split(",");
    for (var i in splittedClasses)
        goodClasses[splittedClasses[i]] = true;


    // инициируем отдельные стили для тегов
    for(var i = 0; i < good_styles_attr.length; i++) {
        var splittedStyleTags = good_styles_tags[i].value.split(",");
        var splittedStyleAttr = good_styles_attr[i].value.split(",");

        for(var tag in splittedStyleTags)
        {
            if (!goodStyles[splittedStyleTags[tag]]) goodStyles[splittedStyleTags[tag]] = new Object();
            for(var attr in splittedStyleAttr) goodStyles[splittedStyleTags[tag]][splittedStyleAttr[attr]] = true;
        }

    }


    return Cleaner(replaceHtml);
}


//
// очистка переданного объекта
//
function CleanObject(obj,tdRule)
{
    var tag = obj.tagName.toLowerCase();




    if((obj.outerHTML != null)&&(obj.outerHTML.substr(0,2) == "<?"))
        return;

    //        try{
    //				if(obj.innerHTML.ltrim().substr(1,3) == "!--")
    //				{
    //					obj.innerHTML = "";
    //				}
    //			}
    ///			catch(exc)
    //			{
    //			}


    // Удаление неправильного тега
    if(tdRule && tag=="span" && !cleanSpaninsideTD) {

    } else {
        if (!goodTags[tag]) {
            obj.removeNode(false);
            return;
        }
    }

    // Удаление неправильных стилей
    var objGoodStyles = new Object();
    if(goodStyles[tag])
    {
        for(var gStyle in goodStyles[tag])
        {
            if(obj.style[gStyle])
                objGoodStyles[gStyle] = obj.style[gStyle]; // сохраняем нужные стили
        }
    }

    if(tdRule && tag=="span") {
        objGoodStyles["font-size"] = obj.style["font-size"];
    }

    obj.style.cssText = ""; // убираем все имеющиеся в объекте стили

    for(var nStyle in objGoodStyles)
        obj.style[nStyle] = objGoodStyles[nStyle]; // ставим нужные стили на место

    // Работа с аттрибутами
    if (!obj.attributes)
        return;


    // Удаление className
    if(obj.className != "")
    {
        var objGoodClasses = new Object();
        var splittedClasses = obj.className.split(" ");
        for(var oClass in splittedClasses)
        {
            if(goodClasses[splittedClasses[oClass]])
                objGoodClasses[splittedClasses[oClass]] = 1; // сохраняем имена нужных классов
        }

        //alert("Было:"+obj.className);
        obj.removeAttribute("className"); // сносим весь класс
        obj.className = "";
        //alert("Стало:"+obj.className);

        var first = true;
        for(var nClasses in objGoodClasses)
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
        if("" + obj.attributes[name] == "null" || (!goodAttributes[""][lowerAttr] && (!goodAttributes[tag] || !goodAttributes[tag][lowerAttr]) && lowerAttr != "classname"))
        {
            obj.removeAttribute(name);
        }
    }
}

/////////////////////
// чистка DOM дерева
////////////////////
function CleanTree(obj, mustClean, tdRule = false)
{
    var children = obj.children;
    if(children)
    {
        // начинаем чистку с ПОСЛЕДНЕГО children'а во избежани переиндексации массива (в случае  удаления элемента)
        for(var i = children.length - 1; i >= 0; i--)
        {
            if(children[i].tagName.toLowerCase() == "p" && obj.tagName.toLowerCase() == "td" && !cleanPinsideTD) {
                CleanTree(children[i], false, true);
            } else {
                if(tdRule) {
                    CleanTree(children[i], true,tdRule);
                } else {
                    CleanTree(children[i], true);
                }
            }
        }
    }
    if(tdRule) {
        if (mustClean) CleanObject(obj,tdRule);
    } else {
        if (mustClean) CleanObject(obj); // читсим текущий элемент
    }
}


/////////////////////
// Запуск чистильщика
/////////////////////
function Cleaner(html)
{
    var oBuffer = document.createElement("DIV"); // создаем объект для нашего кода

    oBuffer.innerHTML = html.replace(/<\/?\w+:\w+\s*[^>]*>/gi, ""); // уничтожаем "не" теги (<a:n>) и помещаем html в объект
    oBuffer.innerHTML = oBuffer.innerHTML.replace(/<![ \r\n\t]*(--([^\-]|[\r\n]|-[^\-])*--[ \r\n\t]*)\>/gi,"");


    CleanTree(oBuffer, false); // начинаем чистку

    html = oBuffer.innerHTML; // получаем чистый html

    // дополнительные подчистки
    //	html = html.replace(/<p\ ?>&nbsp;<\/p>/gi, "<br />");

    html = html.replace(/(style=""\ ?)/gi, "");
    html = html.replace(/(class=""\ ?)/gi, "");
    html = html.replace(/\<i \>\<\/i\>/gi, "&nbsp;");
    html = html.replace(/\<i\>\<\/i\>/gi, "&nbsp;");

    return html;
}



/////////////////////
// Добавление нового нужного эл-та в один из двойных блоков
/////////////////////



function addElements(tags, attr, idPref)
{
    var tagsBlock = tags;
    var attrBlock = attr;

    //var i = tags.getElementsByClassName("someGoodAttr_Tag").length;

    //	<input type="text" id="someGoodAttr_Tag0" value="img" style="WIDTH: 100px;" /><br />
    var tagsInput = document.createElement("INPUT");
    tagsInput.type = "text";
    tagsInput.className = "cke_dialog_ui_input_text " + idPref + "_Tag";
    tagsInput.style.width = "100px";

    //	<input type="text" id="someGoodAttr_Attr0" value="align,alt,src" style="WIDTH: 286px;" /><br />
    var attrInput = document.createElement("INPUT");
    attrInput.type = "text";
    attrInput.className = "cke_dialog_ui_input_text " + idPref + "_Attr";
    attrInput.style.width = "100%";

    tagsBlock.appendChild(tagsInput);
    tagsBlock.innerHTML += "<br />";
    attrBlock.appendChild(attrInput);
    attrBlock.innerHTML += "<br />";

    return false;
}


/////////////////////
// Получить элемент по ID
/////////////////////
function GetE( elementId )
{
    return document.getElementsByClassName( elementId )[0]  ;
}


CKEDITOR.dialog.add( 'cleantagsDialog', function( editor ) {
    return {
        title: 'Расширенная чистка тегов',
        minWidth: 600,
        minHeight: 200,
        onOk: function() {
            var dialog = this;

            var data_tags = "";

            var clean_zone = dialog.getValueOf( 'tab-adv', 'clean_zone' );

            var func = function (data_tags) {
                //var div = editor.document.createElement( 'div' );

                //div.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'attr_list' ) );
                //div.setText( dialog.getValueOf( 'tab-basic', 'abbr' ) );
                var need_tags = dialog.getValueOf( 'tab-basic', 'abbr' );
                var need_attr = dialog.getValueOf( 'tab-basic', 'attr_list' );
                var need_attr_other_tags_attr = dialog.getElement()["$"].getElementsByClassName('someGoodAttr_Attr');
                var need_attr_other_tags_tags = dialog.getElement()["$"].getElementsByClassName('someGoodAttr_Tag');
                var need_class_list = dialog.getValueOf( 'tab-basic', 'class_list' );
                var good_styles_attr = dialog.getElement()["$"].getElementsByClassName('goodStyles_Attr');
                var good_styles_tags = dialog.getElement()["$"].getElementsByClassName('goodStyles_Tag');
                var tag_p_inside_td = dialog.getValueOf( 'tab-adv', 'clean_p_inside_td' );
                var tag_span_inside_td = dialog.getValueOf( 'tab-adv', 'clean_span_inside_td' );

                return CleanerInit(data_tags,need_tags,need_attr,need_attr_other_tags_attr,need_attr_other_tags_tags,need_class_list,good_styles_attr,good_styles_tags,tag_p_inside_td,tag_span_inside_td);
                //editor.insertElement( div );
            };

            if(clean_zone=="Selected") {
                data_tags = editor.getSelectedHtml(true);
                new_html = func(data_tags);

                editor.insertHtml(new_html);
            }
            if(clean_zone=="All") {
                data_tags = editor.getData();
                new_html = func(data_tags);

                editor.setData(new_html);
            }


        },
        contents: [
            {
                id: 'tab-basic',
                label: 'Основные настройки',
                elements: [
                    {
                        type: 'textarea',
                        id: 'abbr',
                        label: 'Список нужных тегов:',
                        'default': 'a,p,br,strong,b,em,i,u,strike,ul,ol,li,img,table,tr,th,td,small,big,sub,sup'
                    },
                    {
                        type: 'text',
                        id: 'attr_list',
                        label: 'Список нужных аттрибутов:',
                        'default': 'title,alt,align'
                    },
                    {
                        type: 'hbox',
                        widths: [ '25%', '25%' ],
                        children: [
                            {
                                type: 'html',
                                html: '<div>Список нужных аттрибутов для отдельных тегов:</div>',
                            },
                            {
                                type: 'button',
                                id: 'addRowAttr',
                                label: 'Добавить строку',
                                title: 'Добавить строку',
                                onClick: function() {
                                    // this = CKEDITOR.ui.dialog.button

                                    addElements(document.getElementById(this.domId).closest('.cke_dialog_contents_body').getElementsByClassName('someGoodAttrTags')[0],document.getElementById(this.domId).closest('.cke_dialog_contents_body').getElementsByClassName('someGoodAttrAttr')[0],'someGoodAttr');
                                }
                            }
                        ]
                    },
                    {
                        type: 'html',
                        html: '<table width="100%" style="margin: 0; width: 100%"><tr><td style="width: 100px" width="100"><div class="someGoodAttrTags"><span fckLang="DlgCleanTagsTags">Теги:</span><br /><input class="cke_dialog_ui_input_text someGoodAttr_Tag" type="text" value="img" style="WIDTH: 100px;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Tag" type="text" value="table" style="WIDTH: 100px;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Tag" type="text" value="th,td,tr" style="WIDTH: 100px;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Tag" type="text" value="a" style="WIDTH: 100px;" /><br /></div></td><td><div class="someGoodAttrAttr"><span fckLang="DlgCleanTagsAttr">Аттрибуты:</span><br /><input class="cke_dialog_ui_input_text someGoodAttr_Attr" type="text" value="src,width,height,hspace,vspace" style="WIDTH: 100%;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Attr" type="text" value="cellspacing,cellpadding,width,height" style="WIDTH: 100%;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Attr" type="text" value="colspan,rowspan,nowrap,valign" style="WIDTH: 100%;" /><br /><input class="cke_dialog_ui_input_text someGoodAttr_Attr" type="text" value="href,target" style="WIDTH: 100%;" /><br /></div></td></tr></table>'
                    },
                    {
                        type: 'text',
                        id: 'class_list',
                        label: 'Список нужных классов:'
                    },
                    {
                        type: 'hbox',
                        widths: [ '25%', '25%' ],
                        children: [
                            {
                                type: 'html',
                                html: '<div>Список нужных стилей:</div>',
                            },
                            {
                                type: 'button',
                                id: 'addRowStyles',
                                label: 'Добавить строку',
                                title: 'Добавить строку',
                                onClick: function() {
                                    // this = CKEDITOR.ui.dialog.button

                                    addElements(document.getElementById(this.domId).closest('.cke_dialog_contents_body').getElementsByClassName('goodStylesTags')[0],document.getElementById(this.domId).closest('.cke_dialog_contents_body').getElementsByClassName('goodStylesAttr')[0],'goodStyles');
                                }
                            }
                        ]
                    },
                    {
                        type: 'html',
                        html: '<table width="100%" style="margin: 0; width: 100%"><tr><td style="width: 100px" width="100"><div class="goodStylesTags"><span fckLang="DlgCleanTagsTags">Теги:</span><br /><input class="cke_dialog_ui_input_text goodStyles_Tag" type="text" value="p" style="WIDTH: 100px;" /><br /><input class="cke_dialog_ui_input_text goodStyles_Tag" type="text" value="table,tr,td,th" style="WIDTH: 100px;" /><br /></div></td><td><div class="goodStylesAttr"><span fckLang="DlgCleanTagsAttr">Аттрибуты:</span><br /><input class="cke_dialog_ui_input_text goodStyles_Attr" type="text" value="" style="WIDTH: 100%;" /><br /><input class="cke_dialog_ui_input_text goodStyles_Attr" type="text" value="border,border-left,border-right,border-bottom,border-top,border-collapse,width,height" style="WIDTH: 100%;" /><br /></div></td></tr></table>'
                    }
                ]
            },
            {
                id: 'tab-adv',
                label: 'Дополнительные настройки',
                elements: [
                    {
                        type: 'radio',
                        id: 'clean_zone',
                        label: 'Область чистки:',
                        items: [ [ 'Всё', 'All' ], [ 'Выделенное', 'Selected' ] ],
                        'default': 'All'
                    },
                    {
                        type: 'checkbox',
                        id: 'clean_p_inside_td',
                        label: 'Очистить тег p внутри таблицы'
                    },
                    {
                        type: 'checkbox',
                        id: 'clean_span_inside_td',
                        label: 'Очистить тег span внутри таблицы без сохранения размера шрифта'
                    }
                ]
            }
        ]
    };
});