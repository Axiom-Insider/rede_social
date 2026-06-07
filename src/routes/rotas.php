<?php

declare(strict_types=1);



$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$controller = new UsuarioController(new UsuarioService( new UsuarioRepository(Database::getConnection())));

function tipo(string $metodo):void {
      if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        Response::json(405, ["sucesso"=>false]);
    }
}

switch ($url){

    case "/perfil":
        tipo("GET");
        AuthMiddleware::handle();
        $token = AutenticacaoUsuario::validarToken();
        $controller->perfil((int)$token->sub);

        break;

    case "/cadastro":
            tipo("POST");
            $controller->cadastrar();

        break;

    case "/login":
            tipo("POST");
            $controller->login();
        break;

}