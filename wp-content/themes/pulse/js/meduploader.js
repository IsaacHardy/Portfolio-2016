jQuery(document).ready(function($) {
    $(document).on("click", ".upload_image_bio", function(e) {
        var el = $(this).parent();
        e.preventDefault();

        var uploader = wp.media({
            title: 'send a picture',
            button: {
                text: 'choose an image'
            },
            multiple: false
        }).on('select', function() {
            var selection = uploader.state().get('selection');
            var attachement = selection.first().toJSON();
            $('#urlpic', el).val(attachement.url);
            $('.upload_image_bio', el).attr('src', attachement.url);
        })
                .open();
    });
    
    $(document).on("click", ".upload_ourteam", function(e) {
        var el = $(this).parent();
        e.preventDefault();

        var uploader = wp.media({
            title: 'send a picture',
            button: {
                text: 'choose an image'
            },
            multiple: false
        }).on('select', function() {
            var selection = uploader.state().get('selection');
            var attachement = selection.first().toJSON();
            $('#urlteampic', el).val(attachement.url);
        })
                .open();
    });
    
    $(document).on("click", ".upload_ourclient", function(e) {
        var el = $(this).parent();
        e.preventDefault();

        var uploader = wp.media({
            title: 'send a picture',
            button: {
                text: 'choose an image'
            },
            multiple: false
        }).on('select', function() {
            var selection = uploader.state().get('selection');
            var attachement = selection.first().toJSON();
            $('#urlclientpic', el).val(attachement.url);
        })
                .open();
    });
});