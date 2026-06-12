<?php

declare(strict_types=1);



$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$UsuarioController = new UsuarioController(new UsuarioService( new UsuarioRepository(Database::getConnection())));
$PostagemController = new PostagemController(new PostagemService( new PostagemRepository( Database::getConnection())));

function tipo(string $metodo):void {
      if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        Response::json(405, ["sucesso"=>false]);
    }
}

switch ($url){

    case "/api/perfil":
        tipo("GET");
        AuthMiddleware::handle();
        $token = AutenticacaoUsuario::validarToken();
        $UsuarioController->perfil((int)$token->sub);

        break;

    case "/api/cadastro":
            tipo("POST");
            $UsuarioController->cadastrar();

        break;

    case "/api/login":
            tipo("POST");
            $UsuarioController->login();
        break;

    case "/api/postar":
        tipo("POST");
        AuthMiddleware::handle();
        $token = AutenticacaoUsuario::validarToken();
        $PostagemController->postar((int)$token->sub);    
        break;

    case "/api/feed":
        tipo("GET");
        AuthMiddleware::handle();
        $PostagemController->buscar();
        break;
}