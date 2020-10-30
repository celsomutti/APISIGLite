<?php
include 'sl_configuracao.php';
ini_set('default_charset','UTF-8');

if(isset($_POST['quinzena']))
{
    $quinzena = $_POST['quinzena'];
    if($quinzena === '0')
    {
        $sql = 'SELECT financeiro_parametros.id_parametro,
            financeiro_parametros.num_quinzena,
            financeiro_parametros.dia_inicio_quinzena,
            financeiro_parametros.dia_final_quinzena,
            financeiro_parametros.qtd_raio_x
        FROM bderpsisgef.financeiro_parametros;';
    }
    else
    {
        $sql = 'SELECT financeiro_parametros.id_parametro,
            financeiro_parametros.num_quinzena,
            financeiro_parametros.dia_inicio_quinzena,
            financeiro_parametros.dia_final_quinzena,
            financeiro_parametros.qtd_raio_x
        FROM bderpsisgef.financeiro_parametros
        WHERE financeiro_parametros.num_quinzena = ' . $quinzena .';';

    }
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