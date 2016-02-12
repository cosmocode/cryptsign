/**
 * Append a toolbar button
 */
if(window.toolbar != undefined &&
   typeof JSINFO.user !== undefined) {
    toolbar[toolbar.length] = {"type":  "pluginsign",
                               "title": LANG.plugins.cryptsign.button,
                               "icon":  DOKU_BASE+"lib/plugins/cryptsign/pix/button.png",
                               "key":   "q"};
}

/**
 * Callback for inserting the signed text
 */
function pluginsign(edid, data){
    insertAtCarret(edid.substr(1), data);
    var sum = jQuery('#edit__summary');
    if (sum.value !== '' && sum.value.lastIndexOf(' ') !== sum.value.length) {
        sum.value += ' ';
    }
    sum.value += LANG.plugins.cryptsign.summary;
}

/**
 * Ask for the text to sign and send a sign request via AJAX
 */
function tb_pluginsign(btn, props, edid) {
    edid = "#" + edid;

    //uncomment the next two lines (and comment the third) to insert the whole text of the page to the prompt
    //var sel = jQuery(edid).val();
    //var text = prompt(LANG['plugins']['cryptsign']['prompt'],sel);
    var text = prompt(LANG['plugins']['cryptsign']['prompt'],"");

    if(!text) return;

    var id = jQuery(edid)[0].form.id.value; // current page ID

    jQuery.post(
        DOKU_BASE+'lib/plugins/cryptsign/sign.php',
        { text:text, id: id},
        function(data) { pluginsign(edid, data); }
    );

}

