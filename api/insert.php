<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post') {
    
    $title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');
    
    if($title && $body) {

        $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:title, :body)");
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->execute();

        //Pega o id que foi inserido
        $id = $pdo->lastInsertId();

        //Preenche o retorno com os itens que foram inseridos
        $array['result'] = [
            'id' => $id,
            'title' => $title,
            'body' => $body
        ];

    } else {
        $array['error'] = 'Campos não enviados';
    }

} else {
    $array['error'] = 'Método não permitido (é permitido apenas POST)';
}

require('../return.php');