<?php
    include 'sl_configuracao.php';

    if(isset($_POST['extratos']))
    {
        // Innitialize Variable
        $extratos = $_POST['extratos'];
                
        // Query database for row exist or not
        $sql = 'SELECT tblancamentos.des_lancamento as "Descrição", date_format(tblancamentos.dat_lancamento,"%d/%m/%Y") as "Data", 
        tblancamentos.des_tipo as Tipo, 
        if(tblancamentos.des_tipo="CREDITO",tblancamentos.val_lancamento,(0-tblancamentos.val_lancamento)) as Valor 
        from tblancamentos 
        where tblancamentos.num_extrato in (' . $extratos . ')';
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