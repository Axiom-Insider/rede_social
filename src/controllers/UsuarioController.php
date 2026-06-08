<?php


declare(strict_types=1);

class UsuarioController
{

    public function __construct(private UsuarioService $usuarioService) {}

    public function perfil(int $id_usuario):void{
        $res = $this->usuarioService->perfil($id_usuario);

        if ($res["sucesso"]) {
            Response::json(200, $res);
        }

        Response::json(400, $res);
    }

    public function cadastrar(): void
    {
        $usuario = new Usuario(
            null,
            $_POST["nome"],
            $_POST["email"],
            $_POST["senha"]
            );
        $res = $this->usuarioService->cadastrar($usuario);

        if ($res["sucesso"]) {
            Response::json(200, $res);
        }

        Response::json(400, $res);
    }


    public function login(): void
    {
        $res = $this->usuarioService->login(
            $_POST["senha"],
            $_POST["email"]
        );

        if ($res["sucesso"]) {
            Response::json(
                200,
                $res
            );
        }

        Response::json(
            400,
            $res
        );
    }
}
