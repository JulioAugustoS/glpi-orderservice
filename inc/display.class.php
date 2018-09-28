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

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

class PluginOrderServiceDisplay extends CommonOrderService {

	public static function getTypeName($nb = 0){

		return _n('Ordem de Serviço', 'Ordens de Serviços', $nb, 'orderservice');

	}

	public static function displayTelaConfig(){

		global $DB;

		$configPlugin   = CommonOrderService::configPlugin();


		echo '<div class="back">
				<h1>Configurações</h1>
				<hr>
				<div class="col-md-6" style="margin-right:15px;">
		';
		echo '<h2>Dados da Empresa</h2><hr>';

			if($configPlugin['total'] == 0){
				echo '<div class="alert alert-info text-center">Dados da empresa não cadastrados!</div>';
			}else{
				echo '
                    <div class="dados-empresa">
                        <p>
                            <strong>Nome: </strong>'.$configPlugin['empresa'].'<br><br>
                            <strong>Endereço: </strong>'.$configPlugin['endereco'].' - '.$configPlugin['cidade'].'<br><br>
							<strong>Telefone: </strong>'.$configPlugin['telefone'].'<br><br>
							<strong>CNPJ: </strong>'.$configPlugin['cnpj'].'<br><br>
							<strong>Site: </strong>'.$configPlugin['site'].'<br><br>
                        </p>
					</div>
					<hr>
				';
				
				echo '<h2>Logo da Empresa</h2>';
				echo '<div class="alert alert-info text-center">Essa opção para fazer upload da logo da empresa será adicionada na próxima versão do plugin!</div>';
			}

		echo '</div>';
		echo '<div class="col-md-6">';
			
			if($configPlugin['total'] == 1){
				echo '
                    <h2>Atualizar Empresa</h2>
                    <hr>
                    <form id="salvarEmpresa" class="form-empresa">
                        <div class="form-group">
                            <label>Razão Social:</label>
                            <input class="form-control" name="empresa" type="text" value="'.$configPlugin['empresa'].'">
                        </div>    
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input class="form-control" name="endereco" type="text" value="'.$configPlugin['endereco'].'"> 
                        </div>    
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input class="form-control" name="cidade" type="text" value="'.$configPlugin['cidade'].'"> 
                        </div>
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input class="form-control" name="telefone" type="text" value="'.$configPlugin['telefone'].'"> 
						</div>
						<div class="form-group">
                            <label>CNPJ:</label>
                            <input class="form-control" name="cnpj" type="text" value="'.$configPlugin['cnpj'].'"> 
						</div>
						<div class="form-group">
                            <label>Site:</label>
                            <input class="form-control" name="site" type="text" value="'.$configPlugin['site'].'"> 
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="salvar()" class="btn btn-success">Atualizar</button>
                        </div>
                    </form>
                ';
			}else{
				echo '
                    <h2>Cadastrar Empresa</h2>
                    <hr>
                    <form id="salvarEmpresa" class="form-empresa">
                        <div class="form-group">
                            <label>Razão Social:</label>
                            <input class="form-control" name="empresa" type="text" placeholder="Nome da empresa">
                        </div>    
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input class="form-control" name="endereco" type="text" placeholder="Endereço da empresa"> 
                        </div>    
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input class="form-control" name="cidade" type="text" placeholder="Nome da cidade"> 
                        </div>
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input class="form-control" name="telefone" id="telefone" type="text" placeholder="Telefone da empresa"> 
						</div>
						<div class="form-group">
							<label>CNPJ:</label>
							<input class="form-control" name="cnpj" id="cnpj" type="text" placeholder="CNPJ da empresa"> 
						</div>
						<div class="form-group">
							<label>Site:</label>
							<input class="form-control" name="site" type="text" placeholder="Site da empresa"> 
						</div>
                        <div class="form-group">
                            <button type="button" onclick="salvar()" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                ';
			}

		echo '<div class="success"></div></div></div>';
		echo '</div>';
		echo '</div>';

	}

}