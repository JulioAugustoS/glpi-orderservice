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

session_start();

include('../../../../../inc/includes.php');
include('../../../../../inc/config.php');

global $DB;

    $name      = $_GET["nome"];
    $address   = $_GET["endereco"];
    $phone     = $_GET["telefone"];
    $city      = $_GET["cidade"];

    $consulta = "SELECT sum(id) AS total FROM glpi_plugin_orderservice_config";
    $result = $DB->query($consulta) or die("Erro ao consultar dados!");
    $dados = $DB->fetch_assoc($result);
    
        if($dados['total'] == 0):

            $inserirEmpresa = "INSERT INTO glpi_plugin_orderservice_config
                                SET name = '$name', address = '$address', city = '$city', phone = '$phone' 
                            ";
            $save = $DB->query($inserirEmpresa) or die('Erro ao salvar a empresa!');
            
            if($save):
                $response = array("success" => true);
            else:
                $response = array("success" => false);
            endif;    
            
        else:
        
            $atualizarEmpresa = "UPDATE glpi_plugin_orderservice_config 
                                    SET name = '$name', address = '$address', city = '$city', phone = '$phone'
                                 WHERE id = 1   
                                ";
            $save = $DB->query($atualizarEmpresa) or die('Erro ao atualizar a empresa!');                    

            if($save):
                $response = array("success" => true);
            else:
                $response = array("success" => false);
            endif;    

        endif;    


echo json_encode($response);
