
//start part four
function apfaddpost(posttitle,postcontent) {
 
    jQuery.ajax({
 
        type: 'POST',
 
        url: apfajax.ajaxurl,
 
        data: {
            action: 'apf_addpost',
            apftitle: posttitle,
            apfcontents: postcontent
        },
 
        success: function(data, textStatus, XMLHttpRequest) {
            var id = '#apf-response';
            jQuery(id).html('');
            jQuery(id).append(data);
 
            resetvalues();
        },
 
        error: function(MLHttpRequest, textStatus, errorThrown) {
            alert(errorThrown);
        }
 
    });
}
 
function resetvalues() {
 
    var title = document.getElementById("apftitle");
    title.value = '';
 
    var content = document.getElementById("apfcontents");
    content.value = '';
 
}
//end part four