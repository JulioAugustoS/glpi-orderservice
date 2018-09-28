<?php

/*
 * @version $Id: config.form.php 19 2018-08-20 09:19:05Z walid $
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

include ('../../../inc/includes.php');

$empresa        = $_GET['empresa'];
$endereco       = $_GET['endereco'];
$telefone       = $_GET['telefone'];
$cidade         = $_GET['cidade'];
$cnpj           = $_GET['cnpj'];
$site           = $_GET['site'];

$salvar = CommonOrderService::saveConfig($empresa, $endereco, $telefone, $cidade, $cnpj, $site);

if($salvar){
    $response = array("success" => true);
}else{
    $response = array("success" => false);
}

echo json_encode($response);