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

class CommonOrderService extends CommonDBTM {

    /**
     * @name saveConfig
     * @access public
     * @param String $empresa, $endereco, $telefone, $cidade, $cnpj, $site
     * @return array
     */
    
    public static function saveConfig($empresa, $endereco, $telefone, $cidade, $cnpj, $site){

        global $DB;

        $consulta = self::configPlugin();

        if($consulta['total'] == 0){

            $insertEmpresa = "INSERT INTO glpi_plugin_orderservice_config
                                SET empresa = '$empresa',
                                    endereco = '$endereco',
                                    telefone = '$telefone',
                                    cidade = '$cidade',
                                    cnpj = '$cnpj',
                                    site = '$site'
                            ";
            $save = $DB->query($insertEmpresa) or die('Erro ao salvar a empresa!');

            return $save;

        }else{

            $updateEmpresa = "UPDATE glpi_plugin_orderservice_config
                                SET empresa = '$empresa',
                                    endereco = '$endereco',
                                    telefone = '$telefone',
                                    cidade = '$cidade',
                                    cnpj = '$cnpj',
                                    site = '$site'
                                WHERE id = 1
                            ";
            $save = $DB->query($updateEmpresa) or die('Erro ao atualizar a empresa!');

            return $save;

        }

    }

    /**
     * @name configPlugin
     * @access public
     * @return array
     */
    public static function configPlugin(){

        global $DB;

        $selPlugin = "SELECT 
                        sum(id) AS total,
                        empresa,
                        endereco,
                        telefone,
                        cidade,
                        cnpj,
                        site
                        FROM glpi_plugin_orderservice_config
                    ";
        $resPlugin = $DB->query($selPlugin);
        $plugin = $DB->fetch_assoc($resPlugin);

        return $plugin;

    }

    /**
     * @name selTicket
     * @access public
     * @param Int $idTicket
     * @return array
     */
    function selTicket($idTicket){

        global $DB;

        $selTicket = "SELECT * FROM glpi_tickets WHERE id = '$idTicket'";
        $resTicket = $DB->query($selTicket);
        $ticket = $DB->fetch_assoc($resTicket);

        return $ticket;

    }

    /**
     * @name selTicketSolution
     * @access public
     * @param Int $idTicket
     * @return object 
     */
    static function selTicketSolution($idTicket){

        global $DB;

        // Seleciona a solução do chamado
        $selTicketSolution = "SELECT content
                                FROM glpi_itilsolutions
                                WHERE itemtype = 'Ticket'
                                AND items_id = '$idTicket'
                                AND status = 3
                                ORDER BY id DESC
                                LIMIT 1
                            ";
        $resTicketSolution = $DB->query($selTicketSolution);
        $ticketSolution = $DB->fetch_assoc($resTicketSolution);

        return $osSolution = $ticketSolution['content'];

    }

    /**
     * @name selDates
     * @access public
     * @param Int $idTicket
     * @return array
     */
    function selDates($idTicket){

        global $DB;

        // Seleciona a data inicial 
        $selDateInitial = "SELECT date, date_format(date, '%d/%m/%Y %H:%i') AS DataInicio
                            FROM glpi_tickets
                            WHERE id = '$idTicket'
                        ";
        $resDateInitial = $DB->query($selDateInitial);
        $dateInitial = $DB->fetch_assoc($resDateInitial);
        
        // Seleciona a data final
        $selDateFinish = "SELECT closedate, date_format(closedate, '%d/%m/%Y %H:%i') AS DataFinal
                            FROM glpi_tickets
                            WHERE id = '$idTicket'
                        ";
        $resDateFinish = $DB->query($selDateFinish);
        $dateFinish = $DB->result($resDateFinish, 0, 'DataFinal');

            $dataI          = $dateInitial['DataInicio'];
            $osDescricao    = self::selTicketSolution($idTicket);

            return array($dataI, $osDescricao, $dateFinish);

    }

    /**
     * @name selTicketsUsers
     * @access public
     * @param Int $idTicket
     * @return array
     */
    function selTicketsUsers($idTicket){

        global $DB;

        // Seleciona o usuario do chamado
        $selTicketUsers = "SELECT users_id AS idUser 
                            FROM glpi_tickets_users 
                            WHERE tickets_id = '$idTicket'
                        ";
        $resTicketUsers = $DB->query($selTicketUsers);
        $ticketUsers = $DB->result($resTicketUsers, 0, 'idUser');

        // Seleciona o responsavel pelo chamado
        $selIdOsResponsavel = "SELECT users_id AS idRes 
                                FROM glpi_tickets_users 
                                WHERE tickets_id = '$idTicket'
                                AND type = 2
                            ";
        $resIdOsResponsavel = $DB->query($selIdOsResponsavel);
        $idOsResponsavel = $DB->result($resIdOsResponsavel, 0, 'idRes');

        // Seleciona o nome do responsavel do chamado
        $selOsResponsavelName = "SELECT * FROM glpi_users WHERE id = '$idOsResponsavel'";
        $resOsResponsavelName = $DB->query($selOsResponsavelName);
        $osResponsavelFull = $DB->fetch_assoc($resOsResponsavelName);

        $osResponsavelName  = $osResponsavelFull['firstname'] . "  " . $osResponsavelFull['realname'];
        $entidadeId         =  self::selTicket($idTicket); 

            return array(
                $ticketUsers, 
                $idOsResponsavel, 
                $osResponsavelName,
                $entidadeId['entities_id']
            );

    }

    /**
     * @name selUsers
     * @access public
     * @param Int $id
     * @return array
     */
    function selUsers($id){

        global $DB;
        $osUserId = self::selTicketsUsers($id);

        $selUsers = "SELECT a.firstname AS Nome,
                        a.realname AS Sobrenome,
                        a.phone AS Fone,
                        b.email AS Email,
                        c.name AS Localidade
                        FROM glpi_users a 
                        LEFT JOIN glpi_useremails b ON (b.users_id = a.id)
                        LEFT JOIN glpi_locations c ON (c.id = a.locations_id)
                        WHERE b.is_default = 1 AND a.id = ". $osUserId[0] . "
                    ";
        $resUsers = $DB->query($selUsers);
        $users = $DB->fetch_assoc($resUsers);

        return $users;

    }

}