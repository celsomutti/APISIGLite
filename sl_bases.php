<?php
include 'sl_configuracao.php';
ini_set('default_charset','UTF-8');
// Check whether username or password is set from android	
if(isset($_POST['agente']))
{
    // Innitialize Variable
    $agente = $_POST['agente'];
    
    // Query database for row exist or not
    $sql = 'SELECT COD_AGENTE, DES_RAZAO_SOCIAL, NOM_FANTASIA, DES_TIPO_DOC, NUM_CNPJ, NUM_IE, 
    NUM_IEST, NUM_IM, COD_CNAE, COD_CRT, NUM_CNH, DES_CATEGORIA_CNH, DAT_VALIDADE_CNH, DES_PAGINA, COD_STATUS, 
    DES_OBSERVACAO, DAT_CADASTRO, DAT_ALTERACAO, VAL_VERBA, DES_TIPO_CONTA, COD_BANCO, COD_AGENCIA, NUM_CONTA, 
    NOM_FAVORECIDO, NUM_CPF_CNPJ_FAVORECIDO, DES_FORMA_PAGAMENTO, COD_CENTRO_CUSTO, COD_GRUPO 
    FROM tbagentes WHERE COD_AGENTE = :agente';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':agente', $agente, PDO::PARAM_INT);
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