<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<?php

include('../../../inc/includes.php');
include('../../../inc/config.php');

    global $DB;
    Session::checkLoginUser();

    Html::header('Ordem de Serviço', "", "plugins", "orderservice");
    echo Html::css($CFG_GLPI["root_doc"]."/css/style.css");
    echo Html::css($CFG_GLPI["root_doc"]."/css/styleNew.css");

    if(isset($_SESSION["glpipalette"])):
        echo Html::css($CFG_GLPI["root_doc"]."/css/palettes/".$_SESSION["glpipalette"].".css");
    endif;

    $OsId = $_GET['id'];
    
    // Configurações do Plugin
    $SelPlugin = "SELECT * FROM glpi_plugin_orderservice_config";    
    $ResPlugin = $DB->query($SelPlugin) or die("Erro ao buscar as configurações!");
    $Plugin = $DB->fetch_assoc($ResPlugin);

        $EmpresaPlugin      = $Plugin['name'];
        $EnderecoPlugin     = $Plugin['address'];
        $TelefonePlugin     = $Plugin['phone'];
        $CidadePlugin       = $Plugin['city'];
        $CorPlugin          = $Plugin['color'];
        $CorTextoPlugin     = $Plugin['textcolor'];
    
    // Selecionar o Chamado
    $SelTicket = "SELECT * FROM glpi_tickets WHERE id = '$OsId'";
    $ResTicket = $DB->query($SelTicket) or die("Erro ao buscar o chamado!");
    $Ticket = $DB->fetch_assoc($ResTicket);   

        $OsNome  = $Ticket['name'];

    // Seleciona a solução do chamado
    $SelTicketFechado = "SELECT content 
                            FROM glpi_itilsolutions
                            WHERE itemtype = 'Ticket' 
                                AND items_id = '$OsId' 
                                AND status = 3
                            ORDER BY id 
                            DESC LIMIT 1
                        ";  
    $ResTicketFechado = $DB->query($SelTicketFechado) or die("Erro ao buscar o chamado fechado!");
    $TicketFechado = $DB->fetch_assoc($ResTicketFechado);
    
        $OsSolucao = $TicketFechado['content'];
        
    // Seleciona a data inicial
    $SelDataInicial = "SELECT date, date_format(date, '%d/%m/%Y %H:%i') AS DataInicio
                        FROM glpi_tickets 
                        WHERE id = '".$OsId."'
                    ";
    $ResDataInicial = $DB->query($SelDataInicial) or die("Erro ao buscar a data inicial!");
    $DataInicial = $DB->fetch_assoc($ResDataInicial);  
    
        $OsData       = $DataInicial['DataInicio'];
        $OsDescricao  = $Ticket['content'];
    
    // Seleciona a data final
    $SelDataFinal = "SELECT closedate, date_format(closedate, '%d/%m/%Y %H:%i') AS DataFinal
                       FROM glpi_tickets
                       WHERE id = '".$OsId."'     
                    ";
    $ResDataFinal = $DB->query($SelDataFinal) or die("Erro ao buscar a data final!");   
    $DataFinal = $DB->fetch_assoc($ResDataFinal);

        $OsDataEntrega = $DataFinal['DataFinal'];

    // Seleciona o usuario do chamado
    $SelTicketUsers = "SELECT * FROM glpi_tickets_users WHERE tickets_id = '".$OsId."'";
    $ResTicketUsers = $DB->query($SelTicketUsers) or die("Erro ao buscar o usuario do chamado!");
    $TicketUsers = $DB->fetch_assoc($ResTicketUsers);

        $OsUserId = $TicketUsers['users_id'];

    // Seleciona o responsavel pelo chamado
    $SelIdOsResponsavel = "SELECT users_id
                            FROM glpi_tickets_users
                            WHERE tickets_id = '".$OsId."'
                                AND type = 2
                        ";
    $ResIdOsResponsavel = $DB->query($SelIdOsResponsavel) or die("Erro ao buscar o responsavel pelo chamado!");
    $IdOsResponsavel = $DB->fetch_assoc($ResIdOsResponsavel);
    
    // Seleciona o nome do responsavel do chamado
    $SelOsResponsavelName = "SELECT * FROM glpi_users
                                WHERE id = '".$IdOsResponsavel['users_id']."'
                            ";
    $ResOsResponsavelName = $DB->query($SelOsResponsavelName) or die("Erro ao buscar o nome do responsavel!");
    $OsResponsavelFull = $DB->fetch_assoc($ResOsResponsavelName);   
            
        $OsResponsavelName  = $OsResponsavelFull['firstname']. " " .$OsResponsavelFull['realname'];
        $EntidadeId         = $Ticket['entities_id'];
    
    // Seleciona a entidade
    $SelEmpresa = "SELECT * FROM glpi_entities WHERE id = '".$EntidadeId."'";
    $ResEmpresa = $DB->query($SelEmpresa) or die("Erro ao buscar a empresa!");
    $Empresa = $DB->fetch_assoc($ResEmpresa);

        $EntidadeName       = $Empresa['name'];
        $EntidadeCep        = $Empresa['postcode'];
        $EntidadeEndereco   = $Empresa['address'];
        $EntidadeEmail      = $Empresa['email'];
        $EntidadePhone      = $Empresa['phonenumber'];
        $EntidadeCnpj       = $Empresa['comment'];

    // Seleciona o usuario
    $SelUsers = "SELECT * FROM glpi_users WHERE id = '".$OsUserId."'";
    $ResUsers = $DB->query($SelUsers) or die("Erro ao buscar o usuario!");
    $Users = $DB->fetch_assoc($ResUsers);
    
        $UserName       = $Users['firstname']. " " .$Users['realname'];
        $UserTelefone   = $Users['phone'];

    // Seleciona o email do usuario
    $SelEmail = "SELECT * FROM glpi_useremails WHERE users_id = '".$OsUserId."'";
    $ResEmail = $DB->query($SelEmail) or die("Erro ao buscar o email!");
    $Email = $DB->fetch_assoc($ResEmail);

        $UserEmail = $Email['email'];

    //Seleciona a localidade do Requerente 
    $SelLocation = "SELECT name FROM glpi_locations WHERE id = '".$Users['locations_id']."'";
    $ResLocation = $DB->query($SelLocation) or die("Erro ao buscar a localidade!");
    $Location = $DB->fetch_assoc($ResLocation);
    
        $LocationName = $Location['name'];

?>
<body>
    <div id="botoes">
        <a href="#" class="submit ali-center btn-primary" onclick="window.print();"> Imprimir Ordem de Serviço </a>
    </div>
    <table class="table-pri">
        <tr>
            <td class="padd-none">
                <table class="table-sec">
                    <tr>
                        <td>
                            <table class="table-tre">
                                <tr>
                                    <!-- Logo 1 -->
                                    <td class="td-logo-1">
                                        <img src="./img/logo1.png"><br>
                                        <img src="./img/logo2.png">
                                    </td>
                                    <!-- Titulo -->
                                    <td class="ali-center" id="titulo">
                                        <p class="size-p"><?= $EmpresaPlugin; ?></p>  
                                        <p class="size-mp"><?= $EnderecoPlugin . " - " . $CidadePlugin . " - " . $TelefonePlugin; ?></p>   
                                    </td>
                                    <td id="os">
                                        <p class="size-p ali-center">Número da OS: <br><b class="os-number"><?= $OsId; ?></b></p>
                                    </td>  
                                </tr>
                            </table>
                            <hr>
                        </td>
                    </tr>
                    <tr><td class="ali-center header-td"><b>Dados do requerente</b></td></tr>
                    <tr class="col-6 padd">
                        <td class="col-12"><b>Nome: </b><?= $UserName; ?></td>
                        <td class="col-12"><b>Telefone: </b><?= $UserTelefone; ?></td>
                    </tr>
                    <tr class="col-6 padd">
                        <td class="col-12"><b>E-mail: </b><?= $UserEmail; ?></td>
                        <td class="col-12"><b>Departamento: </b><?= $LocationName; ?></td>
                    </tr>
                    <tr><td class="ali-center header-td"><b>Detalhes do Chamado</b></td></tr>
                    <tr class="col-6 padd">
                        <td class="col-12"><b>Título: </b><?= $OsNome; ?></td>
                        <td class="col-12"><b>Técnico Responsável: </b><?= $OsResponsavelName; ?></td>
                        <?php
                            if($OsDataEntrega == ''):
                                echo '<td class="col-12"><b>Serviço: </b></td>';
                            endif;    
                        ?>
                    </tr>
                    <tr class="col-6 padd">
                        <td class="col-12"><b>Data/Hora Abertura: </b><?= $OsData; ?></td>
                        <?php
                            if($OsDataEntrega == ''):
                                echo '<div class="col-12">';
                                    echo '<td class="col-6"><b>Entrada: </b></td>';
                                    echo '<td class="col-6"><b>Saida: </b></td>';
                                echo '</div>';    
                            else:    
                                echo '<td class="col-12"><b>Data/Hora Fechamento: </b>'.$OsDataEntrega.'</td>';
                            endif;    
                        ?>
                    </tr>
                    <tr><td class="ali-center header-td"><b>Descrição do Chamado</b></td></tr>
                    <tr>
                        <td class="desc-chamado" colspan="2" valign="top"><?= html_entity_decode($OsDescricao); ?></td>
                    </tr>
                    <tr><td class="ali-center header-td"><b>Solução</b></td></tr>
                    <tr>
                        <td height="5" colspan="2" valign="top">
                            <?php
                                if($OsSolucao == null):
                                    echo "<b>Descrição da Solução:</b> <br><hr><br><hr><br><hr><b>Material Usado:</b><hr><br>";
                                else:
                                    echo html_entity_decode($OsSolucao);
                                endif;        
                            ?>
                        </td>
                    </tr>
                    <tr><td class="ali-center header-td"><b>Assinaturas</b></td></tr>
                    <tr>
                        <table width="700" style="margin-top:25px;margin-bottom:20px;" align="center" cellspacing="0">
                            <tr class="ali-center">
                                <td class="ali-center">____________________________________</td>
                                <td class="ali-center">____________________________________</td> 
                                <td class="ali-center">____________________________________</td>
                            </tr>
                            <tr class="ali-center">
                                <td class="ali-center"><b>Requerente:</b> <?= $UserName; ?></td>
                                <td class="ali-center"><b>Encarregado do Local</b></td>    
                                <td class="ali-center">
                                    <?php 
                                        if($OsResponsavelName === ''):
                                            echo '<b>Técnico Responsável</b>';
                                        else:
                                            echo '<b>Técnico</b> ' . $OsResponsavelName;
                                        endif;         
                                    ?>
                                </td> 
                            </tr>
                        </table>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <style media="print"></style>
</body>
</html> 