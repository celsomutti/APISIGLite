<?php
include 'sl_configuracao.php'; 

if(isset($_POST['agente']) && isset($_POST['dataini']) && isset($_POST['datafim']))
{
    $agente = $_POST['agente'];
    $dataini = $_POST['dataini'];
    $datafim = $_POST['datafim'];
    $data = $dataini;
    $while = '';

    while (strtotime($data) <= strtotime($datafim)) {
        $while = $while . 'sum(if(day(tbentregas.dat_baixa) = '. date("d",strtotime($data)) . ',1,0)) as "' . date("d/m", strtotime($data)) . '"';
        $data = date ("y-m-d", strtotime("+1 day", strtotime($data)));
        if (strtotime($data)  > strtotime($datafim)) {
        	$while = $while . ' ';
        } else {
        	$while = $while . ', ';	
        }
    }
    $sql = 'select tbentregas.cod_entregador as "Código", tbcodigosentregadores.nom_fantasia as Nome, ' . $while .' from tbentregas 
    inner join tbcodigosentregadores
    on tbcodigosentregadores.cod_entregador = tbentregas.cod_entregador
    where tbentregas.dat_baixa between "' . $dataini . '" and "' . $datafim . '" and tbentregas.cod_agente = ' . $agente . ' group by tbentregas.cod_entregador;';
    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if($stmt->rowCount())
    {
      $row_all = $stmt->fetchall(PDO::FETCH_ASSOC);
      header('Content-type: application/json');
      echo json_encode($row_all);	
    } elseif(!$stmt->rowCount()) {
      echo "false";
    }
}


?>