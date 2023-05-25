<?php

// onde esta o banco
$hostname = 'localhost: 3308';

// nome do banco de dados 
$dbname = 'sistema_pedidos';

// usuario de acesso
$username = 'root';

// senha de acesso 
$password = 'usbw';

// if e else especifico para debugar demo 

try {
    $pdo = new PDO('mysql:host=' .$hostname. ' ;dbname=' .$dbname, $username, $password); // conexao com o banco

    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // chegar se tem erros e se nao forem graves ou nao tiver, continuar
    // echo 'Conexão com o banco ' .$dbname. ', foi realizada com sucesso!';

} catch (PDOExeception $e) {
    // se o erro for grave mostrar mensagem simples
    echo 'Erro: '.$e->getMenssage();  
}