jQuery(document).ready(function() {

    let wpcf7Elm = document.querySelector( '.wpcf7' );

    wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ) {
        console.log(event);
        let action = jQuery("div#" + event.detail.id).find("form").attr("action");
        let $form = jQuery("<form id=\"dc_form\" action=\"" + action + "\" method=\"POST\"></form>");
        jQuery(event.detail.inputs).each(function(k,v) {
            $form.append("<input type=\"hidden\" name=\"" + v["name"] + "\" value=\"" + v["value"] + "\"/>");
        });
        jQuery(document.body).append($form);
        $form.submit();
    },false);
});