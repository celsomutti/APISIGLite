<?php
 include 'sl_configuracao.php'; 

 if(isset($_POST['tipo']) && isset($_POST['codigo']) && isset($_POST['ano']) && isset($_POST['mes']) && isset($_POST['quinzena']))
 {
    $tipo = $_POST['tipo'];
    $codigo = $_POST['codigo'];
    $ano = $_POST['ano'];
    $mes = $_POST['mes'];
    $quinzena = $_POST['quinzena'];
    $foco  = '';
    
    if($tipo === 'B')
    {
    $foco = 'and expressas_extrato.cod_base = ' . $codigo . ' group by expressas_extrato.cod_entregador, expressas_extrato.val_verba; ';
    }
    elseif($tipo ===   'E')
    {
    $foco = 'and expressas_extrato.cod_entregador = ' . $codigo . ' group by expressas_extrato.cod_entregador, expressas_extrato.val_verba; ';
    }
    
    $sql = 'SELECT expressas_extrato.id_extrato,expressas_extrato.dat_inicio, expressas_extrato.dat_final, expressas_extrato.num_ano,
    expressas_extrato.num_mes, expressas_extrato.num_quinzena, expressas_extrato.cod_base, expressas_extrato.cod_entregador,
    tbcodigosentregadores.nom_fantasia, expressas_extrato.num_extrato, expressas_extrato.val_verba, expressas_extrato.qtd_volumes,
    expressas_extrato.qtd_volumes_extra, expressas_extrato.val_volumes_extra, expressas_extrato.qtd_entregas,
    expressas_extrato.qtd_atraso, expressas_extrato.val_performance, expressas_extrato.val_producao,
    expressas_extrato.val_creditos, expressas_extrato.val_debitos, expressas_extrato.val_extravios,
    expressas_extrato.val_total_expressa, expressas_extrato.val_total_empresa, expressas_extrato.cod_cliente,
    expressas_extrato.dat_credito, expressas_extrato.des_unique_key FROM expressas_extrato
    inner join tbcodigosentregadores
    on tbcodigosentregadores.cod_entregador = expressas_extrato.cod_entregador
    where num_ano = ' . $ano . ' and num_mes = ' . $mes . ' and num_quinzena = '. $quinzena . ' ' . $foco;
    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount())
    {
    $row_all = $stmt->fetchall(PDO::FETCH_ASSOC);
    header('Content-type: application/json');
    echo json_encode($row_all);	
    } 
    elseif(!$stmt->rowCount()) 
    {
    echo "false";
    }
 }
 
?>