<?php
include 'sl_configuracao.php';


  if(isset($_POST['id']) && isset($_POST['codigo']))
  {
    // Innitialize Variable
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $agente = '0';
  
    // Query database for row exist or not
    $sql = 'INSERT INTO tbusuariosagentes (COD_USUARIO, COD_AGENTE, COD_ENTREGADOR)
    VALUES
    (:COD_USUARIO, :COD_AGENTE, :COD_ENTREGADOR);';
    
    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':COD_USUARIO', $id);
    $stmt->bindParam(':COD_AGENTE', $agente);
    $stmt->bindParam(':COD_ENTREGADOR', $codigo);

    if ($stmt->execute())
    {
      echo 'true';   
    } elseif(!$stmt->rowCount()) {
      echo 'false';
    }
  }
?>