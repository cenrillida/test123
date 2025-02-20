CKEDITOR.plugins.add( 'customlinks', {
    icons: 'customlinks',
    init: function( editor ) {
        editor.addCommand( 'customlinks', new CKEDITOR.dialogCommand( 'customlinksDialog' ) );
        editor.ui.addButton( 'Customlinks', {
            label: '�������� ��������� ������� �� ������ ��������',
            command: 'customlinks',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'customlinksDialog', function( editor ) {
            return {
                title: '�������� ��������� ������� �� ������ ��������',
                minWidth: 600,
                minHeight: 200,
                onOk: function() {
                    var dialog = this;

                    var link_id = dialog.getValueOf('tab-basic', 'link_id');
                    var type = dialog.getValueOf('tab-basic', 'type');

                    var elementType = '';
                    switch (type) {
                        case '���������':
                            elementType = 'ACCORDION_LIST';
                            break;
                        case '���������� ������':
                            elementType = 'COMBOBOX_LIST';
                            break;
                        case '������ ������� ��� ������� ���������':
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
                        label: '�������� ���������',
                        elements: [
                            {
                                type: 'html',
                                html: '<iframe style="width: 100%; height: 300px" src="/dreamedit/includes/ckeditor/plugins/customlinks/fck_customlinks.php"></iframe>'
                            },
                            {
                                type: 'text',
                                id: 'link_id',
                                label: 'ID ��������:'
                            },
                            {
                                type: 'select',
                                id: 'type',
                                label: '��� ��������:',
                                items: [ [ '���������' ], [ '���������� ������' ], [ '������ ������� ��� ������� ���������' ]],
                                'default': '���������'
                            }
                        ]
                    }
                ]
            };
        });
    }
});