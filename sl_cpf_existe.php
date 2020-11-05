<?php
include 'sl_configuracao.php';

if(isset($_POST['cpf']))
{
    // Innitialize Variable
    $cpf = $_POST['cpf'];
    
    // Query database for row exist or not
    $sql = 'SELECT tbusuarios.COD_USUARIO, tbusuarios.NOM_USUARIO, tbusuarios.DES_LOGIN, tbusuarios.DES_EMAIL, 
    tbusuarios.DES_SENHA, tbusuarios.COD_GRUPO, tbusuarios.DOM_PRIVILEGIO, tbusuarios.DOM_EXPIRA, 
    tbusuarios.QTD_DIAS_EXPIRA, tbusuarios.DOM_PRIMEIRO_ACESSO, tbusuarios.DOM_ATIVO, tbusuarios.DAT_SENHA,
    tbusuarios.COD_NIVEL, tbusuarios.NOM_EXECUTOR, tbusuarios.NUM_CPF_CNPJ, tbusuarios.DAT_MANUTENCAO
    FROM bderpsisgef.tbusuarios  
    where tbusuarios.NUM_CPF_CNPJ = :cpf;';

    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->rowCount())
    {
        echo "true";
    } elseif(!$stmt->rowCount()) {
        echo "false";
    }
}