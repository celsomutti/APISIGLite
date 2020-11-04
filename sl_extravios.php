<?php
    include 'sl_configuracao.php';

    if(isset($_POST['extratos']))
    {
        // Innitialize Variable
        $extratos = $_POST['extratos'];
                
        // Query database for row exist or not
        $sql = 'SELECT tbextravios.num_nossonumero as Remessa, date_format(tbextravios.dat_extravio,"%d/%m/%Y") as "Data", 
        tbextravios.des_extravio as "Descrição", 
        format(0 - tbextravios.val_total,2,"de_DE") as Total
        from tbextravios
        where tbextravios.num_extrato in (' . $extratos . ')';
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