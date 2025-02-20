CKEDITOR.plugins.add( 'customlinks', {
    icons: 'customlinks',
    init: function( editor ) {
        editor.addCommand( 'customlinks', new CKEDITOR.dialogCommand( 'customlinksDialog' ) );
        editor.ui.addButton( 'Customlinks', {
            label: 'Добавить кастомный элемент из модуля страницы',
            command: 'customlinks',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'customlinksDialog', function( editor ) {
            return {
                title: 'Добавить кастомный элемент из модуля страницы',
                minWidth: 600,
                minHeight: 200,
                onOk: function() {
                    var dialog = this;

                    var link_id = dialog.getValueOf('tab-basic', 'link_id');
                    var type = dialog.getValueOf('tab-basic', 'type');

                    var elementType = '';
                    switch (type) {
                        case 'Аккордеон':
                            elementType = 'ACCORDION_LIST';
                            break;
                        case 'Выпадающий список':
                            elementType = 'COMBOBOX_LIST';
                            break;
                        case 'Список скрытых под кнопкой элементов':
                            elementType = 'COLLAPSED_LIST';
                            break;
                        default:
                            elementType = '';
                    }

                    editor.insertHtml('['+ elementType + '_' + link_id +']');
                },
                contents: [
                    {
                        id: 'tab-basic',
                        label: 'Основные настройки',
                        elements: [
                            {
                                type: 'html',
                                html: '<iframe style="width: 100%; height: 300px" src="/dreamedit/includes/ckeditor/plugins/customlinks/fck_customlinks.php"></iframe>'
                            },
                            {
                                type: 'text',
                                id: 'link_id',
                                label: 'ID страницы:'
                            },
                            {
                                type: 'select',
                                id: 'type',
                                label: 'Тип элемента:',
                                items: [ [ 'Аккордеон' ], [ 'Выпадающий список' ], [ 'Список скрытых под кнопкой элементов' ]],
                                'default': 'Аккордеон'
                            }
                        ]
                    }
                ]
            };
        });
    }
});