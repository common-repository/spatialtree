(function($) {

    tinymce.create('tinymce.plugins.wpSpatialTree', {
        init: function(ed, url) {
        var theUrl = url;

            ed.addCommand('mcewpSpatialTreeArticles', function() { 

                jQuery.ajax({
                    url: ajaxurl,
                    data : { action: 'show_popup' },
                    type: 'GET'
                })                    
                .done(function(a){
                    
                    jQuery('body').append(a);
                });
            });

            window.addEventListener('message', recieveMessage, false);

            ed.addButton('wpSpatialTreeArticles', { 
                type : 'button',
                text : 'SpatialTree',
                cmd : 'mcewpSpatialTreeArticles', 
                icon : 'icon spatialtree-own-icon'
            });
            ed.onNodeChange.add(function(ed, cm, n) { cm.setActive('wpSpatialTreeArticles', n.nodeName == 'IMG'); });  
        },
        getInfo: function() {
            return { longname: 'wpSpatialTree', author: '', authorurl: '', infourl: '', version: "1.0" };
        }
    });
    tinymce.PluginManager.add('wpSpatialTree', tinymce.plugins.wpSpatialTree);
})();

function recieveMessage(e){

    if(e.origin != config.webServerAddr)
        return;

    var msgArray = e.data.split(' ');
    console.log('Message recieved: ' + msgArray);

    if(msgArray.length != 2)
        return;

    if(msgArray[0] == 'IMAGE'){

        if (window.tinyMCE.majorVersion >= "4") {
            window.tinyMCE.execCommand('mceInsertRawHTML', false, imageTag(msgArray[1]));
            window.tinyMCE.execCommand('mceRepaint');
            parent.tinyMCE.activeEditor.windowManager.close(window);
        } else {
           // window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, data);
           // tinyMCEPopup.editor.execCommand('mceRepaint');
           // tinyMCEPopup.close();
        }	
    }
}

function imageTag(url){
    var tag = '<img src="' + url + '"/>';
    return tag;
}
