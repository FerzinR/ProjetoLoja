<?php

/*
Vamos construir os cabeçalho para o trabalho a api
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o método de envio com POST, ou seja, como cadastro
header("Access-Control-Allow-Methods:PUT");

#Define o tempo de espera da api. Neste caso é 1 minuto.
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/estoque.php";

$database = new Database();
$db = $database->getConnection();

$estoque = new estoque($db);

/*
O cliente irá enviar os dados no formato json. Porém nós precisamos dos dados
 no formato php para cadastrar em banco de dados. Para realizar essa conversão
 iremos usar o banco json_decode. Assim o cliente enviar os dados, estes são
 lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato
 php.
*/
$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.
if(!empty($data->id_produto) && !empty($data->quantidade)){

    $estoque->id_produto = $data->id_produto;
    $estoque->quantidade = $data->quantidade;
    $estoque->id = $data->id
    
    if($estoque->atualizar()){
        header("HTTP/1.0 201");
        echo json_encode(array("mensagem"=>"estoque cadastrado com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possível cadastrar."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para cadastrar"));
}
?>