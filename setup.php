<?php

/*
 * @version $Id: setup.php 19 2018-08-20 09:19:05Z walid $
 LICENSE

  This file is part of the orderservice plugin.

 Order plugin is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 Julio Augusto; either version 2 of the License, or
 (at your option) any later version.

 Order plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI; along with itilcategorygroups. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 @package   orderservice
 @author    Julio Augusto
 @copyright Copyright (c) 2018 Julio Augusto
 @license   GPLv3
            http://www.gnu.org/licenses/gpl.txt
 @link      https://github.com/JulioAugustoS/glpiorderservice
 @link      http://www.glpi-project.org/
 @since     2018
 --------------------------------------------------------------------------
 */

include ('inc/orderservice.class.php');

define("PLUGIN_ORDERSERVICE_VERSION", "2.0.0");

if(!defined("PLUGIN_ORDERSERVICE_DIR")){
    define("PLUGIN_ORDERSERVICE_DIR", GLPI_ROOT . "/plugins/orderservice");
}

class PluginOrderServiceConfig extends PluginOrderService {

    static protected $notable = true;

    /**
     * @see CommonGLPI::getMenuName()
     */
    static function getMenuName(){

        return __('Ordem de Serviço');

    }

    /**
     * @name getMenuContent
     * @return $menu
     */
    static function getMenuContent(){

        global $CFG_GLPI;

        $menu = array();
        $menu['title']  = __('Ordem de Serviço', 'orderservice');
        $menu['page']   = "/plugins/orderservice/front/config.form.php";

        return $menu;

    }

    /*
    /**
     * @name showForTicket
     */
    static function showForTicket(){

        global $CFG_GLPI, $DB;
        $id = $_REQUEST['id'];

        $ticketOpen = new PluginOrderService();
        $ticketOpen->printOsTicketOpen($id, 2);

    }

    /**
     * @name getTabNameForItem
     * @param String $item
     * @param Int $withtemplate
     * @return array
     */
    function getTabNameForItem(CommonGLPI $item, $withtemplate = 0){

        if($item->getType() == 'Ticket'
            && $_SESSION['glpiactiveprofile']['interface'] == 'central'){
            return __('Imprimir OS', 'orderservice');
        }

        return '';

    }

    /**
     * @name displayTabContentForItem
     * @param String $item
     * @param Int $tabnum
     * @param Int $withtemplate
     * @return boolean
     */
    static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0){

        if($item->getType() == 'Ticket'){
            self::showForTicket($item);
        }

        return true;

    }
 
}   

/** FUNÇÕES OBRIGATÓRIAS */

/**
 * @name plugin_init_orderservice
 * @access public
 */
function plugin_init_orderservice(){

    global $PLUGIN_HOOKS, $LANG;

    $PLUGIN_HOOKS['menu_entry']['orderservice'] = true;
    $PLUGIN_HOOKS['csrf_compliant']['orderservice'] = true;

    Plugin::registerClass('PluginOrderServiceConfig', 
                            ['addtabon' => ['Ticket']]);

    $PLUGIN_HOOKS["menu_toadd"]['orderservice'] = array('plugins' => 'PluginOrderServiceConfig');
    $PLUGIN_HOOKS['config_page']['orderservice'] = 'front/config.form.php';
    $PLUGIN_HOOKS['add_javascript']['orderservice'] = 'assets/js/jquery.min.js';
    $PLUGIN_HOOKS['add_javascript']['orderservice'] = 'assets/js/jquery.maskedinput.js';
    $PLUGIN_HOOKS['add_javascript']['orderservice'] = 'assets/js/functions.js';
    $PLUGIN_HOOKS['add_css']['orderservice']        = 'assets/css/style.css';

}

/**
 * @name plugin_version_orderservice
 * @access public
 */
function plugin_version_orderservice(){

    global $DB, $LANG;
    
    return array(
        'name'                  => __('Ordem de Serviço', 'orderservice'),    
        'version'               => PLUGIN_ORDERSERVICE_VERSION,    
        'author'                => '<a href="mailto:contato@julioaugusto.me">Julio Augusto</a>',
        'license'               => 'GPLv3',
        'homepage'              => 'https://github.com/JulioAugustoS/glpiorderservice',
        'minGlpiVersion'        => '9.2'
    );

}

/**
 * @name plugin_orderservice_check_prerequisites
 * @access public
 */
function plugin_orderservice_check_prerequisites(){

    if(GLPI_VERSION >= 9.2):
        return true;
    else:
        echo "GLPI version NOT compatible. Requires GLPI 9.2";
    endif;

}

/**
 * @name plugin_orderservice_check_config
 * @access public  
 */
function plugin_orderservice_check_config($verbose = false){

    if($verbose):
        echo 'Installed / not configured';
    else:
        return true;
    endif;     
       
}