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

/**
 * @name plugin_orderservice_install
 * @access public
 * @return boolean
 */
function plugin_orderservice_install(){

    global $DB, $LANG;

    $query_config = "CREATE TABLE IF NOT EXISTS `glpi_plugin_orderservice_config`
                    (
                        `id` int(1) unsigned NOT NULL default '1',
                        `empresa` varchar(255) NOT NULL default '0',
                        `endereco` varchar(255) NOT NULL default '0',
                        `telefone` varchar(50) NOT NULL default '0',
                        `cidade` varchar(255) NOT NULL default '0',
                        `cnpj` varchar(50) NOT NULL default '0',
                        `site` varchar(50) NOT NULL default '0',
                        `logo1` varchar(255) NOT NULL default '0',
                        `logo2` varchar(255) NOT NULL default '0',
                        PRIMARY KEY (`id`)  
                    ) 
                    ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
                    ";
    $DB->query($query_config) or die("Erro ao criar a tabela glpi_plugin_orderservice_config " . $DB->error());                

    return true;                    
                            
}

/**
 * @name plugin_orderservice_uninstall
 * @access public
 * @return boolean
 */
function plugin_orderservice_uninstall(){

    global $DB;

    $drop_config = "DROP TABLE glpi_plugin_orderservice_config";
    $DB->query($drop_config);

    return true;

}