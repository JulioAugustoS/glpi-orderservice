<?php

class PluginOrderServiceConfig extends CommonDBTM {

    static protected $notable = true;

    /**
     * @see CommonGLPI::getMenuName()
     */
    static function getMenuName(){

        return __('Ordem de Serviço');

    }

    static function getMenuContent(){

        global $CFG_GLPI;

        $menu = array();
        $menu['title']  = __('Ordem de Serviço', 'orderservice');
        $menu['page']   = "/plugins/orderservice/front/config/config.php";
        return $menu;

    }
 
}    

    function plugin_init_orderservice(){

        global $PLUGIN_HOOKS, $LANG;

        $PLUGIN_HOOKS['menu_entry']['orderservice'] = true;
        $PLUGIN_HOOKS['csrf_compliant']['orderservice'] = true;
        $PLUGIN_HOOKS["menu_toadd"]['orderservice'] = array('plugins' => 'PluginOrderServiceConfig');
        $PLUGIN_HOOKS['config_page']['orderservice'] = 'front/config/config.php';

    }

    function plugin_version_orderservice(){

        global $DB, $LANG;
        
        return array(
            'name'                  => __('Ordem de Serviço', 'orderservice'),    
            'version'               => '0.1.2',    
            'author'                => '<a href="mailto:contato@julioaugusto.me">Julio Augusto</a>',
            'license'               => 'GPLv2+',
            'homepage'              => 'http://glpi-relatorios.sourceforge.net',
            'minGlpiVersion'        => '0.85'
        );

    }

    function plugin_orderservice_check_prerequisites(){

        if(GLPI_VERSION >= 0.85):
            return true;
        else:
            echo "GLPI version NOT compatible. Requires GLPI 0.85";
        endif;

    }

    function plugin_orderservice_check_config($verbose = false){

        if($verbose):
            echo 'Installed / not configured';
        else:
            return true;
        endif;     
           
    }