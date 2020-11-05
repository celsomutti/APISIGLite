<?php
include 'sl_configuracao.php';

if(isset($_POST['cpf']))
{
    // Innitialize Variable
    $cpf = $_POST['cpf'];
    
    // Query database for row exist or not
    $sql = 'SELECT tbcodigosentregadores.COD_CADASTRO, tbcodigosentregadores.COD_ENTREGADOR, 
    tbcodigosentregadores.NOM_FANTASIA, tbcodigosentregadores.COD_AGENTE, tbcodigosentregadores.DAT_CODIGO,
    tbcodigosentregadores.DES_CHAVE, tbcodigosentregadores.COD_GRUPO, tbcodigosentregadores.VAL_VERBA,
    tbcodigosentregadores.NOM_EXECUTANTE, tbcodigosentregadores.DOM_ATIVO, tbcodigosentregadores.DAT_MANUTENCAO,
    tbcodigosentregadores.COD_TABELA, tbcodigosentregadores.COD_CLIENTE 
    FROM tbcodigosentregadores 
    where tbcodigosentregadores.DES_CHAVE = :cpf;';

    $conn->exec("set names utf8");
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
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