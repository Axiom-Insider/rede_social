<?php

declare(strict_types=1);



$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$pdo = Database::getConnection();
$UsuarioController = new UsuarioController(new UsuarioService(new UsuarioRepository($pdo)));
$PostagemController = new PostagemController(new PostagemService(new PostagemRepository($pdo)));
$CurtidaController = new CurtidaController( new CurtidaService( new CurtidaRepository($pdo)));

function tipo(string $metodo): void
{
    if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        Response::json(405, ["sucesso" => false]);
    }
}

switch ($url) {

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
        $token = AutenticacaoUsuario::validarToken();
        $PostagemController->buscarFeed((int)$token->sub);
        break;

    case "/api/feed-perfil":
        tipo("GET");
        AuthMiddleware::handle();
        $token = AutenticacaoUsuario::validarToken();
        $PostagemController->buscarFeedPerfil((int)$token->sub);
        break;

    case "/api/apagar-postagem":
        tipo("DELETE");
        AuthMiddleware::handle();
        $PostagemController->delete((int) $_GET["id_postagem"]);
        break;

    case "/api/adicionar-curtida":
        tipo("POST");
        AuthMiddleware::handle();
        $token = AutenticacaoUsuario::validarToken();
        $CurtidaController->adicionarCurtida((int) $token->sub);
        break;

    case "/api/remover-curtida":
        tipo("DELETE");
        AuthMiddleware::handle();
        $CurtidaController->removerCurtida((int) $_GET["id_curtida"]);
        break;

}
