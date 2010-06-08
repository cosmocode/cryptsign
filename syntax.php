<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <gohr@cosmocode.de>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_cryptsign extends DokuWiki_Syntax_Plugin {

    /**
     * What kind of syntax are we?
     */
    function getType(){
        return 'substition';
    }

    /**
     * What about paragraphs?
     */
    function getPType(){
        return 'normal';
    }

    /**
     * Where to sort in?
     */
    function getSort(){
        return 155;
    }


    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{[^{]+\$\$[a-f0-9]{32}--.+?\$\$\}\}',$mode,'plugin_cryptsign');
    }


    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
        global $ID;

        $match = substr($match,2,-4);
        $pos   = strrpos($match,'$$');
        $text  = trim(substr($match,0,$pos));
        $sig   = substr($match,$pos+2,32);
        $user  = substr($match,$pos+36);
        $check = md5($ID.$user.trim($text).auth_cookiesalt());
        return array(
                'text'  => $text,
                'user'  => $user,
                'valid' => ($sig == $check)
               );
    }

    /**
     * Create output
     */
    function render($format, &$R, $data) {
        if($format != 'xhtml') return false;

        $user = strip_tags(editorinfo($data['user']));

        if($data['valid']){
            $msg = sprintf($this->getLang('valid'),$user);
            $R->doc .= '<span class="sig_valid" title="'.$msg.'">';
        }else{
            $msg = sprintf($this->getLang('invalid'),$user);
            $R->doc .= '<span class="sig_invalid" title="'.$msg.'">';
        }

        $R->cdata($data['text']);
        $R->doc .= '</span>';

        return true;
    }

}

//Setup VIM: ex: et ts=4 enc=utf-8 :
