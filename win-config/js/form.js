jQuery(document).ready(function() {

    document.querySelector( '.wpcf7' ).addEventListener( 'wpcf7submit', function( event ) {
        let action = jQuery("div#" + event.detail.id).find("form").attr("action");
        let $form = jQuery("<form id=\"dc_form\" action=\"" + action + "\" method=\"POST\"></form>");
        jQuery(event.detail.inputs).each(function(k,v) {
            $form.append("<input type=\"hidden\" name=\"" + v["name"] + "\" value=\"" + v["value"] + "\"/>");
        });
        jQuery(document.body).append($form);
        $form.submit();
    },false);
});