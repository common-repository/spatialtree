<?php 

    add_action('wp_ajax_show_popup', 'wp_spatialtree_show_popup');

    function wp_spatialtree_show_popup(){
        $options = get_option('wp_spatialtree_options');        
?>

    <script type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/spatialtree/assets/js/config.js"></script>
    <script>    
        var webUrl = config.webServerAddr;

        jQuery.ajax({
            type: 'post',
            url: webUrl + '/wordpress/init',
            data: {email: '<?php echo $options['username']; ?>' , pass: '<?php echo $options['password']; ?>' }
        }).done(function(res){

            var ed = tinymce.activeEditor;    
            ed.windowManager.open({ 
                file : webUrl + '/wordpress/index?plugin_code=' + res.plugin_code + '&email=<?php echo $options['username']?>', 
                width : Math.max(jQuery(window).width() * 0.9, 1000) + ed.getLang('wpSpatialTreeArticles.delta_width', 0), 
                height : jQuery(window).height() * 0.9 + ed.getLang('wpSpatialTreeArticles.delta_height', 0), 
                inline : 1, 
                close_previous : true,
                title: 'Spatial Tree'
            }, {});
        });
    </script>

<?php 
}
?>