<?php

declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AutenticacaoUsuario
{

    public static function validarToken(): object
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            throw new Exception(
                'Token não informado'
            );
        }


        $token = str_replace(
            'Bearer ',
            '',
            $headers['Authorization']
        );
        $secreto = getenv('KEY');

       return JWT::decode(
            $token,
            new Key(
                $secreto,
                'HS256'
            )
        );
    }

    public static function gerarToken(Usuario $usuario): string
    {

        $secreto = getenv("KEY");
        $tempo = (int) getenv("TIME");

        $payload = [
            "sub" => $usuario->getId_usuario(),
            "email" => $usuario->getEmail(),
            "iat" => time(),
            "exp" => time() + $tempo
        ];

        return JWT::encode(
            $payload,
            $secreto,
            'HS256'
        );
    }
}
