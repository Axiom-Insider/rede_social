<?php


declare(strict_types=1);


class  UsuarioException extends Exception{
    public static function nomeInvalido():self
    {
        return new self("Nome de usuário inválido");
    }
    public static function emailInvalido():self
    {
            return new self("Email de usuário inválido");
    }

    public static function senhaCurta():self{
         return new self("Senha muito curta");
    }

    public static function emailEmUso():self{
         return new self("Email já cadastrado");
    }

    public static function usuarioNaoEncontrado():self{
         return new self("Não foi possível encontrar o usuário");
    }

    public static function senhaIncorreta():self{
         return new self("Senha Incorreta");
    }
}