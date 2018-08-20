<?php
/*
 * @version $Id: config.php 19 2018-08-20 09:19:05Z walid $
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style.css">

</head>
<?php

include('../../../../inc/includes.php');
if(GLPI_VERSION <= 9.2):
    include('../../../../config/config.php');
else:
    include('../../../../inc/config.php');
endif; 

    global $DB;
    Session::checkLoginUser();
    Session::checkRight("profile", READ);

    Html::header('Ordem de Serviço', "", "plugins", "orderservice");
    echo Html::css($CFG_GLPI["root_doc"]."/css/style.css");
    echo Html::css($CFG_GLPI["root_doc"]."/css/styleNew.css");

    if(isset($_SESSION["glpipalette"])):
        echo Html::css($CFG_GLPI["root_doc"]."/css/palettes/".$_SESSION["glpipalette"].".css");
    endif;
   
?>

<body>
    <div class="back">
        <h1>Configurações</h1>
        <hr>
        <div class="col-md-6" style="margin-right:15px;">
        <?php
            $buscaEmpresa = "SELECT sum(id) AS total, name, address, phone, city FROM glpi_plugin_orderservice_config WHERE id = 1";
            $resultEmpresa = $DB->query($buscaEmpresa) or die("Erro ao buscar a empresa!");
            $empresa = $DB->fetch_assoc($resultEmpresa);

            echo '<h2>Dados da Empresa</h2>';
            echo '<hr>';

            if($empresa['total'] == 0):
                echo '<div class="alert alert-info text-center">Dados da empresa não cadastrados!</div>';
            else:    

                echo '
                    <div class="dados-empresa">
                        <p>
                            <strong>Nome: </strong>'.$empresa['name'].'<br><br>
                            <strong>Endereço: </strong>'.$empresa['address'].' - '.$empresa['city'].'<br><br>
                            <strong>Telefone: </strong>'.$empresa['phone'].'
                        </p>
                    </div>
                ';

            endif;    
        ?>
        </div>
        <div class="col-md-6">
        <?php
            if($empresa['total'] == 1):
                echo '
                    <h2>Atualizar Empresa</h2>
                    <hr>
                    <form id="salvarEmpresa" class="form-empresa">
                        <div class="form-group">
                            <label>Razão Social:</label>
                            <input class="form-control" name="nome" type="text" value="'.$empresa['name'].'">
                        </div>    
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input class="form-control" name="endereco" type="text" value="'.$empresa['address'].'"> 
                        </div>    
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input class="form-control" name="cidade" type="text" value="'.$empresa['city'].'"> 
                        </div>
                        <div class="form-group">
                            <label>Telefone:</label>
                            <input class="form-control" name="telefone" type="text" value="'.$empresa['phone'].'"> 
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="salvar()" class="btn btn-success">Atualizar</button>
                        </div>
                    </form>
                ';
            else:    
                echo '
                    <h2>Cadastrar Empresa</h2>
                    <hr>
                    <form id="salvarEmpresa" class="form-empresa">
                        <div class="form-group">
                            <label>Razão Social:</label>
                            <input class="form-control" name="nome" type="text" placeholder="Nome da empresa">
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
                            <input class="form-control" name="telefone" type="text" placeholder="Telefone da empresa"> 
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="salvar()" class="btn btn-success">Salvar</button>
                        </div>
                    </form>
                ';
            endif;  
        ?>    
            <div class="success"></div>      
        </div>
    </div>
    <script>
        function salvar() {
            var dados = $('#salvarEmpresa').serialize()

            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: 'ajax/configuracoes.php',
                data: dados,
                beforeSend: function() {
                    $('.success').html('<div class="alert alert-info text-center">Salvando informações...</div>')
                },
                success: function(res) {
                    if(res.success == true){
                        console.log('Salvo com sucesso!')
                        setTimeout(function(){
                            $('.success').html('<div class="alert alert-success text-center">Informações salvas com sucesso!</div>')
                        }, 1000) 
                        setTimeout(function(){
                            location.reload()
                        }, 1500)   
                    }else{
                        console.log('Não foi possivel salvar!')
                        setTimeout(function(){
                            $('.success').html('<div class="alert alert-danger text-center">Erro ao salvar informações!</div>')
                        }, 1000)    
                    }
                }
            });
            return false;
        }
    </script>
</body>
</html>