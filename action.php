<?php
/**
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_cryptsign extends DokuWiki_Action_Plugin {

    /**
     * Register its handlers with the DokuWiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('DOKUWIKI_STARTED', 'AFTER',  $this, '_adduser');
    }

    /**
     * export username to JS
     */
    function _adduser(&$event, $param) {
        if (!isset($_SERVER['REMOTE_USER'])) {
            return;
        }
        global $JSINFO;
        $JSINFO['user'] = $_SERVER['REMOTE_USER'];
    }
}
