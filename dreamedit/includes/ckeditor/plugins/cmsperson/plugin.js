CKEDITOR.plugins.add( 'cmsperson', {
    icons: 'cmsperson',
    init: function( editor ) {
        editor.addCommand( 'cmsperson', new CKEDITOR.dialogCommand( 'cmspersonDialog' ) );
        editor.ui.addButton( 'Cmsperson', {
            label: 'Добавить персону',
            command: 'cmsperson',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'cmspersonDialog', function( editor ) {
            return {
                title: 'Добавить персону',
                minWidth: 600,
                minHeight: 200,
                onOk: function() {
                    var dialog = this;
                    var link_text = editor.getSelectedHtml().$.textContent;
                    if(link_text == "") {
                        link_text = dialog.getValueOf('tab-basic', 'link_text');
                    }
                    var link_url = dialog.getValueOf('tab-basic', 'link_url');
                    if( dialog.getValueOf('tab-basic', 'english')) {
                        link_url = "/en" + link_url;
                    }
                    var target = dialog.getValueOf('tab-basic', 'target');

                    if(target != "") {
                        target = ' target="' + target + '"';
                    }
                    editor.insertHtml('<a href="' + link_url + '"' + target + '>' + link_text + '</a>');
                },
                contents: [
                    {
                        id: 'tab-basic',
                        label: 'Основные настройки',
                        elements: [
                            {
                                type: 'html',
                                html: '<iframe style="width: 100%; height: 365px" src="/dreamedit/includes/ckeditor/plugins/cmsperson/fck_cmslinks.php"></iframe>'
                            },
                            {
                                type: 'text',
                                id: 'link_text',
                                label: 'Текст ссылки:'
                            },
                            {
                                type: 'text',
                                id: 'link_url',
                                label: 'Ссылка:'
                            },
                            {
                                type: 'checkbox',
                                id: 'english',
                                label: 'Английская версия:',
                                'default': ''
                            },
                            {
                                type: 'select',
                                id: 'target',
                                label: 'Target:',
                                items: [ [ '' ], [ '_blank' ], [ '_top' ], [ '_self' ], [ '_parent' ] ],
                                'default': ''
                            }
                        ]
                    }
                ]
            };
        });
    }
});