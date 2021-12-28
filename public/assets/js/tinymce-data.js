(function ($) {
    'use strict';
    tinymce.init({
        selector: '#tinymce',
        menubar: false,
        height: 600,
        // plugins: [
        //     'advlist autolink lists link image charmap print preview anchor textcolor',
        //     'searchreplace visualblocks code fullscreen',
        //     'insertdatetime media table contextmenu paste code help wordcount'
        // ],
        // toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        toolbar: 'undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'],
        init_instance_callback: function(editor) {
            editor.on('keydown', function(e) {
                if(editor.getContent({format: 'text'}) === '\n') {
                    nCharacters = 0;
                }else{
                    nCharacters = editor.getContent({format: 'text'}).length;
                }
                document.getElementById('nCharacters').innerHTML = nCharacters;
                rate = (price/nCharacters * 1000).toFixed(2);
                document.getElementById('rate').innerHTML = rate;
            });
        }
    });

})(window.jQuery);