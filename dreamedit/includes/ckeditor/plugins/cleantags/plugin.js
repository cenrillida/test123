CKEDITOR.plugins.add( 'cleantags', {
    icons: 'cleantags',
    init: function( editor ) {
        editor.addCommand( 'cleantags', new CKEDITOR.dialogCommand( 'cleantagsDialog' ) );
        editor.ui.addButton( 'Cleantags', {
            label: 'Clean Tags',
            command: 'cleantags',
            toolbar: 'editing'
        });
        CKEDITOR.dialog.add( 'cleantagsDialog', this.path + 'dialogs/cleantags.js' );
    }
});