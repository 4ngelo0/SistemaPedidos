<?php

include ('../conexao/conn.php');

$requestData = $_REQUEST;

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

if($requestData['operacao'] == 'create'){
    try{
    $sql = "INSERT INTO ITENSVENDA (DATA, VENDA_ID, PRODUTO_ID, ATENDENTE_ID) VALUES (?, ?, ?, ?)"; 
    $stmt = $pdo->prepare($sql); 

    $stmt->execute([
        $dataLocal,
        $requestData['VENDA_ID'],
        $requestData['PRODUTO_ID'],
        $requestData['ATENDENTE_ID'],
    ]);

    $dados = array(
        'type' => 'success',
        'mensagem' => 'Registro salvo com sucesso!'
    );
}catch (PDOExeception $e){
    $dados = array(
        'type' => 'error',
        'mensagem' => 'Erro ao salvar o registro:' .$e
    );
}

echo json_encode($dados);
}



if($requestData['operacao'] == 'update'){

    try{
        $sql = "UPDATE ITENSVENDA SET DATA = ?, VENDA_ID = ?, PRODUTO_ID = ?, ATENDENTE_ID = ? WHERE VENDA_ID = ?"; 
    
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            $dataLocal,
            $requestData['VENDA_ID'],
            $requestData['PRODUTO_ID'],
            $requestData['ATENDENTE_ID'],
            $requestData['VENDA_ID'],
        ]);
    
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro atualizado com sucesso!'
        );
    
    }catch (PDOExeception $e){
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao atualizar o registro:' .$e
        );
    }
    
    echo json_encode($dados);
    
}

if($requestData['operacao'] == 'delete'){

    try{
        $sql = "DELETE FROM ITENSVENDA WHERE VENDA_ID = ?"; 
    
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            $requestData['VENDA_ID'],
        ]);
    
        $dados = array(
            'type' => 'success',
            'mensagem' => 'Registro deletado com sucesso!'
        );
    
    }catch (PDOExeception $e){
        $dados = array(
            'type' => 'error',
            'mensagem' => 'Erro ao deletar o registro:' .$e
        );
    }
    
    echo json_encode($dados);
    
}