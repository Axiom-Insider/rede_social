<?php

declare(strict_types=1);





class AuthMiddleware
{
    public static function handle(): object
    {
        try {

            return AutenticacaoUsuario::validarToken();
        } catch (Throwable $e) {
            Logger::info($e->getMessage());
            Response::json(
                401,
                ["success" => false, "message" => "Não autorizado"]
            );

            exit;
        }
    }
}
