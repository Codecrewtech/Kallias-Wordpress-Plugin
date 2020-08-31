//console.log('ceva');
jQuery(document).ready(function($){
    $('#wp-content-media-buttons').append('<a title="add a Scroller Gallery" class="shortcode_opener" id="dzssg_shortcode" style="cursor:pointer; display: inline-block; vertical-align: middle; background-size:cover; background-repeat: no-repeat; background-position: center center; width:28px; height:28px; background-image: url('+dzssg_settings.thepath+'tinymce/img/shortcodes-small-retina.png);"></a>');
    $('#dzssg_shortcode').bind('click', function(){
        $.fn.zoomBox.open(dzssg_settings.thepath + 'tinymce/popupiframe.php?iframe=true', 'iframe', {width: 700, height: 500});
    });
})