<?php
include 'sl_configuracao.php'; 

if(isset($_POST['tipo']) && isset($_POST['codigo']) && isset($_POST['dataini']) && isset($_POST['datafim']))
{
    $tipo = $_POST['tipo'];
    $codigo = $_POST['codigo'];
    $dataini = $_POST['dataini'];
    $datafim = $_POST['datafim'];
    $data = $dataini;
    $while = '';
    $foco  = '';

    while (strtotime($data) <= strtotime($datafim)) {
        $while = $while . 'sum(if(day(tbentregas.dat_baixa) = '. date("d",strtotime($data)) . ',1,0)) as "' . date("d/m", strtotime($data)) . '"';
        $data = date ("y-m-d", strtotime("+1 day", strtotime($data)));
        if (strtotime($data)  > strtotime($datafim)) {
        	$while = $while . ' ';
        } else {
        	$while = $while . ', ';	
        }
    }
    if($tipo === 'B')
    {
      $foco = 'and tbentregas.cod_agente = ' . $codigo . ' group by tbentregas.cod_entregador, Tipo;';
    }
    elseif($tipo ===   'E')
    {
      $foco = 'and tbentregas.cod_entregador = ' . $codigo . ' group by tbentregas.cod_entregador, Tipo;';
    }
    $sql = 'select tbentregas.cod_entregador as "Código", tbcodigosentregadores.nom_fantasia as Nome, 
    crm_clientes.nom_fantasia as Cliente, 
    (if(tbentregas.val_verba_entregador>=15,"PESADO","LEVE")) as Tipo,' . $while .
    ', count(tbentregas.num_nossonumero) as Total from tbentregas 
    inner join tbcodigosentregadores
    on tbcodigosentregadores.cod_entregador = tbentregas.cod_entregador
    inner join crm_clientes
    on crm_clientes.cod_cliente = tbentregas.cod_cliente_empresa
    where tbentregas.dat_baixa between "' . $dataini . '" and "' . $datafim . '" ' . $foco ;
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