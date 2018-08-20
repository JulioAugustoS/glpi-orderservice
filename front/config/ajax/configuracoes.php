<?php

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
