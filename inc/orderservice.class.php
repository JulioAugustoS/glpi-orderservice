<?php

/*
 * @version $Id: orderserivce.class.php 19 2018-08-20 09:19:05Z walid $
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

include ('common.class.php');
if(!defined("PLUGIN_ORDERSERVICE_DIR")){
    define("PLUGIN_ORDERSERVICE_DIR", "http://localhost/glpi/plugins/orderservice");
}

class PluginOrderService extends CommonOrderService {

    public function printOsTicketOpen($id, $status){

        $configPlugin   = CommonOrderService::configPlugin();
        $tickets        = CommonOrderService::selTicket($id);
        $dates          = CommonOrderService::selDates($id);  
        $solution       = CommonOrderService::selTicketSolution($id);  
        $ticketsUser    = CommonOrderService::selTicketsUsers($id);
        $users          = CommonOrderService::selUsers($id);

        echo '<div id="botoes">';
        echo '<a href="#" class="submit ali-center btn-danger" onclick="window.print();"> Imprimir Ordem de Serviço </a>';
        echo '</div>';

        echo '
            <table class="table-pri" style="margin-bottom:20px;"><tr>
            <td class="padd-none">
            <table class="table-sec"><tr><td>
            ';
        
        echo ' 
            <table class="table-tre"><tr>
            <td class="td-logo-1">';

            if(empty($configPlugin['logo1']) && empty($configPlugin['logo2'])){
                echo '<img src="'. PLUGIN_ORDERSERVICE_DIR .'/pics/default.png">';
            }elseif(empty($configPlugin['logo2'])){
                echo '<img src="'. PLUGIN_ORDERSERVICE_DIR .'/pics/'. $configPlugin['logo1'] .'">';
            }else{
                echo '<img src="'. PLUGIN_ORDERSERVICE_DIR .'/pics/'. $configPlugin['logo1'] .'"><br>';
                echo '<img src="'. PLUGIN_ORDERSERVICE_DIR .'/pics/'. $configPlugin['logo2'] .'">';
            }

        echo '
            </td>
            <td class="ali-center" id="titulo">
            <p class="size-p">'. $configPlugin['empresa'] .'</p>  
            <p class="size-mp">'. $configPlugin['endereco'] .' - '. $configPlugin['cidade'] . ' - '. $configPlugin['telefone'] .'</p>   
            <p class="size-mp">'. $configPlugin['cnpj'] .' - '. $configPlugin['site'] .'</p>
            </td>
            <td id="os">
            <p class="size-p ali-center">Número da OS: <br><b class="os-number">'. $id. '</b></p>
            </td>  
            </tr>
            </table>
            <hr></td></tr>
            ';
        
        echo ' 
            <tr><td class="ali-center header-td"><b>Dados do requerente</b></td></tr>
            <tr class="col-6 padd">
            <td class="col-12"><b>Nome: </b>'. $users['Nome'] . ' ' . $users['Sobrenome'] .'</td>
            <td class="col-12"><b>Telefone: </b>'. $users['Fone'] .'</td>
            </tr>
            <tr class="col-6 padd">
            <td class="col-12"><b>E-mail: </b>'. $users['Email'] .'</td>
            <td class="col-12"><b>Departamento: </b>'. $users['Localidade'] .'</td>
            </tr>
            <tr><td class="ali-center header-td"><b>Detalhes do Chamado</b></td></tr>
            <tr class="col-6 padd">
            <td class="col-12"><b>Título: </b>'. $tickets['name'] .'</td>
            <td class="col-12"><b>Técnico Responsável: </b>'. $ticketsUser[2] .'</td>
            ';

            if($dates[2] == ''):
                echo '<td class="col-12"><b>Serviço: </b></td>';
            endif; 
        
        echo ' 
            </tr><tr class="col-6 padd">
            <td class="col-12"><b>Data/Hora Abertura: </b>'. $dates[0] .'</td>
            ';

            if($dates[2] == ''):
                echo '<div class="col-12">';
                    echo '<td class="col-6"><b>Entrada: </b></td>';
                    echo '<td class="col-6"><b>Saida: </b></td>';
                echo '</div>';    
            else:    
                echo '<td class="col-12"><b>Data/Hora Fechamento: </b>'. $dates[2] .'</td>';
            endif; 

        echo ' 
            </tr>
            <tr><td class="ali-center header-td"><b>Descrição do Chamado</b></td></tr>
            <tr>
            <td class="desc-chamado" colspan="2" valign="top">'. html_entity_decode($tickets['content']) .'</td>
            </tr>
            <tr><td class="ali-center header-td"><b>Solução</b></td></tr>
            <tr>
            <td height="5" colspan="2" valign="top">
            ';

            if($solution == null):
                echo "<b>Descrição da Solução:</b> <br><hr><br><hr><br><hr><b>Material Usado:</b><hr><br>";
            else:
                echo html_entity_decode($solution);
            endif;

        echo ' 
            </td></tr>
            <tr><td class="ali-center header-td"><b>Assinaturas</b></td></tr><tr>
            ';

        echo '<table width="700" style="margin-top:25px;margin-bottom:20px;" align="center" cellspacing="0">';
            echo '<tr class="ali-center">';
            echo '<td class="ali-center">____________________________________</td>';
            echo '<td class="ali-center">____________________________________</td>'; 
            echo '<td class="ali-center">____________________________________</td></tr>';

            echo ' 
                <tr class="ali-center">
                <td class="ali-center"><b>Requerente:</b> '. $users['Nome'] . ' ' . $users['Sobrenome'] .'</td>
                <td class="ali-center"><b>Encarregado do Local</b></td>    
                <td class="ali-center">
                ';
            
            if($ticketsUser[2] === ''):
                echo '<b>Técnico Responsável</b>';
            else:
                echo '<b>Técnico</b> ' . $ticketsUser[2];
            endif; 
        
        echo '</td></tr></table>'; 
        echo '</tr></table></td></tr></table>';
        echo '<style media="print"></style>';

    }

}