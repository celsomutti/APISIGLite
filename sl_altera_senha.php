<?php
    include 'sl_configuracao.php';
    if(isset($_POST['id']) && isset($_POST['senha']))
    {
        $id = $_POST['id'];
        $senha = $_POST['senha'];
        $key = 'ABCDEFGHIJ0987654321KLMNOPQRSTUVXZ0123456789';

        $sql = 'UPDATE tbusuarios set tbusuarios.des_senha =  AES_ENCRYPT(:pdes_senha, "' . $key . '" ) 
        where tbusuarios.cod_usuario = :pcod_usuario';

        $conn->exec("set names utf8");
        $stmt = $conn->prepare($sql);   

        $stmt->bindParam(':pdes_senha', $senha);
        $stmt->bindParam(':pcod_usuario', $id);

        if ($stmt->execute())
        {
        echo 'true';   
        } elseif(!$stmt->rowCount()) {
        echo 'false';
        }
    }
?>