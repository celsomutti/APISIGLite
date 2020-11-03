<?php
 include 'sl_configuracao.php'; 

 if(isset($_POST['tipo']) && isset($_POST['codigo']) && isset($_POST['dataini']) && isset($_POST['datafim']))
 {
     $tipo = $_POST['tipo'];
     $codigo = $_POST['codigo'];
     $dataini = $_POST['dataini'];
     $datafim = $_POST['datafim'];
     $foco  = '';
      
     if($tipo === 'B')
     {
       $foco = 'and tbentregas.cod_agente = ' . $codigo . ' and dom_fechado <> "S" group by tbentregas.cod_entregador, Verba; ';
     }
     elseif($tipo ===   'E')
     {
       $foco = 'and tbentregas.cod_entregador = ' . $codigo . ' and dom_fechado <> "S" group by tbentregas.cod_entregador, Verba; ';
     }
     
     $sql = 'SELECT tbentregas.cod_entregador as "Código", tbcodigosentregadores.nom_fantasia as Nome, 
     tbentregas.val_verba_entregador as Verba, count(tbentregas.num_nossonumero) as Qtde, 
     (tbentregas.val_verba_entregador * count(tbentregas.num_nossonumero)) as "Produção" 
     from tbentregas 
     inner join tbcodigosentregadores
     on tbcodigosentregadores.cod_entregador = tbentregas.cod_entregador
     where tbentregas.dat_baixa between "' . $dataini . '" and "' . $datafim . '" ' . $foco;
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