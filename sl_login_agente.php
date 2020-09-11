<?php
include 'sl_configuracao.php';
ini_set('default_charset','UTF-8');
// Check whether username or password is set from android	
if(isset($_POST['usuario']))
{
    // Innitialize Variable
    $usuario = $_POST['usuario'];
    
    // Query database for row exist or not
    $sql = 'SELECT id_usuario_agente, cod_usuario, cod_agente, cod_entregador FROM tbusuariosagentes WHERE cod_usuario = :usuario';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_INT);
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