<?php

function plugin_orderservice_install(){

    global $DB, $LANG;

        $query_config = "CREATE TABLE IF NOT EXISTS `glpi_plugin_orderservice_config`
                        (
                            `ID` int(1) unsigned NOT NULL default '1',
                            `name` varchar(255) NOT NULL default '0',
                            `address` varchar(255) NOT NULL default '0',
                            `phone` varchar(50) NOT NULL default '0',
                            `city` varchar(255) NOT NULL default '0',
                            `textcolor` varchar(7) NOT NULL default '#FFFFFF',
                            `color` varchar(7) NOT NULL default '#000000',
                            PRIMARY KEY (`id`)  
                        ) 
                        ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
                        ";
        $DB->query($query_config) or die("Erro ao criar a tabela glpi_plugin_orderservice_config " . $DB->error());                
    
        return true;                    
                            
}

function plugin_orderservice_uninstall(){

    global $DB;
    $drop_config = "DROP TABLE glpi_plugin_orderservice_config";
    $DB->query($drop_config);
    return true;

}