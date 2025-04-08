<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['command'])) {
    $host = '144.22.201.166';
    $port = 9000;            
    $command = $_POST['command'];

    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

    if ($socket === false) {
        echo "Erro ao criar o socket: " . socket_strerror(socket_last_error());
        exit();
    }

    $result = socket_connect($socket, $host, $port);

    if ($result === false) {
        echo "Erro ao conectar ao servidor: " . socket_strerror(socket_last_error($socket));
        socket_close($socket);
        exit();
    }

    socket_write($socket, $command, strlen($command));

    $response = socket_read($socket, 2048);
    echo $response;

    socket_close($socket);
} else {
    echo "Comando inválido.";
}
