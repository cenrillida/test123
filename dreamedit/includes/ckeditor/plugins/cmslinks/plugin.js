CKEDITOR.plugins.add( 'cmslinks', {
    icons: 'cmslinks',
    init: function( editor ) {
        editor.addCommand( 'cmslinks', new CKEDITOR.dialogCommand( 'cmslinksDialog' ) );
        editor.ui.addButton( 'Cmslinks', {
            label: '�������� ������ �� ��������',
            command: 'cmslinks',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'cmslinksDialog', function( editor ) {
            return {
                title: '�������� ������ �� ��������',
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
                        label: '�������� ���������',
                        elements: [
                            {
                                type: 'html',
                                html: '<iframe style="width: 100%; height: 300px" src="/dreamedit/includes/ckeditor/plugins/cmslinks/fck_cmslinks.php"></iframe>'
                            },
                            {
                                type: 'text',
                                id: 'link_text',
                                label: '����� ������:'
                            },
                            {
                                type: 'text',
                                id: 'link_url',
                                label: '������:'
                            },
                            {
                                type: 'checkbox',
                                id: 'english',
                                label: '���������� ������:',
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