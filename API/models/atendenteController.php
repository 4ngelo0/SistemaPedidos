<?php

include ('../conexao/conn.php');

$requestData = $_REQUEST;

if($requestData['operacao'] == 'create'){
    try{
    $sql = "INSERT INTO ATENDENTE (NOME, LOGIN, SENHA, ACESSO_ID) VALUES (?, ?, ?, ?)"; 
    $stmt = $pdo->prepare($sql); 

    $stmt->execute([
        $requestData['NOME'],
        $requestData['LOGIN'],
        $requestData['SENHA'],
        $requestData['ACESSO_ID'],
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

if($requestData['operacao'] == 'read'){

    //obter o numero de colunas vindas do front-end
    $colunas = $requestData['columns'];

    //prepara o sql de consulta ao banco
    $sql = "SELECT * FROM ATENDENTE WHERE 1=1";

    // total de registros cadastrados
    $resultado = $pdo->query($sql);
    $qtdeLinhas = $resultado->rowCount();
    
    //verificando se tem algum filtro
    $filtro = $requestData['search']['value'];
    if(isset($filtro)){
        $sql .= " AND (ID LIKE '$filtro%' ";
        $sql .= " OR NOME LIKE '%$filtro%' )";
        $sql .= " OR UNDVENDA LIKE '%$filtro%' )";
        $sql .= " OR VLRVENDA LIKE '%$filtro%' )";
    }

    // total de registros filtrados 
    $resultado = $pdo->query($sql);
    $totalFiltrados = $resultado->rowCount();
    
    //obter valores para gerar ordenação
    $colunaOrdem = $requestData['order'][0]['column']; //posição da colunas
    $ordem = $colunas[$colunasOrdem]['date']; //nome da primeira colunas
    $direcao = $requestData['order'][0]['dir']; //direção colunas

    //obter valores para o limite
    $inicio = $requestData['start'];
    $tamanho = $requestData['length'];  

    //realizar ordenação com limite imposto 
    $sql .= "ORDER BY $ordem $direcao LIMIT $inicio $tamanho";

    $resultado = $pdo->query($sql);
    $dados = array();
    while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $dados[] = array_map(null, $row);
    }

    //criar um objeto retorno do tipo datatable
    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($requestData['qtdeLinhas']),
        "records" => intval($requestData['totalFiltrados']),
        "data" => $dados
    );
}

if($requestData['operacao'] == 'update'){

    try{
        $sql = "UPDATE ATENDENTE SET NOME = ?, LOGIN = ?, SENHA = ?, ACESSO_ID = ?  WHERE ID = ?"; 
    
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            $requestData['NOME'],
            $requestData['LOGIN'],
            $requestData['SENHA'],
            $requestData['ACESSO_ID'],
            $requestData['ID']
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
        $sql = "DELETE FROM ATENDENTE WHERE ID = ?"; 
    
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            $requestData['ID'],
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