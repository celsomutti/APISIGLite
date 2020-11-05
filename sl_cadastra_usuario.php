<?php
include 'sl_configuracao.php';

// Check whether username or password is set from android	
  if(isset($_POST['cpf']) && isset($_POST['username']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']))
  {
    // Innitialize Variable
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $grupo = '-1';
    $privilegio = 'N';
    $expira = 'N';
    $dias = '0';
    $acesso = 'N';
    $ativo = 'S';
    $data = date('Y-m-d');
    $nivel = '4';
    $cpf = $_POST['cpf'];   
    $dataGravacao = date('Y-m-d H:i:s');
    $key = 'ABCDEFGHIJ0987654321KLMNOPQRSTUVXZ0123456789';
  
    // Query database for row exist or not
    $sql = 'INSERT INTO tbusuarios (NOM_USUARIO, DES_LOGIN, DES_EMAIL, DES_SENHA, COD_GRUPO, 
    DOM_PRIVILEGIO, DOM_EXPIRA, QTD_DIAS_EXPIRA, DOM_PRIMEIRO_ACESSO, DOM_ATIVO, DAT_SENHA, COD_NIVEL, 
    NUM_CPF_CNPJ, NOM_EXECUTOR, DAT_MANUTENCAO)
    VALUES 
    (:pNOM_USUARIO, :pDES_LOGIN, :pDES_EMAIL, AES_ENCRYPT(:pDES_SENHA, "' . $key . '"), 
    :pCOD_GRUPO, :pDOM_PRIVILEGIO, :pDOM_EXPIRA, :pQTD_DIAS_EXPIRA, :pDOM_PRIMEIRO_ACESSO,
    :pDOM_ATIVO, :pDAT_SENHA, :pCOD_NIVEL, :pNUM_CPF_CNPJ, :pNOM_EXECUTOR, :pDAT_MANUTENCAO);';
    
    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':pNOM_USUARIO', $name);
    $stmt->bindParam(':pDES_LOGIN', $username);
    $stmt->bindParam(':pDES_EMAIL', $email);
    $stmt->bindParam(':pDES_SENHA', $password);
    $stmt->bindParam(':pCOD_GRUPO', $grupo);
    $stmt->bindParam(':pDOM_PRIVILEGIO', $privilegio);
    $stmt->bindParam(':pDOM_EXPIRA', $expira);
    $stmt->bindParam(':pQTD_DIAS_EXPIRA', $dias);
    $stmt->bindParam(':pDOM_PRIMEIRO_ACESSO', $acesso);
    $stmt->bindParam(':pDOM_ATIVO', $ativo);
    $stmt->bindParam(':pDAT_SENHA', $data);
    $stmt->bindParam(':pCOD_NIVEL', $nivel);
    $stmt->bindParam(':pNUM_CPF_CNPJ', $cpf);
    $stmt->bindParam(':pNOM_EXECUTOR', $username);
    $stmt->bindParam(':pDAT_MANUTENCAO', $dataGravacao);

    if ($stmt->execute())
    {
      echo 'true';   
    } elseif(!$stmt->rowCount()) {
      echo 'false';
    }
  }
?>