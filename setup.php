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
 @license   GPLv2+
            http://www.gnu.org/licenses/gpl.txt
 @link      https://github.com/JulioAugustoS/glpiorderservice
 @link      http://www.glpi-project.org/
 @since     2018
 --------------------------------------------------------------------------
 */

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
            'version'               => '0.1.3',    
            'author'                => '<a href="mailto:contato@julioaugusto.me">Julio Augusto</a>',
            'license'               => 'GPLv2+',
            'homepage'              => 'https://github.com/JulioAugustoS/glpiorderservice',
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