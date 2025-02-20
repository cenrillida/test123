CKEDITOR.plugins.add( 'citefooter', {
    icons: 'citefooter',
    init: function( editor ) {
        editor.addCommand( 'citefooter', new CKEDITOR.dialogCommand( 'citefooterDialog' ) );
        editor.ui.addButton( 'Citefooter', {
            label: 'Добавить footer в цитату',
            command: 'citefooter',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'citefooterDialog', function( editor ) {
            return {
                title: 'footer в цитату',
                minWidth: 600,
                minHeight: 200,
                onOk: function() {
                    var dialog = this;
                    var link_text = editor.getSelectedHtml().$.textContent;
                    if(link_text == "") {
                        link_text = dialog.getValueOf('tab-basic', 'link_text');
                    }
                    editor.insertHtml('<footer class="blockquote-footer">' + link_text + '</footer>');
                },
                contents: [
                    {
                        id: 'tab-basic',
                        label: 'Основные настройки',
                        elements: [
                            {
                                type: 'text',
                                id: 'link_text',
                                label: 'Текст'
                            }
                        ]
                    }
                ]
            };
        });
    }
});