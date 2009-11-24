
/**
 * Append a toolbar button
 */
if(window.toolbar != undefined && JSINFO['user']){
    toolbar[toolbar.length] = {"type":  "pluginsign",
                               "title": LANG['plugins']['cryptsign']['button'],
                               "icon":  DOKU_BASE+"lib/plugins/cryptsign/button.png",
                               "key":   ""};
}

/**
 * Callback for inserting the signed text
 */
function pluginsign(){
    var data = this.response;
    insertAtCarret(this.__edid, data);
}

/**
 * Ask for the text to sign and send a sign request via AJAX
 */
function tb_pluginsign(btn, props, edid) {
    var sel = getSelection($(edid));

    var text = prompt(LANG['plugins']['cryptsign']['prompt'],sel.getText());
    if(!text) return;

    var id = $(edid).form.id.value; // current page ID

    var ajax = new sack(DOKU_BASE+'lib/plugins/cryptsign/sign.php');
    ajax.AjaxFailedAlert = '';
    ajax.encodeURIString = false;
    ajax.onCompletion = pluginsign;
    ajax.__edid = edid;  //store the editor area in the ajax object
    ajax.runAJAX(ajax.encVar('text',text)+'&'+ajax.encVar('id',id));
}

