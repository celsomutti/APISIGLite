<?php

   include 'sl_configuracao.php';
   
	 // Check whether username or password is set from android	
     if(isset($_POST['username']) && isset($_POST['password']))
     {
		  // Innitialize Variable
	   	  $username = $_POST['username'];
        $password = $_POST['password'];
        $key = 'ABCDEFGHIJ0987654321KLMNOPQRSTUVXZ0123456789';

        // Query database for row exist or not
        $sql = 'SELECT tbusuarios.COD_USUARIO, tbusuarios.NOM_USUARIO, tbusuarios.DES_LOGIN, tbusuarios.DES_EMAIL,  
        AES_DECRYPT(tbusuarios.DES_SENHA, "' . $key . '") as DES_SENHA, tbusuarios.COD_GRUPO, tbusuarios.DOM_PRIVILEGIO, 
        tbusuarios.DOM_EXPIRA, tbusuarios.QTD_DIAS_EXPIRA, tbusuarios.DOM_PRIMEIRO_ACESSO, tbusuarios.DOM_ATIVO,  
        tbusuarios.DAT_SENHA, tbusuarios.COD_NIVEL, tbusuarios.NUM_CPF_CNPJ, tbusuarios.NOM_EXECUTOR, tbusuarios.DAT_MANUTENCAO   
        FROM bderpsisgef.tbusuarios where tbusuarios.DES_LOGIN = "' . $username . '" AND 
        AES_DECRYPT(tbusuarios.DES_SENHA, "' . $key . '") = "' . $password . '";';
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